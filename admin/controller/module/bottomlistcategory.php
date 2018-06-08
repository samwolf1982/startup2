<?php

class ControllerModuleBottomlistcategory extends Controller {
	
	private $error = array(); 
	
	public function index() {   
	
		//Load language file
		$this->load->language('module/bottomlistcategory');

		//Set title from language file
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load settings model
		$this->load->model('setting/setting');
		
		//Save settings
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            Bottomlistcategory::table()->delete([]);
            //  print_r(Bottomlistcategory::find('all'));
            $index=0;     // нужно сместить массивы пока что в цикле
            if ( isset($_POST['categories_id_list']) && is_array($_POST['categories_id_list'])){
                foreach ($_POST['categories_id_list'] as $item) {
                    $bk=new Bottomlistcategory();
                    $bk->category_id=$item;
                    $bk->textval=$_POST['categories_textval_list'][$index];
                    $bk->sort=$_POST['categories_sort_list'][$index];
                    $bk->save();
                    $index++;
                }
                unset($index);
            }




			$this->model_setting_setting->editSetting('bottomlistcategory', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$text_strings = array(
				'heading_title',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'placeholder',
            // own code
            'text_edit',
            'text_enabled',
            'text_disabled',
            'entry_status',

            'entry_category',
            'entry_sort',
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
	
		//error handling
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/bottomlistcategory', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/bottomlistcategory', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

	
		//Check if multiple instances of this module
		$data['modules'] = array();
		
		if (isset($this->request->post['bottomlistcategory_module'])) {
			$data['modules'] = $this->request->post['bottomlistcategory_module'];
		} elseif ($this->config->get('bottomlistcategory_module')) { 
			$data['modules'] = $this->config->get('bottomlistcategory_module');
		}

        if (isset($this->request->post['bottomlistcategory_status'])) {
            $data['bottomlistcategory_status'] = $this->request->post['bottomlistcategory_status'];
        } else {
            $data['bottomlistcategory_status'] = $this->config->get('bottomlistcategory_status');
        }



		//Prepare for display
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');




        $this->load->model('catalog/category');
        foreach ($this->model_catalog_category->getCategories(array()) as $category) {
            $categories_list[] = array( 'category_id' => $category['category_id'], 'name'        => $category['name']);
        }



        //FORM AREA
        //    use $categories_list      -- список всех категорий
        $categories_list_to_select=[];
        foreach ($categories_list as $item) {
            $categories_list_to_select[]=[$item['category_id'],$item['name'],];
        }

        // ancestor
        $this->load->model('tool/ancestorfield');
        //     спрятаный анцестор
        $ancector_colection[]=$this->model_tool_ancestorfield->get_select_input('categories_id_list[]',$categories_list_to_select);
        $ancector_colection[]=$this->model_tool_ancestorfield->get_text_input('categories_textval_list[]');
        $ancector_colection[]=$this->model_tool_ancestorfield->get_text_input('categories_sort_list[]');
        $ancestor=$this->model_tool_ancestorfield->get_ancestor($ancector_colection,'jek');


        $ancestor_data1='';
        // print_r(Bottomlistcategory::find('all'));
        foreach (Bottomlistcategory::find('all') as $item) {    // проход по таблице
            //print_r($item->category_id);
            $ancestor_data_colection[]=    $this->model_tool_ancestorfield->get_select_input('categories_id_list[]',$categories_list_to_select,$item->category_id);
            $ancestor_data_colection[]=$this->model_tool_ancestorfield->get_text_input('categories_textval_list[]',$item->textval);
            $ancestor_data_colection[]=$this->model_tool_ancestorfield->get_text_input('categories_sort_list[]',$item->sort);
            $ancestor_data1.=$this->model_tool_ancestorfield->get_ancestor($ancestor_data_colection); unset($ancestor_data_colection);
        }


        $data['ancestor_data1']=$ancestor_data1;
        $data['ancestor']=$ancestor;


        //Send the output
		$this->response->setOutput($this->load->view('module/bottomlistcategory.tpl', $data));
	}
	
	/*
	 * 
	 * Check that user actions are authorized
	 * 
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/bottomlistcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}


}
?>