<?php
class ModelModuleIMLinker extends Model {

	/////////////////////////////////////////
	// Установка
	/////////////////////////////////////////
  
	public function install() 
	{
		// Создаем таблицы
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imlinker_pattern_set` (
			  `pattern_set_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `type` varchar(255) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `params` text NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imlinker_mlcp_temp` (
			  `product_id` int(11) NOT NULL,
			  `number` int(11) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);
	}

	/////////////////////////////////////////
	// Деинсталляция
	/////////////////////////////////////////

	public function uninstall() 
	{
	}

	/////////////////////////////////////////
	// Функции с настройками
	/////////////////////////////////////////

	// Дефолтные параметры
	public function getDefaultSet() 
	{
		return array(
		);	
	}

	// Получения настроек
	public function getSettings($data)
	{
		$settings = array();

		// Настройки по умолчанию
		$settings = $this->getDefaultSet();

		// Получаем данные
		$pattern_set_id = $this->getPostValue($data, 'pattern_list', '-1');

		// Подгружаем шабюлон
		$query = $this->db->query(
			"SELECT * " 
			. " FROM " . DB_PREFIX . "imlinker_pattern_set im "
			. " WHERE im.pattern_set_id = " . $pattern_set_id
		);
		
		if ($query->num_rows > 0) 
		{
			// Вытаскиваем настройки
			foreach ($query->rows as $result) 
			{
				if (!empty($result['params']))
				{
					$params = json_decode($result['params'], true);
					
					if (empty($params)) 
					{
						continue;
					}
					
					foreach($params as $key=>$value)
					{
						if (!is_array($value))
						{
							$params[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');	
						}
					}
					
					if (!empty($params))
					{
						// Сохраняем для языка настройки
						$settings = array_merge($settings, $params);
					}
				}
			}
		}
		
		
		return $settings;
	}

	// Удаление настроек для языков
	public function deleteSettings($data)
	{
		$pattern_set_id = $this->getPostValue($data, 'pattern_list', '-1');
		
		$deleteQuery = 
			'delete from ' . DB_PREFIX . 'imlinker_pattern_set '
			. 'where pattern_set_id = ' . $pattern_set_id
		;
		
		$this->db->query($deleteQuery);
	}

	// Сохранение настроек для языков
	public function saveSettings($data)
	{
		// Получаем настройки
		$pattern_name = $this->lenCut(trim($this->getPostValue($data, 'pattern_name', '-1')), 255);
		$type = $this->getPostValue($data, 'type', '-1');
		$params = json_encode($data);

		if ($pattern_name == '')
			return;

		$result = $this->db->query(
			'select * from ' . DB_PREFIX . 'imlinker_pattern_set'
			. ' where type = \'' . $type . '\' '
				. ' and name = \'' . $pattern_name . '\''
		);

		if ($result->num_rows) {
			$this->db->query(
					"update " . DB_PREFIX . "imlinker_pattern_set "
					. " set params = '" . $this->db->escape($params) . "' "
					. ' where type = \'' . $type . '\' '
						. ' and name = \'' . $pattern_name . '\''
			);
		}
		else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "imlinker_pattern_set "
					. "(type, name, params) "
					. " VALUES ('" . $type . "', '" . $pattern_name . "', '" 
							. $this->db->escape($params) . "' "
					.") " 
			);
		}
	}
	
	/////////////////////////////////
	// Генерация
	/////////////////////////////////
	
	// Максимальная длина не text полей
	protected $max_length = 255;
	
	// Получение значения из поста
	protected function getPostValue($data, $name, $default = '')
	{
		if (isset($data[$name]))
			return $data[$name];
		return $default;
	}

	// Выбираем генератор
	public function generateSeo($data) 
	{
		$type = $this->getPostValue($data, 'type', '');
		
		switch($type)
		{
			case 'mlcp': $this->generateSeoMLCP($data); break;
			default: break;
		}
	}
	
	// 1.3
	// Выбираем генератор
	public function generateSeoById($inputData) 
	{
		// Находим идентификатор
		$pattern_set_id = $this->getPostValue($inputData, 'pattern_set_id', '-1');

		// Получаем настройки
		$data = $this->getSettings(array('pattern_list' => $pattern_set_id));

		// Нужна только очистка
		$is_clear_only = intval($this->getPostValue($inputData, 'is_clear_only', '0'));
		$data['is_clear_only'] = $is_clear_only;
		
		// Запускаем обычную генерацию
		$this->generateSeo($data);
	}

	// Генерация по кольцу
	public function generateSeoMLCP($data) 
	{
		$this->load->language('module/IMLinker');

		// Нужна только очистка
		$is_clear_only = intval($this->getPostValue($data, 'is_clear_only', '0'));

		//////////////////////////////////
		// Очищаем таблицу с выборкой
		//////////////////////////////////
		$truncateMLCPTableQuery = 'truncate table ' . DB_PREFIX . 'imlinker_mlcp_temp ';
		$this->db->query($truncateMLCPTableQuery);
		
		//////////////////////////////////
		// Формируем таблицу с выборкой
		//////////////////////////////////
		$this->formMLCPTempProductsByFilter($data);

		//////////////////////////////////
		// Очищаем таблицу связей соответствующих продуктов
		//////////////////////////////////
		$deleteProductRelatedQuery = 
			'delete pr '
			. ' from ' . DB_PREFIX . 'product_related pr '
				. ' join ' . DB_PREFIX . 'imlinker_mlcp_temp filter'
					. ' ON (filter.product_id = pr.product_id) ' 
		;
	 	$this->db->query($deleteProductRelatedQuery);

		//////////////////////////////////
		// Формируем таблицу связей
		//////////////////////////////////
		// Если нужно формировать связи
		// Случай с очисткой
		if ($is_clear_only != 1)
		{
			// Получаем количество записей
			$countMLCPTableQuery = 
				'select count(*) as cnt from ' . DB_PREFIX . 'imlinker_mlcp_temp '
			;
			
			$resultCountMLCPTable = $this->db->query($countMLCPTableQuery);
			
			$countMLCPTableRows = $resultCountMLCPTable->rows[0]['cnt'];
			
			// Переходим к самому запросу
			$beforeInsert = $this->getPostValue($data, 'before_count', '3');
			$afterInsert = $this->getPostValue($data, 'after_count', '3');
			
			$insertProductRelatedQuery = 
				'insert into ' . DB_PREFIX . 'product_related (product_id, related_id) '
				. ' select '
					. ' p.product_id, '
					. ' data.product_id '
				. ' from ' . DB_PREFIX . 'imlinker_mlcp_temp p '
					. ' join ' . DB_PREFIX . 'imlinker_mlcp_temp data '
						. ' on p.product_id != data.product_id '
							. ' and ( '
								// Внутри диапазона
								. ' ( '
									. ' data.number >= p.number - ' . $beforeInsert
									. ' and data.number <= p.number + ' .  $afterInsert
								. ' ) '
								// Край снизу
								. ' or ( '
									. ' p.number - ' . $beforeInsert . ' <= 0 '
									. ' and data.number >= ' . $countMLCPTableRows . ' + p.number - ' . $beforeInsert
								. ' ) '
								// Край сверху
								. ' or ( '
									. ' p.number + ' . $afterInsert . ' > ' . $countMLCPTableRows
									. ' and data.number <= ' . ' p.number + ' . $afterInsert . ' - ' . $countMLCPTableRows
								. ' ) '
							. ' ) '
			;
			$this->db->query($insertProductRelatedQuery);
		}
		
		//////////////////////////////////
		// Обновляем у продуктов дату изменения
		//////////////////////////////////
		$updateProductQuery =
			'UPDATE ' . DB_PREFIX . 'product p ' 
				. ' join ' . DB_PREFIX . 'imlinker_mlcp_temp filter ' 
					. ' ON (filter.product_id = p.product_id) ' 
			. " SET p.date_modified = '" . date('Y-m-d H') . ":00:00' " 
		;
	 	$this->db->query($updateProductQuery);
	}

	/**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    public function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
               mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }

	// Обрезание строки по длине
	protected function lenCut($value, $len)
	{
		if(isset($value) && !empty($value))
			// 1.3
			return mb_substr($value, 0, $len);
		return '';
	}

	// Формирование продуктов по фильтру
	protected function formMLCPTempProductsByFilter($data) 
	{
		$language_id = (int)$this->config->get('config_language_id');

		if (isset($data['sort_language_id']))
		{
			$language_id = $data['sort_language_id'];
		}

		$query = array();
		
		$wherePart = '';
		// Смотрим, есть ли столбцы в базе
		$is_have_main_category = $this->isHaveMainCategory();
		$is_have_meta_h1 = $this->isHaveMetaH1();
		
		// Фильтр по главной категории
		$is_main = ('' . $data['main_cat'] == '1' ? true : false);
		
		// Дата создания начало
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_create_start', 
			' date(p.date_added) >= ', 
			$wherePart
		);

		// Дата создания конец
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_create_end', 
			' date_add(date(p.date_added), interval -1 day) < ', 
			$wherePart
		);

		// Дата модификации начало
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_modify_start', 
			' date(p.date_modified) >= ', 
			$wherePart
		);

		// Дата модификации конец
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_modify_end', 
			' date_add(date(p.date_modified), interval -1 day) < ', 
			$wherePart
		);
		
		// Фильтр по категории
		$wherePart .= $this->getWhereFilterList(
			$data,
			'cat',
			' ptc.category_id ',
			$wherePart
		);

		// Фильтр по производителям
		$wherePart .= $this->getWhereFilterList(
			$data,
			'manufact',
			' p.manufacturer_id ',
			$wherePart
		);

		// Фильтр по отдельным продуктам
		$wherePart .= $this->getWhereFilterList(
			$data,
			'product_filter',
			' p.product_id ',
			$wherePart
		);
		
		$queryStringInsert = 
			' insert into ' . DB_PREFIX .'imlinker_mlcp_temp (product_id, number) '
			. 'select result.product_id, 0 '
			. 'from ( '
				. 'SELECT distinct p.product_id, pd.name, m.manufacturer_id as man_id, m.name as man_name '
				. ' from ' . DB_PREFIX . 'product p '
					. ' join ' . DB_PREFIX . 'product_to_category ptc '
						. ' on p.product_id = ptc.product_id '
							. ' and p.status = 1 '
						. (($is_have_main_category && $is_main)
							? ' and ptc.main_category = 1 '
							: ''
						)
					. " join " . DB_PREFIX . "product_description pd " 
						. " on p.product_id = pd.product_id "
							. " and pd.language_id = " . $language_id
					. $this->getJoinAttrFilter($data)
					. $this->getJoinOptionFilter($data)
					. ' left join ' . DB_PREFIX . 'manufacturer m '
						. ' on p.manufacturer_id = m.manufacturer_id '
				. ($wherePart == '' ? '' : ' where ' . $wherePart)
				. $this->getOrderPart($data)
			. ') as result '
			. ';'
		;
		
		$this->db->query($queryStringInsert);
		
		$queryStringUpdate = 
			' update ' . DB_PREFIX .'imlinker_mlcp_temp as data '
			. ' join '
				. ' ( '
				    . ' select @rownum:=@rownum+1 rownum, product_id '
				    . ' from ' . DB_PREFIX .'imlinker_mlcp_temp as data '
				    	. ' cross join (select @rownum := 0) rn '
				. ' ) AS r ON data.product_id = r.product_id '
			. ' set data.number = r.rownum'
			. ';'
		;
		
		$this->db->query($queryStringUpdate);
	}

	// Составление фильтра для даты
	protected function getWhereFilterDate($data, $date_name, $clause, $wherePart)
	{
		$result = '';
		
		if ($wherePart == '' && !empty($data[$date_name])) {
			$date = date_create_from_format('d.m.Y', $data[$date_name]);
			$result = " " . $clause . " '" . $date->format('Y-m-d') . "' ";
		}
		else if (!empty($data[$date_name])) {
			$date = date_create_from_format('d.m.Y', $data[$date_name]);
			$result = " and " . $clause . " '" . $date->format('Y-m-d') . "' ";
		}

		return $result;
	}

	// Составление фильтра для списка
	protected function getWhereFilterList($data, $list_name, $clause, $wherePart)
	{
		$result = '';
		
		if (!isset($data[$list_name]))
			return $result;
		
		// Если есть , что фильтровать
		if (count($data[$list_name]) > 0 && !empty($data[$list_name][0]) 
				&& (('' . $data[$list_name][0] != '-1') || count($data[$list_name]) > 1)) {
			$result .= (empty($wherePart) ? '' : ' and ');
			
			if (!is_array($data[$list_name])) {
				$result .= $clause . ' = ' . $data[$list_name];
			}
			else if (count($data[$list_name]) == 1) {
				$result .= $clause . ' = ' . $data[$list_name][0];
			}
			else {
				$result .= $clause . ' in (' . join(', ', $data[$list_name]) . ') ';
			}
		}
	
		return $result;
	}

	// Получение порядка следования продуктов
	protected function getOrderPart($data)
	{
		if (!isset($data['product_order']))
		{
			return ' order by p.product_id asc ';
		}
		
		$result = '';
		$product_order = $data['product_order'];
		
		switch($product_order)
		{
			case 'id_asc':
				$result = ' p.product_id asc ';
				break;
			case 'id_desc':
				$result = ' p.product_id desc ';
				break;
			case 'name_asc':
				$result = ' pd.name asc ';
				break;
			case 'name_desc':
				$result = ' pd.name desc ';
				break;
			case 'price_asc':
				$result = ' p.price asc ';
				break;
			case 'price_desc':
				$result = ' p.price desc ';
				break;
			case 'man_id_asc':
				$result = ' m.name asc, p.product_id asc ';
				break;
			case 'man_id_desc':
				$result = ' m.name desc, p.product_id desc ';
				break;
			case 'date_create_asc':
				$result = ' p.date_added asc ';
				break;
			case 'date_create_desc':
				$result = ' p.date_added desc ';
				break;
			case 'date_modify_asc':
				$result = ' p.date_modified asc ';
				break;
			case 'date_modify_desc':
				$result = ' p.date_modified desc ';
				break;
			case 'random':
				$result = ' rand() ';
				break;
			default:
				return ' order by p.product_id asc ';
		}
		
		return ' order by ' . $result;
	}

	/////////////////////////////////
	// Определение наличия колонок - поддерживаемых возможностей
	/////////////////////////////////
	
	// Получение настроек колонки meta_h1
	public function getMetaH1ColumnInfo()
	{
		$result = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_description LIKE 'meta_h1'");
		if ($result->num_rows) 
		{
			return $result->rows;
		} 
		return null;
	}
	
	// Есть главная категория
	public function isHaveMainCategory()
	{
		$result = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_to_category LIKE 'main_category'");
		if ($result->num_rows) 
		{
			return true;
		} 
		return false;
	}
	
	// Есть поле h1
	public function isHaveMetaH1()
	{
		$result = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_description LIKE 'meta_h1'");
		if ($result->num_rows) 
		{
			return true;
		} 
		return false;
	}
	
	/////////////////////////////////
	// Получение списков
	/////////////////////////////////

	// Получение списка настроек
	public function getSettingsList($data)
	{
		$resultList = array();
		$type = $this->getPostValue($data, 'type', '');
		
		// Без шаблона
		$resultList[] = array(
			'id' => -1,
			'name' => '<Не выбран шаблон настроек>'
		);

		
		// Подгружаем шабюлоны
		$query = $this->db->query(
			"SELECT * " 
			. " FROM " . DB_PREFIX . "imlinker_pattern_set im "
			. " WHERE im.type = '" . $type . "'"
			. " order by im.name asc"
		);
		
		if ($query->num_rows > 0) 
		{
			// Формируем результирующий массив
			foreach ($query->rows as $result) {
				$resultList[] = array(
					'id' => $result['pattern_set_id'],
					'name'        => $result['name'],
					'type'  	  => $result['type']
				);
			}	
		}

		return $resultList;
	}

	// 1.3
	// Получение списка настроек 
	// Все, кроме схем
	public function getSettingsListWithoutSchema()
	{
		$resultList = array();

		// Подгружаем шабюлоны
		$query = $this->db->query(
			"SELECT * " 
			. " FROM " . DB_PREFIX . "imlinker_pattern_set im "
			. " WHERE im.type != 'schema'"
			. " order by im.type asc, im.name asc"
		);
		
		if ($query->num_rows > 0) 
		{
			// Формируем результирующий массив
			foreach ($query->rows as $result) {
				$resultList[] = array(
					'id' => $result['pattern_set_id'],
					'name'        => $result['name'],
					'type'  	  => $result['type'],
					'text'		  => 
						(
							$result['type'] == 'mlcp' 
							? 'Кольца продуктов'
							: 'Неподдерживаемый тип линковки'
						) 
						. ' - ' . $result['name']
				);
			}	
		}

		return $resultList;
	}

	// Получение списка продуктов
	public function getProductList($data)
	{
		$language_id = (int)$this->config->get('config_language_id');

		if (isset($data['sort_language_id']))
		{
			$language_id = $data['sort_language_id'];
		}

		$wherePart = "";

		// Смотрим, есть ли столбцы в базе
		$is_have_main_category = $this->isHaveMainCategory();
		$is_have_meta_h1 = $this->isHaveMetaH1();
		
		// Фильтр по главной категории
		$is_main = ('' . $data['main_cat'] == '1' ? true : false);

		// Фильтр по категории
		$wherePart .= $this->getWhereFilterList(
			$data,
			'cat',
			' ptc.category_id ',
			$wherePart
		);
		// Дата создания начало
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_create_start', 
			' date(p.date_added) >= ', 
			$wherePart
		);

		// Дата создания конец
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_create_end', 
			' date_add(date(p.date_added), interval -1 day) < ', 
			$wherePart
		);

		// Дата модификации начало
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_modify_start', 
			' date(p.date_modified) >= ', 
			$wherePart
		);

		// Дата модификации конец
		$wherePart .= $this->getWhereFilterDate(
			$data, 
			'date_modify_end', 
			' date_add(date(p.date_modified), interval -1 day) < ', 
			$wherePart
		);

		// Фильтр по производителям
		$wherePart .= $this->getWhereFilterList(
			$data,
			'manufact',
			' p.manufacturer_id ',
			$wherePart
		);
		
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name' => 'Все продукты'
		);
		
		$queryString = "SELECT distinct p.product_id, pd.name, m.manufacturer_id as man_id, m.name as man_name " 
				. " FROM " . DB_PREFIX . "product p " 
					. " join " . DB_PREFIX . "product_to_category ptc " 
						. " on p.product_id = ptc.product_id "
							. ' and p.status = 1 '
							. (($is_have_main_category && $is_main)
								? ' and ptc.main_category = 1 '
								: ''
							)
					. " join " . DB_PREFIX . "product_description pd " 
						. " on p.product_id = pd.product_id "
							. " and pd.language_id = " . $language_id
					. $this->getJoinAttrFilter($data)
					. $this->getJoinOptionFilter($data)
					. ' left join ' . DB_PREFIX . 'manufacturer m '
						. ' on p.manufacturer_id = m.manufacturer_id '
				. ($wherePart == '' ? '' : ' where ' . $wherePart)
				. $this->getOrderPart($data)
				//. " ORDER BY pd.name"
		;
		
		// Получаем список продуктов на текущем языке
		$query = $this->db->query($queryString);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['product_id'],
				'name' => $result['name'],
				'man_id' => $result['man_id'],
				'man_name' => $result['man_name']
			);
		}	
		
		return $resultList;
	}
	
	// Формирование Join фильтра по опциям в том случае,
	// если указаны значения опций
	public function getJoinOptionFilter($data)
	{
		$is_need_join = false;
		
		$language_id = (int)$this->config->get('config_language_id');

		// Фильтра по атрибутам нет
		if (!isset($data['option_filter']))
		{
			return ' ';
		}
		
		$join_filter = '';
		$option_filter = $data['option_filter'];
		
		// Проходимся по всем фильтрам атрибутов
		foreach($option_filter as $key=>$item)
		{
			if (!isset($item['values']))
			{
				continue;
			}
			
			$is_need_join = true;
			$id = $item['id'];
			$itemValues = $item['values'];
			
			// Составляем фильтр			
			$join_filter .= 
				' join ' . DB_PREFIX . 'product_option_value ov' . $id . ' '
				. ' on p.product_id = ov' . $id . '.product_id '
					. ' and ov' . $id . '.option_id = ' . $id . ' '
					. ' and ov' . $id . '.option_value_id '
						. (count($itemValues) == 1 ? ' = ' : ' in (')
							. implode(', ', $itemValues)
						. (count($itemValues) == 1 ? ' ' : ') ')
					. ' '
			;
		}
		
		// Если есть чего возвращать, то возвращаем строку
		if ($is_need_join)
		{
			return ' ' . $join_filter . ' ';
		}
		else
		{
			return '  ';
		}
	}
	
	// Формирование Join фильтра в том случае,
	// если указаны значения атрибутов
	public function getJoinAttrFilter($data)
	{
		$is_need_join = false;
		
		$language_id = (int)$this->config->get('config_language_id');
		if (isset($data['attr_language_id']))
		{
			$language_id = $data['attr_language_id'];
		}

		// Фильтра по атрибутам нет
		if (!isset($data['attr_filter']))
		{
			return ' ';
		}
		
		$join_filter = '';
		$attr_filter = $data['attr_filter'];
		
		// 1.3
		// Проходимся по всем фильтрам атрибутов
		foreach($attr_filter as $key=>$item)
		{
			if (!isset($item['values']))
			{
				continue;
			}
			
			$is_need_join = true;
			$id = $item['id'];
			$itemValuesForReset = $item['values'];
			// Для конкретных значений
			$itemValues = array();
			// Для диапазонов
			$itemValuesRange = array();
			
			// Экранируем символы и отделяем значения от диапазонов
			for($cntValues = 0; $cntValues < count($itemValuesForReset); $cntValues++){
				// Диапазон
				//if (mb_strpos('<<<', $itemValuesForReset[$cntValues]) !== false) {
				if (preg_match('/===/', $itemValuesForReset[$cntValues])) {
					$explodeItems = explode('===', $itemValuesForReset[$cntValues]);
					$itemValuesRange[] = array(
						'min' => $explodeItems[0],
						'max' => $explodeItems[1]
					);
				}
				// Конкретное значение
				else {
					$itemValues[] = $this->db->escape($itemValuesForReset[$cntValues]);	
				}
			}
			
			// Составляем фильтр для текста
			$join_text_filter = ''
			;

			// Если есть конкретные значения
			if (count($itemValues) > 0) {
				$join_text_filter .= 
					 ' pa' . $id . '.text '
					. (count($itemValues) == 1 ? ' = \'' : ' in (\'')
						. implode('\', \'', $itemValues)
					. (count($itemValues) == 1 ? '\' ' : '\') ')
				;
			}
			
			// Если есть диапазоны
			if (count($itemValuesRange) > 0) {
				// Проходимся по диапазонам и составляем выражение
				foreach($itemValuesRange as $itemRange) {
					// Если в фильтре уже что-то есть
					if ($join_text_filter != '')
						$join_text_filter .= ' or ';
				
					$join_text_filter .=
						' ( '
							. ' pa' . $id . '.text + 0 >= 0 + \'' . $this->db->escape($itemRange['min']) . '\' '
							. ' and pa' . $id . '.text + 0 <= 0 + \'' . $this->db->escape($itemRange['max']) . '\' '
						. ' ) '
					;
				}
			}

			// Составляем фильтр			
			$join_filter .= 
				' join ' . DB_PREFIX . 'product_attribute pa' . $id . ' '
				. ' on p.product_id = pa' . $id . '.product_id '
					. ' and pa' . $id . '.language_id = ' . $language_id . ' '
					. ' and '
						. ' ( ' 
							. ' pa' . $id . '.attribute_id = ' . $id . ''
							. ($join_text_filter ? 
								' and ' 
									. ' ( '
										. $join_text_filter
									. ' ) '
								: '')
						. ' ) '
					. ' '
			;
		}
		
		// Если есть чего возвращать, то возвращаем строку
		if ($is_need_join)
		{
			return ' ' . $join_filter . ' ';
		}
		else
		{
			return '  ';
		}
	}
	
	// На случай, если сортировка идет по имени, 
	// то необходимо добавлять join с product_description
	public function getJoinProductDescription($data)
	{
		if (!isset($data['product_order']))
		{
			return '  ';
		}
		
		$result = '';
		$product_order = $data['product_order'];
		
		if (in_array($product_order, array('name_asc', 'name_desc')))
		{
			if (isset($data['sort_language_id']))
			{
				return ' join ' . DB_PREFIX . 'product_description pd '
					. ' on p.product_id = pd.product_id '
						. ' and pd.language_id = ' . $data['sort_language_id']
						. ' '
				;
			}
		}
		
		return ' ';
	}
	
	// Список возможных сортировок продуктов
	// Используется в getOrderPart
	public function getProductOrder()
	{
		$resultList = array();
		
		$resultList[] = array( 
			'id' => 'id_asc',
			'name' => 'Идентификатор (Возрастание)'
		);
		$resultList[] = array( 
			'id' => 'id_desc',
			'name' => 'Идентификатор (Убывание)'
		);
		$resultList[] = array( 
			'id' => 'name_asc',
			'name' => 'Название (Возрастание)'
		);
		$resultList[] = array( 
			'id' => 'name_desc',
			'name' => 'Название (Убывание)'
		);
		$resultList[] = array( 
			'id' => 'price_asc',
			'name' => 'Цена (Возрастание)'
		);
		$resultList[] = array( 
			'id' => 'price_desc',
			'name' => 'Цена (Убывание)'
		);
		$resultList[] = array( 
			'id' => 'man_id_asc',
			'name' => 'Производитель, идентификатор (Возрастание)'
		);
		$resultList[] = array( 
			'id' => 'man_id_desc',
			'name' => 'Производитель, идентификатор (Убывание)'
		);
		$resultList[] = array( 
			'id' => 'date_create_asc',
			'name' => 'Дата создания (Возрастание)'
		);
		$resultList[] = array( 
			'id' => 'date_create_desc',
			'name' => 'Дата создания (Убывание)'
		);
		$resultList[] = array( 
			'id' => 'date_modify_asc',
			'name' => 'Дата изменения (Возрастание)'
		);
		$resultList[] = array( 
			'id' => 'date_modify_desc',
			'name' => 'Дата изменения (Убывание)'
		);
		$resultList[] = array( 
			'id' => 'random',
			'name' => 'Случайный порядок'
		);
		
		return $resultList;
	}
	
	// Получение списка опций
	public function getOptionWithValuesList() 
	{
		$language_id = (int)$this->config->get('config_language_id');

		$resultList = array();

		// Получаем список атрибутов
		$query = $this->db->query(
				' SELECT o.option_id, od.name as option_name, ' 
					. ' ov.option_value_id, ovd.name as option_value_name '
				. ' FROM ' . DB_PREFIX . 'option o ' 
					. ' join ' . DB_PREFIX . 'option_description od '
						. ' on o.option_id = od.option_id '
							. ' and od.language_id = ' . $language_id
					. ' join ' . DB_PREFIX . 'option_value ov '
						. ' on ov.option_id = o.option_id '
					. ' join ' . DB_PREFIX . 'option_value_description ovd '
						. ' on o.option_id = ovd.option_id '
							. ' and ov.option_value_id = ovd.option_value_id ' 
							. ' and ovd.language_id = ' . $language_id
				. ' ORDER BY od.name asc, ovd.name asc '
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'option_id' => $result['option_id'],
				'option_name' => $result['option_name'],
				'option_value_id' => $result['option_value_id'],
				'option_value_name' => $result['option_value_name']
			);
		}	
		
		return $resultList;

	}
	
	// Получение списка атрибутов
	public function getAttributeList() 
	{
		$language_id = (int)$this->config->get('config_language_id');

		$resultList = array();

		// Получаем список атрибутов
		$query = $this->db->query("SELECT * " 
				. " FROM " . DB_PREFIX . "attribute_description a " 
				. " where a.language_id = " . $language_id
				. " ORDER BY a.name"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['attribute_id'],
				'name'        => $result['name'],
				'pattern'  	  => '[attr_' . $result['name'] . ']'
			);
		}	
		
		return $resultList;

	}
	
	// Получение списка производителей
	public function getManufacturer()
	{
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name'        => 'Все производители',
			'image'  	  => '',
			'sort_order'  => -1
		);
		
		// Получаем список производителей
		$query = $this->db->query("SELECT * " 
				. " FROM " . DB_PREFIX . "manufacturer m " 
				. " ORDER BY m.sort_order asc, name asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['manufacturer_id'],
				'name'        => $result['name'],
				'image'  	  => $result['image'],
				'sort_order'  => $result['sort_order']
			);
		}	
		
		return $resultList;
	}

	// Получение списка категорий
	public function getCategories($parent_id = 0) 
	{
		$category_data = array();
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT * " 
				. " FROM " . DB_PREFIX . "category c " 
					. " LEFT JOIN " . DB_PREFIX . "category_description cd " 
						. " ON (c.category_id = cd.category_id) " 
				. " WHERE c.parent_id = '" . (int)$parent_id . "' " 
					. " AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' " 
				. " ORDER BY cd.name ASC"
		);
	
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$category_data[] = array(
				'id' => $result['category_id'],
				'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
				'status'  	  => $result['status'],
				'sort_order'  => $result['sort_order']
			);
		
			$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
		}	
		
		return $category_data;
	}
	
	// Получение пути
	public function getPath($category_id) 
	{
		// Получаем наименование и ID родительской категории
		$query = $this->db->query("SELECT name, parent_id " 
				. " FROM " . DB_PREFIX . "category c " 
					. " LEFT JOIN " . DB_PREFIX . "category_description cd " 
						. " ON (c.category_id = cd.category_id) " 
				. " WHERE c.category_id = '" . (int)$category_id . "' " 
					. " AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' " 
				. " ORDER BY c.sort_order, cd.name ASC"
		);
		
		// Если есть родительская категория, то получаем ее
		// Тем самым формируя цепочку
		if ($query->row['parent_id']) {
			return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) 
					. ' > ' 
					. $query->row['name'];
		} 
		// Иначе возвращаем имя категории
		else {
			return $query->row['name'];
		}
	}

}