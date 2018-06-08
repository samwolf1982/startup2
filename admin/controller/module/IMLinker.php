<?php
class ControllerModuleIMLinker extends Controller {
	private $error = array(); 

	/////////////////////////////////////////
	// Основные экшены
	/////////////////////////////////////////
	
	// Стартовая страница контроллера
	public function index() {   
		$this->load->language('module/IMLinker');

		$this->document->setTitle($this->language->get('curr_heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('module/IMLinker');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('IMLinker', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/IMLinker', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		// Данные
		$data = array();
		
		////////////////////////////////////
		// Стандартные данные
		////////////////////////////////////
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['h1_text'] = $this->language->get('heading_title_h1');
		$data['h2_text'] = $this->language->get('heading_title_h2');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		////////////////////////////////////
		// Добавленные данные
		////////////////////////////////////
		$data['text_none'] = $this->language->get('text_none');

		// Кнопки и подписи
		$data['module_label'] = $this->language->get('module_label');
		$data['module_btn_label'] = $this->language->get('module_btn_label');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		////////////////////////////////////
		// Строим хлебные крошки
		////////////////////////////////////
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/IMLinker', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		////////////////////////////////////
		// Формируем ссылки
		////////////////////////////////////

		$data['replace'] = $this->url->link('module/IMLinker/replace', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['modules'] = array();
		
		$data['module_links'] = array(
			'generateSeo'
				=> $this->url->link('module/IMLinker/generateSeo', 'token=' . $this->session->data['token'], 'SSL'),
			'cancel' 
				=> $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'getSettings'
				=> $this->url->link('module/IMLinker/getSettings', 'token=' . $this->session->data['token'], 'SSL'),
			'saveSettings'
				=> $this->url->link('module/IMLinker/saveSettings', 'token=' . $this->session->data['token'], 'SSL'),
			'deleteSettings'
				=> $this->url->link('module/IMLinker/deleteSettings', 'token=' . $this->session->data['token'], 'SSL'),
			'getProductList'
				=> $this->url->link('module/IMLinker/getProductList', 'token=' . $this->session->data['token'], 'SSL'),
			// 1.3
			'generateSeoById'
				=> $this->url->link('module/IMLinker/generateSeoById', 'token=' . $this->session->data['token'], 'SSL'),
		);
		////////////////////////////////////
		// Стандартная подгрузка данных и вывод на шаблон
		////////////////////////////////////
		if (isset($this->request->post['IMLinker_module'])) {
			$data['modules'] = $this->request->post['IMLinker_module'];
		} elseif ($this->config->get('IMLinker_module')) { 
			$data['modules'] = $this->config->get('IMLinker_module');
		}	
		
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();

		$template = 'module/IMLinker.tpl';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		setcookie('token', $this->session->data['token']);
		
		$this->getForm($data);

		// 1.3 
		$data['linker_schema_view'] = $this->load->controller('module/IMLinker/schemaView', $data);

		$this->response->setOutput($this->load->view($template, $data));
	}

	// 1.3
	////////////////////////////////////////////
	// Схемы
	////////////////////////////////////////////
	// Вьюха по клиентам
	public function schemaView($data = array())
	{
		//$this->data = array_merge($this->data, $data);
		
		//$template = 'module/IMLinker.tpl';
		//$this->template = 'module/IMLinker_schema.tpl';
		//$this->response->setOutput($this->render ());
		return $this->load->view('module/IMLinker_schema.tpl', $data);
	}

	// Функция подгрузки списка языков
	private function getForm(&$data) {
		// Формируем список языков
		$this->load->model('localisation/language');
		$langs = $this->model_localisation_language->getLanguages();
		$data['languages'] = $langs;
		$list_langs = array();
		foreach($langs as $key => $item)
		{
			$list_langs[] = array_merge(array('key_code' => $key), $item);
		}
		$data['list_langs'] = $list_langs;

		// Загружаем категории
		$categories = $this->model_module_IMLinker->getCategories(0);
		$firstItem = array();
		/*
		$firstItem[] = array(
			'id' => -1,
			'name' => 'Все категории',
			'status' => 1,
			'sort_order' => -1
		);
		*/ 
		$categories = array_merge($firstItem, $categories);

		$data['list_cat'] = $categories;

		// Выбор главной категории
		$list_main = array();
		$list_main[] = array( 'id' => 0, 'name' => 'Везде, где категория встречается');
		$list_main[] = array( 'id' => 1, 'name' => 'Только там, где категория главная');
		$data['list_main'] = $list_main;

		// Список чисел от 1 до 100 для количества элементов
		$list_generate_count = array();
		for ($cnt_list = 0; $cnt_list <= 100; $cnt_list++)
		{
			$list_generate_count[] = array( 'id' => $cnt_list, 'name' => $cnt_list);
		}
		$data['list_generate_count'] = $list_generate_count;

		// Коэффициент важности
		$list_generate_import = array();
		for ($cnt_list = 0.1; $cnt_list <= 10; $cnt_list+= 0.1)
		{
			$list_generate_import[] = array( 'id' => $cnt_list, 'name' => $cnt_list);
		}
		$data['list_generate_import'] = $list_generate_import;

		// Порядок сортировки товаров
		$list_product_order = $this->model_module_IMLinker->getProductOrder();
		$data['list_product_order'] = $list_product_order;

		// 1.3
		//////////////////////////////
		// Списки настроек
		//////////////////////////////
		$data['list_pattern_list'] = array();
		$dataMLCP = array('type'=>'mlcp');
		$list_pattern_list_mlcp = $this->model_module_IMLinker->getSettingsList($dataMLCP);
		$dataSchema = array('type'=>'schema');
		$list_pattern_list_schema = $this->model_module_IMLinker->getSettingsList($dataSchema);
		$data['list_pattern_list']['mlcp'] = $list_pattern_list_mlcp;
		$data['list_pattern_list']['schema'] = $list_pattern_list_schema;

		// 1.3
		//////////////////////////////
		// Списки шаблонов без схем
		//////////////////////////////
		$list_all_pattern_list_without_schema = $this->model_module_IMLinker->getSettingsListWithoutSchema();
		$data['list_all_pattern_list_without_schema'] = $list_all_pattern_list_without_schema;


		// Загружаем производителей
		$manufacturers = $this->model_module_IMLinker->getManufacturer();
		$data['list_manufact'] = $manufacturers;

		//////////////////////////////
		// Список атрибутов
		//////////////////////////////
		$list_attr = $this->model_module_IMLinker->getAttributeList();
		$data['list_attr'] = $list_attr;

		//////////////////////////////
		// Список опций
		//////////////////////////////
		$list_option_data = $this->model_module_IMLinker->getOptionWithValuesList();
		// Полный набор данных
		$data['list_option_data'] = $list_option_data;
		// Формируем просто список опций
		$last_option_id = '-1';
		$list_option = array();
		foreach ($list_option_data as $item_option)
		{
			if (''.$item_option['option_id'] == $last_option_id)
				continue;
			
			$last_option_id = ''.$item_option['option_id'];
			
			$list_option[] = array('id' => $item_option['option_id'], 'name' => $item_option['option_name']);
		}
		// Полный набор данных
		$data['list_option'] = $list_option;
		
		//////////////////////////////
		// Поддержка языков
		//////////////////////////////
		if (version_compare('2.2', VERSION) <= 0) {
			foreach ($data['languages'] as $key => $language) {
				$data['languages'][$key]['imgsrc'] = 'language/' . $language['code'] . '/' . $language['code'] . '.png';
			}
		}else{
			foreach ($data['languages'] as $key => $language) {
				$data['languages'][$key]['imgsrc'] = 'view/image/flags/' . $language['image'];
			}
		}
		
		$data['token'] = $this->session->data['token'];
	}

	// Получить настройки
	public function getSettings(){
		$this->load->model('module/IMLinker');
		$json = array();
		
		$json['settings'] = $this->model_module_IMLinker->getSettings($this->request->post['IMLinker']);
		$json['success'] = 1;
		
		$this->response->setOutput(json_encode($json));
	}

	// Сохранение шаблона замены
	public function saveSettings() {
		if($this->validate()) {
			$this->load->model('module/IMLinker');
			$json = array();
			$this->model_module_IMLinker->saveSettings($this->request->post['IMLinker']);
			$json['success'] = 1;
			$json['pattern_list'] = $this->model_module_IMLinker->getSettingsList($this->request->post['IMLinker']);
			// 1.3
			// Списки шаблонов без схем
			$list_all_pattern_list_without_schema = $this->model_module_IMLinker->getSettingsListWithoutSchema();
			$json['pattern_list_without_schema'] = $list_all_pattern_list_without_schema;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMLinker');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// Удаление шаблона замены
	public function deleteSettings() {
		if($this->validate()) {
			$this->load->model('module/IMLinker');
			$json = array();
			$this->model_module_IMLinker->deleteSettings($this->request->post['IMLinker']);
			$json['success'] = 1;
			$json['pattern_list'] = $this->model_module_IMLinker->getSettingsList($this->request->post['IMLinker']);
			// 1.3
			// Списки шаблонов без схем
			$list_all_pattern_list_without_schema = $this->model_module_IMLinker->getSettingsListWithoutSchema();
			$json['pattern_list_without_schema'] = $list_all_pattern_list_without_schema;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMLinker');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// Запуск генерации
	public function generateSeo() {
		if($this->validate()) {
			$this->load->model('module/IMLinker');
			$json = array();
			$this->model_module_IMLinker->generateSeo($this->request->post['IMLinker']);
			$json['success'] = 1;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMLinker');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// 1.3
	// Запуск генерации
	public function generateSeoById() {
		if($this->validate()) {
			$this->load->model('module/IMLinker');
			$json = array();
			$this->model_module_IMLinker->generateSeoById($this->request->post['IMLinker']);
			$json['success'] = 1;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMLinker');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// Получение списка категории
	public function getProductList() {
		if($this->validate()) {
			$this->load->model('module/IMLinker');
			$json = array();
			$json['data'] = $this->model_module_IMLinker->getProductList($this->request->post['IMLinker']);
			$json['success'] = 1;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMLinker');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// 1.3
	/////////////////////////////////////////
	// Вспомогательные функции
	/////////////////////////////////////////

	// Добавление кода
	protected function addPHPCode($path, $sign, $searchcode, $addCode)
	{
		$content = file_get_contents($path);
		$content = str_replace(
			$searchcode, 
			$searchcode
			. '/* ' . $sign . ' Start */'
				.$addCode
			. '/* ' . $sign . ' End */', 
			$content
		);

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}
	
	// Удаление кода
	protected function removePHPCode($path, $sign)
	{
		$content = file_get_contents($path);

		preg_match_all('!(\/\*)\s?' . $sign . ' Start.+?' . $sign . ' End\s+?(\*\/)!is', $content, $matches);
		foreach ($matches[0] as $match) {
			$content = str_replace($match, '', $content);
		}

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}
	
	/////////////////////////////////////////
	// Установка / Деинсталляция
	/////////////////////////////////////////

	// Установка модуля
	public function install() {
        $this->load->model('module/IMLinker');
		$this->model_module_IMLinker->install();
		
		// Указываем, что модуль установлен
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('IMLinker', array('IMLinker_status'=>1));
        
        // Перенаправляем на главную страницу
		$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
	}
	
	// Деинсталляция модуля
    public function uninstall() {
        $this->load->model('module/IMLinker');
		$this->model_module_IMLinker->uninstall();
		
		// Указываем, что модуль удален
	 	$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('IMLinker', array('IMLinker_status'=>0));
        
        // Перенаправляем на главную страницу
		$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
    
    }

	/////////////////////////////////////////
	// Валидация
	/////////////////////////////////////////
	
	// Проверка, что у пользователя есть необходимые права
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/IMLinker')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
