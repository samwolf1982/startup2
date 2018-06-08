<?php 
	// Формирование html select
	if (!function_exists('echoHtmlSelect'))
	{
		function echoHtmlSelect($name, $data, $curr_val = '', $append_class = '', 
							$is_multi = false, $val_name = 'id', $text_name = 'name')
		{
			$result = '<select name="' . $name . '" ' 
						. ' class="form-control ' . $append_class . '" '
						. ($is_multi ? ' multiple="multiple" ' : '') 
				. ' >';
			
			foreach($data as $key => $item)
			{
				$result .= '<option value="' . $item[$val_name] . '" '
							. (('' . $item[$val_name] == $curr_val )? ' selected="selected" ' : '')	. '>'
						. $item[$text_name]
					. '</option>';
			}
			
			return $result . '</select>';
		}
	}

	if (!function_exists('echoHtmlSelectMany'))
	{
		function echoHtmlSelectMany($name, $data, $append_class = '', 
							$val_name = 'id', $text_name = 'name')
		{
			$result = '<div class="well well-sm ' . $append_class . '" style="height: 150px; overflow: auto;">';
			$result .= '<input type="hidden" value="-1" name="' . $name . '" />';
			
			foreach($data as $key => $item)
			{
				if (''.$item[$val_name] == '-1')
				{
					continue;
				}
				else
				{
					$result .= '<div class="checkbox">'
		                  	. ' <label> '
								. '<input type="checkbox" name="' . $name . '" value="' . $item[$val_name] . '"> '
		                    	. $item[$text_name]                                      
		                    . ' </label> '
		                . '</div>'
					;
				}
			}

			$result .= '</div>';

			$result .= '<a class="iml-cursor" onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);">Выделить всё</a>'
				. ' / '
				. '<a class="iml-cursor" onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);">Снять выделение</a>'
			;
			
			return $result;
		}
	}

	if (!function_exists('echoHtmlSelectType'))
	{
		function echoHtmlSelectType($name, $curr_val, $append_class = '', $is_multi = false)
		{
			return echoHtmlSelect($name,
				array(
					array('id' => '1','name' => 'Заменить пустые'),
					array('id' => '2','name' => 'Добавить, если не хватает'),
					array('id' => '3','name' => 'Перезаписать')
				),
				$curr_val,
				$append_class,
				$is_multi,
				'id',
				'name'
			);
		}
	}

	if (!function_exists('echoHtmlSelectTypeSearch'))
	{
		function echoHtmlSelectTypeSearch($name, $curr_val, $append_class = '', $is_multi = false)
		{
			return echoHtmlSelect($name,
				array(
					array('id' => 'regular_word','name' => 'Искать только нормальные слова (только буквы)'),
					array('id' => 'regular_word_digit','name' => 'Искать цифро-буквенные комбинации с дефисом')
				),
				$curr_val,
				$append_class,
				$is_multi,
				'id',
				'name'
			);
		}
	}

	if (!function_exists('echoLabel'))
	{
		function echoLabel($module_label, $name)
		{
			if (isset($module_label)) {
				if (is_array($module_label)) {
					if (isset($module_label[$name]))
						return $module_label[$name];
				}
			}
			return $name;
		}
	}

	if (!function_exists('echoDate'))
	{
		function echoDate($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return
				'<div class="form-group">'
				    . '<label class="control-label" for="">'
				    	. echoLabel($module_label, $label)
				    . '</label>'
				    . '<div class="input-group date">'
				      	.' <input type="text" '
				      		. ' name="' . $name . '" '
				      		. ' value="' . $value . '" '
				      		. ' placeholder="' . echoLabel($module_label, $label) . '"'
				      		. ' data-date-format="DD.MM.YYYY"'
				      		. ' class="form-control ' . $append_class . '"/>'
				      	. '<span class="input-group-btn">'
				      	. '<button type="button" class="btn btn-default">'
				      		. '<i class="fa fa-calendar"></i>'
				      	. '</button>'
				      	.'</span>'
				    . '</div>'
			  	. '</div>'
		  	;
		}
	}
	
	if (!function_exists('echoTextAreaControl'))
	{
		function echoTextAreaControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return 
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. '<textarea '
	      					. ' name="' . $name . '" '
	      					. ' placeholder="' . echoLabel($module_label, $label) . '" '
	      					. ' class="form-control ' . $append_class . '">'
	      						. $value
	      				. '</textarea>'
					. '</div>'
		  		. '</div>'
			;
		}
	}

	if (!function_exists('echoInputControl'))
	{
		function echoInputControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return 
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. '<input '
	      				
	      					. ' type="textbox"'
	      					. ' name="' . $name . '" '
	      					. ' value="' . $value . '" '
	      					. ' placeholder="' . echoLabel($module_label, $label) . '" '
	      					. ' class="form-control ' . $append_class . '"/>'
					. '</div>'
		  		. '</div>'
			;
		}
	}

	if (!function_exists('echoSelectControl'))
	{
		function echoSelectControl($data, $name, $module_label, $label = '', $value = '', $append_class = '',
									$is_multi = false, $val_name = 'id', $text_name = 'name')
		{
			return
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. echoHtmlSelect($name, $data, $value, $append_class, $is_multi, $val_name, $text_name)
					. '</div>'
		  		. '</div>'
			;
		}
	}
	
	if (!function_exists('echoTypeControl'))
	{
		function echoTypeControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. echoHtmlSelectType($name, $value, $append_class, false)
					. '</div>'
		  		. '</div>'
			;
		}
	}

	if (!function_exists('echoTypeSearchControl'))
	{
		function echoTypeSearchControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. echoHtmlSelectTypeSearch($name, $value, $append_class, false)
					. '</div>'
		  		. '</div>'
			;
		}
	}
	
	if (!function_exists('echoAvalCapabilities'))
	{
		function echoAvalCapabilities()
		{
			return
				'<div class="col-sm-12">'
					. '<h2>Информация по использованию:</h2>'
					. '<div class="alert alert-danger">'
						. 'Прежде, чем выполнять генерацию множественных колец продуктов, настоятельно советуется сделать бэкап таблицы <b>oc_product_related</b>. '
					. '</div>'
					. '<div class="alert alert-info">'
						. 'Отличительной особенностью генерации является то, что вы не ограничены одной категорией. '
						. 'Вы можете создавать множественные кольца достаточно гибким образом. '
						. 'Учтите, что кольца организуются именно из тех продуктов, которые были получены с учетом фильтра. '
						. 'Это означает, что связи с продуктами, для которых ранее были сгенерированы связи не будут удалены. '
						. 'Эта особенность позволяет организовывать более сложные схемы линкования продуктов. '
						. '<br/>'
						. '<br/>'
						. 'Пример. Если вы сгенерируете множественные кольца через все продукты, '
						. 'а затем выполните генерацию для одной категории, то ссылки из продуктов других категорий не исчезнут. '
						. '<br/>'
						. '<br/>'
						. '<b>Важно!</b> ' . ' При использовании фильтра по атрибутам, пустые поля так же принимаются как фильтрующие. '
						. ' Это обусловлено тем, что OpenCart (ocStore) позволяет создавать пустые атрибуты.'
						. ' Если же вам нужно задать диапазон, то его необходимо указать через <b>===</b>. К примеру, диапазон от 10 до 100 будет выглядеть так <b>10 === 100</b>.'
						. '<br/>'
						. '<br/>'
						. '<b>Важно!</b> При использовании фильтра по опциям, можно задавать только селективные опции '
						. '(выпадающие списки, чекбоксы и прочее, где есть возможность задавать '
						. 'выбор из фиксированного списка значений для товара). '
					. '</div>'
				. '</div>'
			;
		}
	}
	
	// Распечатка скрытых данных
	if (!function_exists('echoHiddenOptionData'))
	{
		function echoHiddenOptionData($list, $append_class = '')
		{
			$result = '';
			
			foreach($list as $item)
			{
				$result .= 
					'<data '
						. ' option_id="' . $item['option_id'] . '" '
						. ' option_name="' . urlencode($item['option_name']) . '" '
						. ' option_value_id="' . $item['option_value_id'] . '" '
						. ' option_value_name="' . urlencode($item['option_value_name']) . '" '
						. ' >'
					. '</data>'
				;	
			}
			
			return '<div class="hidden ' . $append_class . '">' . $result . '</div>';
		}
	}
?>


<!-- --------------------------------------------------- -->
<!-- OpenCart Style Start -->
<!-- --------------------------------------------------- -->
<div class="tab-pane" id="schema">
		
	<form class="form IMLinker-form" 
		action="<?php echo $replace; ?>" method="post" 
		enctype="multipart/form-data" 
		id="form_linker_schema"
	>
		<input type="hidden" 
			name="IMLinker[type]" 
			value="schema" />

		<div class="well">
			<div class="row">
				<!-------------------------->
				<!-- Button Get Settings -->
				<!-------------------------->
				<div class="col-sm-12">
					<div class="col-sm-6">
						<div class="form-group">
						<label class="control-label">
						<?php echo 
							echoLabel($module_label, 'label_load_settings'); ?>
						</label>
						<?php echo 
							echoHtmlSelect('IMLinker[pattern_list]', $list_pattern_list['schema'], ''); 
						?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">
								&nbsp;
							</label>
							<div class="buttons">
								<a class=" btn-im-get-schema-settings btn btn-primary" 
									style="color:white">
									<i class="fa fa-download"></i> &nbsp; 
									<?php echo 
										echoLabel($module_btn_label, 'button_get_settings'); ?>
								</a>
								<a class=" btn-im-delete-settings btn btn-danger" 
									style="color:white">
									<i class="fa fa-remove"></i> &nbsp; 
									<?php echo 
										echoLabel($module_btn_label, 'button_delete_settings'); ?>
								</a>
								<span class="get-delete-settings-status"></span>
							</div>
						</div>
					</div>
				</div>
				<!-------------------------->
				<!-- Button Save Settings -->
				<!-------------------------->
				<div class="col-sm-12">
					<div class="col-sm-6">
						<?php
							echo echoInputControl(
								'IMLinker[pattern_name]',
								$module_label,
								'label_pattern_name',
								'',
								''
							);
						?>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">
								&nbsp;
							</label>
							<div class="buttons">
								<a class=" btn-im-save btn btn-primary" 
									style="color:white">
									<i class="fa fa-save"></i> &nbsp; 
									<?php echo 
										echoLabel($module_btn_label, 'button_save'); ?>
								</a>
								<span class="save-status"></span>
							</div>
						</div>
					</div>
				</div>

				<!-------------------------->
				<!-- Schema Patterns -->
				<!-------------------------->
				<div class="col-sm-12">
					<div class="col-sm-12">
						<h2>
							<?php echo
								echoLabel($module_label, 'label_schema_list_header'); 
							?>	
						</h2>	
					</div>
					<!-- Table with Patterns -->
					<div class="table-responsive col-sm-12">
						<table class="table table-bordered table-patterns">
							<tbody>
								
							</tbody>
						</table>
					</div>
					<!-- Pattern select -->
					<div class="col-sm-6">
						<div class="form-group">
						<label class="control-label">
						<?php echo 
							echoLabel($module_label, 'list_all_pattern_list_without_schema'); ?>
						</label>
						<?php echo 
							echoHtmlSelect('list_all_pattern_list_without_schema', 
								$list_all_pattern_list_without_schema, '', 'list_all_pattern_list_without_schema',
								false, 'id', 'text'); ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
						<label class="control-label">
							&nbsp;
						</label>
						<div>
							<button type="button" class="btn btn-primary button-add-pattern">
								<i class="fa fa-plus-circle"></i> 
				  					<?php echo 
										echoLabel($module_btn_label, 'button_attr_add'); ?>
				  			</button>
							<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
						</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<hr>
				</div>				
				<!-------------------------->
				<!-- Button Generate Seo -->
				<!-------------------------->
				
				<div class="col-sm-12">
					<div class="form-group">
						<div class="buttons">
							<a class=" btn-im-schema-generate btn btn-success" 
								style="color:white">
								<i class="fa fa-save"></i> &nbsp; 
								<?php echo 
									echoLabel($module_btn_label, 'button_generate'); ?>
							</a>
							&nbsp;&nbsp;&nbsp;
							<a class=" btn-im-schema-generate-clear btn btn-warning" 
								style="color:white">
								<i class="fa fa-eraser"></i> &nbsp; 
								<?php echo 
									echoLabel($module_btn_label, 'button_generate_clear'); ?>
							</a>
							&nbsp;&nbsp;&nbsp;
							<span class="generate-schema-status"></span>
						</div>
					</div>
				</div>
				
			</div>
		</div>

	</form>
</div>
				
<script type="text/javascript">
	var textBtnLabels = {
		generate: '<?php echo echoLabel($module_btn_label, 'button_generate'); ?>',
		clear: '<?php echo echoLabel($module_btn_label, 'button_generate_clear'); ?>',
		del: '<?php echo echoLabel($module_btn_label, 'button_delete'); ?>',
		up: '<?php echo echoLabel($module_btn_label, 'button_up'); ?>',
		down: '<?php echo echoLabel($module_btn_label, 'button_down'); ?>',
	};
	
</script>

<script type="text/javascript">
	// Перезагружаем список доступных паттернов
	function IML_resetAllPatternList(json) {
		var list = jQuery('.IMLinker select.list_all_pattern_list_without_schema'),
			selectedValue = list.val(),
			vals = json['pattern_list_without_schema']
		;
		
		list.find('option').remove();
		
		// Перезаполняем список
		for(var cnt = 0; cnt < vals.length; cnt++) {
			var is_selected = (vals[cnt]['id'] == selectedValue
						? ' selected="selected" ' : '')
			;
			list.append(
				'<option ' + is_selected +  ' value="' + vals[cnt]['id'] + '" >' 
					+ vals[cnt]['text'] 
				+ '</option>'
			);
		}
	}

	// Загрузка настроек шаблона
	function IML_getSchemaSettings(form) {
		// Форма еще не выстроена
		if (form.serializeArray().length == 0)
			return;

		var saveVal = form.find('select[name="IMLinker\[pattern_list\]"] option:selected').val()
		;

		ajaxOperation({
			form: form,
			url: module_links.getSettings,
			status: {
				selector: '.get-delete-settings-status',
				text: {
					action: 'Получаем...',
					success: 'Шаблон настроек загружен!',
					fail: 'Шаблон настроек не загружен!'
				}
			},
			onLoad: function (json) {
				if (json['success']) {
					var jq = jQuery,
						settings = json['settings'],
						selectPattern = form.find('select[name="IMLinker\[pattern_list\]"]'),
						inputPattern = form.find('*[name="IMLinker\[pattern_name\]"]')
					;
					
					if ('' + selectPattern.val() != '-1') {
						inputPattern.val(selectPattern.text());
					}
					else {
						return;
					}

					form.find('.table-patterns tr').remove();
					
					// Восстанавливаем настройки
					for(var key in settings) {
						if (settings.hasOwnProperty(key)) {
							var values = settings[key],
								item = form
									.find('*[name="IMLinker\[' + key + '\]"]'
										+ ', ' + '*[name="IMLinker\[' + key + '\]\[\]"]'
									),
								itemList = form
									.find('input[type="checkbox"][name="IMLinker\[' + key + '\]\[\]"]') 
							;
							
							if (item.is('select')) {
								if (values instanceof Array) {
									item.find('option').prop('selected', null);
									
									for(var cnt = 0; cnt < values.length; cnt++) {
										item.find('option[value="' + values[cnt] + '"]')
										.prop('selected', 'selected');
									}
								}
								else {
									item.find('option').prop('selected', null);
									item.find('option[value="' + values + '"]')
									.prop('selected', 'selected');
								}
							}
							//////////////////////////////////////////
							// Восстановление шаблонов
							//////////////////////////////////////////
							else if (key == 'pattern_set_id') {
								var tableBody = form.find('.table-patterns tbody'),
									selectPatterns = form.find('.list_all_pattern_list_without_schema')
								;
								
								// Проходимся по всем атрибутам и восстанавливаем фильтр
								for(var itemPatternKey in values) {
									var itemValue = values[itemPatternKey];
										itemText = selectPatterns.find('option[value=' + itemValue + ']').text()
									;
									
									IML_formTablePatternsRow(tableBody, itemValue, itemText);
									
									var lastRow = tableBody.find('tr:last');
									
									IML_bindEventsToTablePatternsRow(tableBody, lastRow);
								}
							}
							else {
								item.val(values);
							}
						}
					}
				} else {
					
				}
				
				// Восстанавливаем сохранение
				form.find('select[name="IMLinker\[pattern_list\]"] option').prop('selected', null);
				form.find('select[name="IMLinker\[pattern_list\]"] option').each(function () {
					var item = jQuery(this)
					;
					
					if (item.val() == saveVal)
					{
						item.prop('selected', 'selected');
					}
				});
			}
		});					
	}
	
	// Создание строки шаблона
	function IML_formTablePatternsRow(tableBody, selectedValue, selectedText) {
		tableBody.append(
			'<tr>'
				+ '<td class="col-sm-4 vert-align">'
					+ '<b>'
						+ selectedText
					+ '</b>'
					+ '<input type="hidden" ' 
						+ ' name="IMLinker[pattern_set_id][]" value="' + selectedValue + '"/>'
				+ '</td>'
				+ '<td class="col-sm-4 vert-align">'
					+ '<span class="status-text"></span>'
				+ '</td>'
				+ '<td class="col-sm-4">'
					+ '<button type="button" class="btn btn-manual-pattern-generate-row btn-success" >'
						+ '<i class="fa fa-save"></i>'
					+ '</button>'
					+ '&nbsp;&nbsp;&nbsp;'
					+ '<button type="button" class="btn btn-manual-pattern-generate-clear-row btn-warning" >'
						+ '<i class="fa fa-eraser"></i>'
					+ '</button>'
					+ '&nbsp;&nbsp;&nbsp;'
					+ '<button type="button" class="btn btn-up-pattern-row btn-primary" >'
						+ '<i class="fa fa-level-up"></i>'
					+ '</button>'
					+ '&nbsp;&nbsp;&nbsp;'
					+ '<button type="button" class="btn btn-down-pattern-row btn-primary" >'
						+ '<i class="fa fa-level-down"></i>'
					+ '</button>'
					+ '&nbsp;&nbsp;&nbsp;'
					+ '<button type="button" class="btn btn-delete-pattern-row btn-danger" >'
						+ '<i class="fa fa-minus-circle"></i>'
					+ '</button>'
				+ '</td>'
			+ '</tr>'
		);
		
	}
	
	// Установка обработчиков
	function IML_bindEventsToTablePatternsRow(tableBody, lastRow) {
		// Удаление
		lastRow.find('.btn-delete-pattern-row').click(function () {
			jQuery(this).closest('tr').remove();
		});

		// Вверх
		lastRow.find('.btn-up-pattern-row').click(function () {
			var row = jQuery(this).closest('tr'),
				indexRow = row.index()
			;
			
			if (indexRow == 0)
				return;	
			
			row.insertBefore(tableBody.find('tr:eq(' + (indexRow - 1) + ')'))
		});
		
		// Вниз
		lastRow.find('.btn-down-pattern-row').click(function () {
			var row = jQuery(this).closest('tr'),
				indexRow = row.index(),
				countRow = tableBody.find('tr').length;
			;
			
			if (indexRow >= countRow)
				return;	
			
			row.insertAfter(tableBody.find('tr:eq(' + (indexRow + 1) + ')'))
		});
		
		// Отдельная генерация
		lastRow.find('.btn-manual-pattern-generate-row').click(function () {
			var row = jQuery(this).closest('tr'),
				form = jQuery(this).closest('form'),
				statusElement = row.find('.status-text'),
				id = row.find('input').val()
			;
			
			IML_generateSeoById(form, statusElement, id, false, null);
		});

		// Отдельная очистка
		lastRow.find('.btn-manual-pattern-generate-clear-row').click(function () {
			var row = jQuery(this).closest('tr'),
				form = jQuery(this).closest('form'),
				statusElement = row.find('.status-text'),
				id = row.find('input').val()
			;
			
			IML_generateSeoById(form, statusElement, id, true, null);
		});
	}

	// Генерация отдельного элемента
	function IML_generateSeoById(form, statusElement, id, isClear, onLoad) {
		// Форма еще не выстроена
		if (form.serializeArray().length == 0)
			return;

		var dataArray = [{name: 'IMLinker[pattern_set_id]', value: id}]
		;
		
		if (isClear) {
			dataArray.push({
				name: 'IMLinker[is_clear_only]',
				value: '1'
			});
		}

		ajaxOperation({
			form: form,
			url: module_links.generateSeoById,
			status: {
				selector: statusElement,
				text: {
					action: (isClear ? 'Очищаем...' : 'Генерируем...'),
					success: (isClear ? 'Связи очищены!' : 'Данные сгенерированы!'),
					fail: (isClear ? 'Связи не очищены!' : 'Данные не сгенерированы!')
				}
			},
			data: dataArray,
			onLoad: onLoad
		});	
	}

	// Рекурсивный обход
	function IML_generateSchemaRecursion(form, setIds, isClear, cnt, onLoad) {
		// Запускать нечего
		if (setIds.length == 0 || cnt == setIds.length) {
			onLoad();
			return;
		}
		
		// Смотрим элемент
		var row = form.find('.table-patterns tbody tr:eq(' + cnt + ')'),
			statusElement = row.find('.status-text')
		;
		
		// Запускаем генерацию с переходом к следующему элементу
		IML_generateSeoById(form, statusElement, setIds[cnt], isClear, function () {
			IML_generateSchemaRecursion(form, setIds, isClear, cnt + 1, onLoad);
		});
	}

	// Генерация схемы
	function IML_generateSchemaSeo(form, isClear) {
		var items = form.find('input[name="IMLinker\[pattern_set_id\]\[\]"]'),
			setIds = []
		;
		
		items.each(function () {
			setIds.push(jQuery(this).val());
		});
		
		// Очищаем отдельные статусы
		form.find('.table-patterns tbody .status-text').removeClass('fail').removeClass('success')
		.text('');
		
		// Формируем общий статус
		form.find('.generate-schema-status').removeClass('fail').removeClass('success')
			.text(isClear ? 'Очищаем...' : 'Генерируем...');
		
		// Запускаем генерацию
		IML_generateSchemaRecursion(form, setIds, isClear, 0, function () {
			form.find('.generate-schema-status').removeClass('fail').addClass('success')
			.text(isClear ? 'Связи очищены!' : 'Данные сгенерированы!');
		});
	}
	
	jQuery(function () {
		///////////////////////////
		// Стандартные кнопки
		///////////////////////////
		jQuery('.btn-im-get-schema-settings').click(function () {
			IML_getSchemaSettings(jQuery(this).closest('form'));
		});
		
		// Генерация
		jQuery('.IMLinker .btn-im-schema-generate').click(function () {
			IML_generateSchemaSeo(jQuery(this).closest('form'), false);
		});

		// Генерация (очистка)
		jQuery('.IMLinker .btn-im-schema-generate-clear').click(function () {
			IML_generateSchemaSeo(jQuery(this).closest('form'), true);
		});

		
		///////////////////////////
		// Таблица
		///////////////////////////
		jQuery('.IMLinker .button-add-pattern').click(function () {
			var list = jQuery('.IMLinker select.list_all_pattern_list_without_schema'),
				selectedValue = list.val(),
				selectedText = list.find('option[value=' + selectedValue + ']').text(),
				tableBody = jQuery('.IMLinker .table-patterns tbody')
			;
			
			IML_formTablePatternsRow(tableBody, selectedValue, selectedText);
			
			var lastRow = tableBody.find('tr:last');
			
			IML_bindEventsToTablePatternsRow(tableBody, lastRow);
		});
		
	});
</script>
<!-- --------------------------------------------------- -->
<!-- OpenCart Style End -->
<!-- --------------------------------------------------- -->

<style type="text/css">

	/* Fix */
	
	#header .div3 img
	{
		vertical-align:baseline;
	}
	
	#menu > ul li li
	{
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
		min-height: 27px;
		min-width: 155px;
		margin: 0px;
	}

	#menu > ul li li a
	{
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}
	
	#menu > ul li ul ul
	{
		margin-top: -27px;
	}
	
	.breadcrumb
	{
		margin-bottom: 0px;
	}
	
	.breadcrumb a
	{
		text-decoration: underline;
	}
	
	/* Fix End */

	.form-group span.blue
	{
		color: #000042;
    	font-size: 15px;
	}
	
	.IMLinker .hidden
	{
		display: none;
	}
	
	select.im-product-list-select 
	{
	    height: 305px;
	}

	.IMLinker .iml-cursor
	{
		cursor: pointer;
	}
	
	.IMLinker .status-text.success,
	.IMLinker .save-status.success,
	.IMLinker .generate-status.success,
	.IMLinker .get-product-status.success,
	.IMLinker .get-delete-settings-status.success
	{
    	color: green;
	}

	.IMLinker .status-text.fail,
	.IMLinker .save-status.fail,
	.IMLinker .generate-status.fail,
	.IMLinker .get-product-status.fail,
	.IMLinker .get-delete-settings-status.fail
	{
    	color: red;
	}

	.IMLinker .textcontrol-min-height
	{
		min-height: 100px;
	}

	.IMLinker table td.vert-align
	{
		vertical-align: middle;
	}

</style>
