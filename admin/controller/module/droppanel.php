<?php

class ControllerModuleDroppanel extends Controller {
	
	private $error = array(); 
	
	public function index() {   
	
		//Load language file
		$this->load->language('module/droppanel');

		//Set title from language file
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load settings model
		$this->load->model('setting/setting');
		
		//Save settings
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('droppanel', $this->request->post);		
					
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
            'text_edit',
            'text_enabled',
            'text_disabled',
            'entry_status',
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
			'href'      => $this->url->link('module/droppanel', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/droppanel', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

	
		//Check if multiple instances of this module
		$data['modules'] = array();
		
		if (isset($this->request->post['droppanel_status'])) {
			$data['droppanel_status'] = $this->request->post['droppanel_status'];
		} elseif ($this->config->get('droppanel_status')) {
			$data['droppanel_status'] = $this->config->get('droppanel_status');
		}
//        if (isset($this->request->post['bottomlistcategory_status'])) {
//            $data['bottomlistcategory_status'] = $this->request->post['bottomlistcategory_status'];
//        } else {
//            $data['bottomlistcategory_status'] = $this->config->get('bottomlistcategory_status');
//        }




		//Prepare for display
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		//Send the output
		$this->response->setOutput($this->load->view('module/droppanel.tpl', $data));
	}
	
	/*
	 * 
	 * Check that user actions are authorized
	 * 
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/droppanel')) {
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