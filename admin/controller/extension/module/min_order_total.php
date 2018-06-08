<?php
class ControllerExtensionModuleMinOrderTotal extends Controller {
	private $error = array(); 
	private $version = '1.7';
	
	public function index() {   
		$this->load->language('extension/module/min_order_total');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('min_order_total', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
		
		// set currency to default currency - to avoid getting wrong default currency if was changed in front store
		$this->session->data['currency'] = $this->config->get('config_currency');
				
		$data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->version;
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['tab_setting'] = $this->language->get('tab_setting');
		$data['tab_help'] = $this->language->get('tab_help');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_use_total'] = $this->language->get('text_use_total');
		$data['text_use_subtotal'] = $this->language->get('text_use_subtotal');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_total_type'] = $this->language->get('entry_total_type');
		$data['entry_min_order_amount'] = $this->language->get('entry_min_order_amount');
		$data['entry_subtotal_warning'] = $this->language->get('entry_subtotal_warning');
		$data['entry_total_warning'] = $this->language->get('entry_total_warning');
		
		$data['help_min_order_amount'] = $this->language->get('help_min_order_amount');
		$data['help_subtotal_warning'] = $this->language->get('help_subtotal_warning');
		$data['help_total_warning'] = $this->language->get('help_total_warning');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['min_order_amount'])) {
			$data['error_min_order_amount'] = $this->error['min_order_amount'];
		} else {
			$data['error_min_order_amount'] = '';
		}
		
		if (isset($this->error['subtotal_message'])) {
			$data['error_subtotal_message'] = $this->error['subtotal_message'];
		} else {
			$data['error_subtotal_message'] = '';
		}
		
		if (isset($this->error['total_message'])) {
			$data['error_total_message'] = $this->error['total_message'];
		} else {
			$data['error_total_message'] = '';
		}		
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/min_order_total', 'token=' . $this->session->data['token'], true)
   		);
		
		$data['action'] = $this->url->link('extension/module/min_order_total', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->update_check();
		
		if (isset($this->error['update'])) {
			$data['update'] = $this->error['update'];
		} else {
			$data['update'] = '';
		}		
		
		if (isset($this->request->post['min_order_total_status'])){
			$data['min_order_total_status'] = $this->request->post['min_order_total_status'];
		} elseif ( $this->config->get('min_order_total_status')){
			$data['min_order_total_status'] = $this->config->get('min_order_total_status');
		} else {
			$data['min_order_total_status'] = '';
		}
		
		if (isset($this->request->post['min_order_total_type'])){
			$data['min_order_total_type'] = $this->request->post['min_order_total_type'];
		} elseif ( $this->config->get('min_order_total_type')){
			$data['min_order_total_type'] = $this->config->get('min_order_total_type');
		} else {
			$data['min_order_total_type'] = '';
		}
		
		if (isset($this->request->post['min_order_total_amount'])){
			$data['min_order_total_amount'] = $this->request->post['min_order_total_amount'];
		} elseif ( $this->config->get('min_order_total_amount')){
			$data['min_order_total_amount'] = $this->config->get('min_order_total_amount');
		} else {
			$data['min_order_total_amount'] = '';
		}
		
		if (isset($this->request->post['min_order_total_message'])){
			$data['min_order_total_message'] = $this->request->post['min_order_total_message'];
		} elseif ( $this->config->get('min_order_total_message')){
			$data['min_order_total_message'] = $this->config->get('min_order_total_message');
		} else {
			$data['min_order_total_message'] = '';
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$currency_symbol_left = $this->currency->getSymbolLeft($this->session->data['currency']);
		$currency_symbol_right = $this->currency->getSymbolRight($this->session->data['currency']);
		
		if (!empty($currency_symbol_left)) {
			$data['currency_symbol'] = $currency_symbol_left;
		} else {
			$data['currency_symbol'] = $currency_symbol_right;
		}		
		
		$data['token'] = $this->session->data['token'];
						
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/min_order_total', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/min_order_total')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (utf8_strlen($this->request->post['min_order_total_amount']) < 1 || !is_numeric($this->request->post['min_order_total_amount'])){
			$this->error['min_order_amount'] = $this->language->get('error_min_order_amount');
		}

		foreach ($this->request->post['min_order_total_message'] as $language_id => $value) {
			if ($this->request->post['min_order_total_type'] == 'subtotal') {
				if (utf8_strlen($value['subtotal_message']) < 1) {
					$this->error['subtotal_message'][$language_id] = $this->language->get('error_subtotal_warning');
				} elseif (strpos($value['subtotal_message'], "{min_order_total}") === false) {
					$this->error['subtotal_message'][$language_id] = $this->language->get('error_no_required_value');
				}
			}

			if ($this->request->post['min_order_total_type'] == 'total') {				
				if (utf8_strlen($value['total_message']) < 1) {
					$this->error['total_message'][$language_id] = $this->language->get('error_total_warning');
				} elseif (strpos($value['total_message'], "{min_order_total}") === false) {
					$this->error['total_message'][$language_id] = $this->language->get('error_no_required_value');
				}
			}	
		}		
				
		return !$this->error;	
	}
	
		private function update_check() {
		$data = 'v=' . $this->version . '&ex=17&e=' . $this->config->get('config_email') . '&ocv=' . VERSION;
        $curl = false;
        
        if (extension_loaded('curl')) {
			$ch = curl_init();
			
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_URL, 'https://www.oc-extensions.com/api/v1/update_check');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'OCX-Adaptor: curl'));
			curl_setopt($ch, CURLOPT_REFERER, HTTP_CATALOG);
			
			if (function_exists('gzinflate')) {
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
			}
            
			$result = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($http_code == 200) {
				$result = json_decode($result);
				
                if ($result) {
                    $curl = true;
                }
                
                if ( isset($result->version) && ($result->version > $this->version) ) {
				    $this->error['update'] = 'A new version of this extension is available. <a target="_blank" href="' . $result->url . '">Click here</a> to see the Changelog.';
				}
			}
		}
        
        if (!$curl) {
			if (!$fp = @fsockopen('ssl://www.oc-extensions.com', 443, $errno, $errstr, 20)) {
				return false;
			}

			socket_set_timeout($fp, 20);
			
			$headers = array();
			$headers[] = "POST /api/v1/update_check HTTP/1.0";
			$headers[] = "Host: www.oc-extensions.com";
			$headers[] = "Referer: " . HTTP_CATALOG;
			$headers[] = "OCX-Adaptor: socket";
			if (function_exists('gzinflate')) {
				$headers[] = "Accept-encoding: gzip";
			}	
			$headers[] = "Content-Type: application/x-www-form-urlencoded";
			$headers[] = "Accept: application/json";
			$headers[] = 'Content-Length: '.strlen($data);
			$request = implode("\r\n", $headers)."\r\n\r\n".$data;
			fwrite($fp, $request);
			$response = $http_code = null;
			$in_headers = $at_start = true;
			$gzip = false;
			
			while (!feof($fp)) {
				$line = fgets($fp, 4096);
				
				if ($at_start) {
					$at_start = false;
					
					if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
						return false;
					}
					
					$http_code = $m[2];
					continue;
				}
				
				if ($in_headers) {

					if (trim($line) == '') {
						$in_headers = false;
						continue;
					}

					if (!preg_match('/([^:]+):\\s*(.*)/', $line, $m)) {
						continue;
					}
					
					if ( strtolower(trim($m[1])) == 'content-encoding' && trim($m[2]) == 'gzip') {
						$gzip = true;
					}
					
					continue;
				}
				
                $response .= $line;
			}
					
			fclose($fp);
			
			if ($http_code == 200) {
				if ($gzip && function_exists('gzinflate')) {
					$response = substr($response, 10);
					$response = gzinflate($response);
				}
				
				$result = json_decode($response);
				
                if ( isset($result->version) && ($result->version > $this->version) ) {
				    $this->error['update'] = 'A new version of this extension is available. <a target="_blank" href="' . $result->url . '">Click here</a> to see the Changelog.';
				}
			}
		}
	}
}
?>