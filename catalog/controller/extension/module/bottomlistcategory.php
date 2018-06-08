<?php

class ControllerExtensionModuleBottomlistcategory extends Controller {

	public function index() {
		//Load language file
		$this->language->load('module/bottomlistcategory');

		//Set title from language file
      	$data['heading_title'] = $this->language->get('heading_title');

		//Load model
		$this->load->model('module/bottomlistcategory');

		//Sample - get data from loaded model
		$data['customers'] = $this->model_module_bottomlistcategory->getCustomerData();


//        Book::find('all', array('order' => 'title desc'));
        $this->load->model('catalog/category');
        $ready_category_list=[];
        foreach (Bottomlistcategory::find('all',array('order' => 'sort asc')) as $item) {    // проход по таблице
            if (empty($item->textval)){
                $cat_list_id[]=$item->category_id;
                 $cat= $this->model_catalog_category->getCategory($item->category_id);
                 if (isset($cat['name'])){ $ready_category_list[]=['url'=>$this->url->link('product/category', 'path=' . $item->category_id) ,'text'=> $cat['name']];  }

            }else{
                $ready_category_list[]=['url'=>$this->url->link('product/category', 'path=' . $item->category_id) ,'text'=>$item->textval];
            }
        }
        $data['ready_category_list']=$ready_category_list;




		//Select template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/bottomlistcategory.tpl')) {
            return $this->load->view('module/bottomlistcategory', $data);
			//$this->response->setOutput($this->load->view('module/bottomlistcategory.tpl', $data));

		} else {
            return $this->load->view('module/bottomlistcategory', $data);
			//$this->response->setOutput($this->load->view('module/bottomlistcategory.tpl', $data));

		}
	}
}
?>