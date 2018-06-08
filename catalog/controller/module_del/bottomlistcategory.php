<?php

class ControllerModuleBottomlistcategory extends Controller {
	
	protected function index() {



		//Load language file
		$this->language->load('module/bottomlistcategory');

		//Set title from language file
      	$data['heading_title'] = $this->language->get('heading_title');

		//Load model
		$this->load->model('module/bottomlistcategory');

		//Sample - get data from loaded model
		$data['customers'] = $this->model_module_bottomlistcategory->getCustomerData();

		//Select template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/bottomlistcategory.tpl')) {
			$this->response->setOutput($this->load->view('module/bottomlistcategory.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('module/bottomlistcategory.tpl', $data));
		}

	}
}

?>