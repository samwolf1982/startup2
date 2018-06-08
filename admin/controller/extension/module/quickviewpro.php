<?php
class ControllerExtensionModuleQuickviewpro extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/quickviewpro');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		
		$this->load->model('extension/module/quickviewpro');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_extension_module_quickviewpro->editSettingQuickviewpro('quickviewpro', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['tab_general_setting'] = $this->language->get('tab_general_setting');
		$data['tab_btn_setting'] = $this->language->get('tab_btn_setting');
		$data['tab_on_off_setting'] = $this->language->get('tab_on_off_setting');

	
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_additional_image'] = $this->language->get('entry_additional_image');
		$data['entry_addtocart'] = $this->language->get('entry_addtocart');
		$data['entry_wishlist'] = $this->language->get('entry_wishlist');
		$data['entry_compare'] = $this->language->get('entry_compare');
		$data['entry_tab_description'] = $this->language->get('entry_tab_description');
		$data['entry_specification'] = $this->language->get('entry_specification');
		$data['entry_review_quickview'] = $this->language->get('entry_review_quickview');
		$data['entry_options_count'] = $this->language->get('entry_options_count');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_btn_name'] = $this->language->get('entry_btn_name');
		$data['entry_background_btnaddtocart'] = $this->language->get('entry_background_btnaddtocart');
		$data['entry_textcolor_btnaddtocart'] = $this->language->get('entry_textcolor_btnaddtocart');
		$data['entry_background_btnaddtocart_hover'] = $this->language->get('entry_background_btnaddtocart_hover');
		$data['entry_textcolor_btnaddtocart_hover'] = $this->language->get('entry_textcolor_btnaddtocart_hover');
		$data['entry_background_btnwishlist'] = $this->language->get('entry_background_btnwishlist');
		$data['entry_textcolor_btnwishlist'] = $this->language->get('entry_textcolor_btnwishlist');
		$data['entry_background_btnwishlist_hover'] = $this->language->get('entry_background_btnwishlist_hover');
		$data['entry_textcolor_btnwishlist_hover'] = $this->language->get('entry_textcolor_btnwishlist_hover');
		$data['entry_background_btncompare'] = $this->language->get('entry_background_btncompare');
		$data['entry_textcolor_btncompare'] = $this->language->get('entry_textcolor_btncompare');
		$data['entry_background_btncompare_hover'] = $this->language->get('entry_background_btncompare_hover');
		$data['entry_textcolor_btncompare_hover'] = $this->language->get('entry_textcolor_btncompare_hover');
		
		$data['entry_on_off_featured_quickview'] = $this->language->get('entry_on_off_featured_quickview');
		$data['entry_on_off_latest_quickview'] = $this->language->get('entry_on_off_latest_quickview');
		$data['entry_on_off_bestseller_quickview'] = $this->language->get('entry_on_off_bestseller_quickview');
		$data['entry_on_off_special_quickview'] = $this->language->get('entry_on_off_special_quickview');
		$data['entry_on_off_category_page_quickview'] = $this->language->get('entry_on_off_category_page_quickview');
		$data['entry_on_off_manufacturer_page_quickview'] = $this->language->get('entry_on_off_manufacturer_page_quickview');
		$data['entry_on_off_search_page_quickview'] = $this->language->get('entry_on_off_search_page_quickview');
		$data['entry_on_off_special_page_quickview'] = $this->language->get('entry_on_off_special_page_quickview');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/quickviewpro', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/quickviewpro', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/quickviewpro', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/quickviewpro', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

		

		$data['token'] = $this->session->data['token'];

		

		$this->load->model('catalog/product');
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		
		if (isset($this->request->post['status_quickview'])) {
			$data['status_quickview'] = $this->request->post['status_quickview'];
		} else {
			$data['status_quickview'] = $this->config->get('status_quickview');
		}
		if (isset($this->request->post['config_quickview_additional_image'])) {
			$data['config_quickview_additional_image'] = $this->request->post['config_quickview_additional_image'];
		} else {
			$data['config_quickview_additional_image'] = $this->config->get('config_quickview_additional_image');
		}
		if (isset($this->request->post['config_quickview_addtocart'])) {
			$data['config_quickview_addtocart'] = $this->request->post['config_quickview_addtocart'];
		} else {
			$data['config_quickview_addtocart'] = $this->config->get('config_quickview_addtocart');
		}
		if (isset($this->request->post['config_quickview_wishlist'])) {
			$data['config_quickview_wishlist'] = $this->request->post['config_quickview_wishlist'];
		} else {
			$data['config_quickview_wishlist'] = $this->config->get('config_quickview_wishlist');
		}
		if (isset($this->request->post['config_quickview_compare'])) {
			$data['config_quickview_compare'] = $this->request->post['config_quickview_compare'];
		} else {
			$data['config_quickview_compare'] = $this->config->get('config_quickview_compare');
		}
		if (isset($this->request->post['config_quickview_tab_description'])) {
			$data['config_quickview_tab_description'] = $this->request->post['config_quickview_tab_description'];
		} else {
			$data['config_quickview_tab_description'] = $this->config->get('config_quickview_tab_description');
		}
		if (isset($this->request->post['config_quickview_tab_specification'])) {
			$data['config_quickview_tab_specification'] = $this->request->post['config_quickview_tab_specification'];
		} else {
			$data['config_quickview_tab_specification'] = $this->config->get('config_quickview_tab_specification');
		}
		if (isset($this->request->post['config_quickview_tab_review_quickview'])) {
			$data['config_quickview_tab_review_quickview'] = $this->request->post['config_quickview_tab_review_quickview'];
		} else {
			$data['config_quickview_tab_review_quickview'] = $this->config->get('config_quickview_tab_review_quickview');
		}
		if (isset($this->request->post['config_quickview_options_count'])) {
			$data['config_quickview_options_count'] = $this->request->post['config_quickview_options_count'];
		} else {
			$data['config_quickview_options_count'] = $this->config->get('config_quickview_options_count');
		}
		if (isset($this->request->post['config_quickview_manufacturer'])) {
			$data['config_quickview_manufacturer'] = $this->request->post['config_quickview_manufacturer'];
		} else {
			$data['config_quickview_manufacturer'] = $this->config->get('config_quickview_manufacturer');
		}
		if (isset($this->request->post['config_quickview_model'])) {
			$data['config_quickview_model'] = $this->request->post['config_quickview_model'];
		} else {
			$data['config_quickview_model'] = $this->config->get('config_quickview_model');
		}
		if (isset($this->request->post['config_quickview_quantity'])) {
			$data['config_quickview_quantity'] = $this->request->post['config_quickview_quantity'];
		} else {
			$data['config_quickview_quantity'] = $this->config->get('config_quickview_quantity');
		}
		if (isset($this->request->post['config_quickview_btn_name'])) {
			$data['config_quickview_btn_name'] = $this->request->post['config_quickview_btn_name'];
		} else {
			$data['config_quickview_btn_name'] = $this->config->get('config_quickview_btn_name');
		}
		
		if (isset($this->request->post['config_quickview_background_btnaddtocart'])) {
			$data['config_quickview_background_btnaddtocart'] = $this->request->post['config_quickview_background_btnaddtocart'];
		} else {
			$data['config_quickview_background_btnaddtocart'] = $this->config->get('config_quickview_background_btnaddtocart');
		}
		if (isset($this->request->post['config_quickview_textcolor_btnaddtocart'])) {
			$data['config_quickview_textcolor_btnaddtocart'] = $this->request->post['config_quickview_textcolor_btnaddtocart'];
		} else {
			$data['config_quickview_textcolor_btnaddtocart'] = $this->config->get('config_quickview_textcolor_btnaddtocart');
		}
		if (isset($this->request->post['config_quickview_background_btnaddtocart_hover'])) {
			$data['config_quickview_background_btnaddtocart_hover'] = $this->request->post['config_quickview_background_btnaddtocart_hover'];
		} else {
			$data['config_quickview_background_btnaddtocart_hover'] = $this->config->get('config_quickview_background_btnaddtocart_hover');
		}
		if (isset($this->request->post['config_quickview_textcolor_btnaddtocart_hover'])) {
			$data['config_quickview_textcolor_btnaddtocart_hover'] = $this->request->post['config_quickview_textcolor_btnaddtocart_hover'];
		} else {
			$data['config_quickview_textcolor_btnaddtocart_hover'] = $this->config->get('config_quickview_textcolor_btnaddtocart_hover');
		}
		
		if (isset($this->request->post['config_quickview_background_btnwishlist'])) {
			$data['config_quickview_background_btnwishlist'] = $this->request->post['config_quickview_background_btnwishlist'];
		} else {
			$data['config_quickview_background_btnwishlist'] = $this->config->get('config_quickview_background_btnwishlist');
		}
		if (isset($this->request->post['config_quickview_textcolor_btnwishlist'])) {
			$data['config_quickview_textcolor_btnwishlist'] = $this->request->post['config_quickview_textcolor_btnwishlist'];
		} else {
			$data['config_quickview_textcolor_btnwishlist'] = $this->config->get('config_quickview_textcolor_btnwishlist');
		}
		if (isset($this->request->post['config_quickview_background_btnwishlist_hover'])) {
			$data['config_quickview_background_btnwishlist_hover'] = $this->request->post['config_quickview_background_btnwishlist_hover'];
		} else {
			$data['config_quickview_background_btnwishlist_hover'] = $this->config->get('config_quickview_background_btnwishlist_hover');
		}
		if (isset($this->request->post['config_quickview_textcolor_btnwishlist_hover'])) {
			$data['config_quickview_textcolor_btnwishlist_hover'] = $this->request->post['config_quickview_textcolor_btnwishlist_hover'];
		} else {
			$data['config_quickview_textcolor_btnwishlist_hover'] = $this->config->get('config_quickview_textcolor_btnwishlist_hover');
		}
		
		if (isset($this->request->post['config_quickview_background_btncompare'])) {
			$data['config_quickview_background_btncompare'] = $this->request->post['config_quickview_background_btncompare'];
		} else {
			$data['config_quickview_background_btncompare'] = $this->config->get('config_quickview_background_btncompare');
		}
		if (isset($this->request->post['config_quickview_textcolor_btncompare'])) {
			$data['config_quickview_textcolor_btncompare'] = $this->request->post['config_quickview_textcolor_btncompare'];
		} else {
			$data['config_quickview_textcolor_btncompare'] = $this->config->get('config_quickview_textcolor_btncompare');
		}
		if (isset($this->request->post['config_quickview_background_btncompare_hover'])) {
			$data['config_quickview_background_btncompare_hover'] = $this->request->post['config_quickview_background_btncompare_hover'];
		} else {
			$data['config_quickview_background_btncompare_hover'] = $this->config->get('config_quickview_background_btncompare_hover');
		}
		if (isset($this->request->post['config_quickview_textcolor_btncompare_hover'])) {
			$data['config_quickview_textcolor_btncompare_hover'] = $this->request->post['config_quickview_textcolor_btncompare_hover'];
		} else {
			$data['config_quickview_textcolor_btncompare_hover'] = $this->config->get('config_quickview_textcolor_btncompare_hover');
		}
		
		if (isset($this->request->post['config_on_off_featured_quickview'])) {
			$data['config_on_off_featured_quickview'] = $this->request->post['config_on_off_featured_quickview'];
		} else {
			$data['config_on_off_featured_quickview'] = $this->config->get('config_on_off_featured_quickview');
		}
		if (isset($this->request->post['config_on_off_latest_quickview'])) {
			$data['config_on_off_latest_quickview'] = $this->request->post['config_on_off_latest_quickview'];
		} else {
			$data['config_on_off_latest_quickview'] = $this->config->get('config_on_off_latest_quickview');
		}
		if (isset($this->request->post['config_on_off_bestseller_quickview'])) {
			$data['config_on_off_bestseller_quickview'] = $this->request->post['config_on_off_bestseller_quickview'];
		} else {
			$data['config_on_off_bestseller_quickview'] = $this->config->get('config_on_off_bestseller_quickview');
		}
		if (isset($this->request->post['config_on_off_special_quickview'])) {
			$data['config_on_off_special_quickview'] = $this->request->post['config_on_off_special_quickview'];
		} else {
			$data['config_on_off_special_quickview'] = $this->config->get('config_on_off_special_quickview');
		}
		if (isset($this->request->post['config_on_off_category_page_quickview'])) {
			$data['config_on_off_category_page_quickview'] = $this->request->post['config_on_off_category_page_quickview'];
		} else {
			$data['config_on_off_category_page_quickview'] = $this->config->get('config_on_off_category_page_quickview');
		}
		if (isset($this->request->post['config_on_off_search_page_quickview'])) {
			$data['config_on_off_search_page_quickview'] = $this->request->post['config_on_off_search_page_quickview'];
		} else {
			$data['config_on_off_search_page_quickview'] = $this->config->get('config_on_off_search_page_quickview');
		}
		if (isset($this->request->post['config_on_off_manufacturer_page_quickview'])) {
			$data['config_on_off_manufacturer_page_quickview'] = $this->request->post['config_on_off_manufacturer_page_quickview'];
		} else {
			$data['config_on_off_manufacturer_page_quickview'] = $this->config->get('config_on_off_manufacturer_page_quickview');
		}
		if (isset($this->request->post['config_on_off_special_page_quickview'])) {
			$data['config_on_off_special_page_quickview'] = $this->request->post['config_on_off_special_page_quickview'];
		} else {
			$data['config_on_off_special_page_quickview'] = $this->config->get('config_on_off_special_page_quickview');
		}
		
		


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/quickviewpro', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/quickviewpro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}