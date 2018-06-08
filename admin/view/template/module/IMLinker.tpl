<?php echo $header; ?><?php echo $column_left; ?>

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

<div id="content">
	<div class="container-fluid page-header">
		<div class="breadcrumb">
		  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		  		<?php echo $breadcrumb['separator']; ?>
		  			<a href="<?php echo $breadcrumb['href']; ?>">
		  		<?php echo $breadcrumb['text']; ?></a>
		  	<?php } ?>
		</div>
	</div>

	<?php if ($error_warning) { ?>
		<div class="warning">
			<?php echo $error_warning; ?>
		</div>
	<?php } ?>

	<div class="box">
		<div class="container-fluid">
		  	<div class="heading">
		    	<h1>
		    		<?php echo $h1_text; ?> - <small><?php echo $h2_text; ?></small>
		    	</h1>
				<br/>
		  	</div>
		</div>
	  	<div style="clear:both;"></div>
		<div class="content IMLinker" >
			<!-- --------------------------------------------------- -->
			<!-- OpenCart Style Start -->
			<!-- --------------------------------------------------- -->
			<div class="container-fluid">
				<div class="panel panel-default">
					<div class="panel-body">
					<ul class="nav nav-pills" id="iml-tabs">
						<li>
							<a href="#mlcp" data-toggle="tab">
								<i class="fa fa-refresh"></i>
								<?php echo echoLabel($module_label, 'label_iml_mlpc'); ?>
							</a>	
						</li>
						<li>
							<a href="#schema" data-toggle="tab">
								<i class="fa fa-sort-amount-asc"></i>
								<?php echo echoLabel($module_label, 'label_iml_schema'); ?>
							</a>	
						</li>
					</ul>
					<div class="tab-content">
					<!-- ------------ -->
					<!-- Circle -->
					<!-- ------------ -->
					<div class="tab-pane" id="mlcp">
		           			
						<form class="form IMLinker-form" 
							action="<?php echo $replace; ?>" method="post" 
							enctype="multipart/form-data" 
							id="form_gen_mlcp"
						>
							<input type="hidden" 
								name="IMLinker[type]" 
								value="mlcp" />

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
												echoHtmlSelect('IMLinker[pattern_list]', $list_pattern_list['mlcp'], ''); 
											?>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label">
													&nbsp;
												</label>
												<div class="buttons">
													<a class="button btn-im-get-settings btn btn-primary" 
														style="color:white">
														<i class="fa fa-download"></i> &nbsp; 
														<?php echo 
															echoLabel($module_btn_label, 'button_get_settings'); ?>
													</a>
													<a class="button btn-im-delete-settings btn btn-danger" 
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
													<a class="button btn-im-save btn btn-primary" 
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
									<!-- Filter -->
									<!-------------------------->
									<div class="col-sm-12">
										<div class="col-sm-6">
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_cat'); ?>
											</label>
											<?php echo 
												echoHtmlSelectMany('IMLinker[cat][]', $list_cat); ?>
											</div>
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_man'); ?>
											</label>
											<?php echo 
												echoHtmlSelectMany('IMLinker[manufact][]', $list_manufact); ?>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label">
													&nbsp;
												</label>
												<div class="buttons">
													<a class="button btn-im-get-product btn btn-primary" 
														style="color:white">
														<i class="fa fa-bars"></i> &nbsp; 
														<?php echo 
															echoLabel($module_btn_label, 'button_get_product'); ?>
													</a>
													<span class="get-product-status"></span>
												</div>
											</div>
											<div class="form-group im-product-list">
												<label class="control-label">
												<?php echo 
													echoLabel($module_label, 'label_filter_product_list'); ?>
												</label>
												<select name="IMLinker[product_filter][]" 
														class="form-control im-product-list-select" 
														multiple="multiple">		
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="col-sm-6">
											<?php echo echoDate('IMLinker[date_create_start]',
																$module_label, 
																'label_filter_date_create_start',
																'',
																''); ?>
											<?php echo echoDate('IMLinker[date_create_end]',
																$module_label, 
																'label_filter_date_create_end',
																'',
																''); ?>
										</div>
										<div class="col-sm-6">
											<?php echo echoDate('IMLinker[date_modify_start]',
																$module_label, 
																'label_filter_date_modify_start',
																'',
																''); ?>
											<?php echo echoDate('IMLinker[date_modify_end]',
																$module_label, 
																'label_filter_date_modify_end',
																'',
																''); ?>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="col-sm-12">
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_main_cat'); ?>
											</label>
											<?php echo 
												echoHtmlSelect('IMLinker[main_cat]', 
													$list_main, '', 'filter-main-category'); ?>
											</div>
										</div>
									</div>
									
									<div class="col-sm-12">
										<div class="col-sm-6">
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_order'); ?>
											</label>
											<?php echo 
												echoHtmlSelect('IMLinker[product_order]', 
													$list_product_order, '', ''); ?>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_lang_sort'); ?>
											</label>
											<?php echo 
												echoHtmlSelect('IMLinker[sort_language_id]', 
													$list_langs, '', '', false, 'language_id'); ?>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<!-------------------------->
										<!-- Before -->
										<!-------------------------->

										<div class="col-sm-6">
											<?php
												echo echoSelectControl(
													$list_generate_count,
													'IMLinker[before_count]',
													$module_label,
													'label_before_count',
													'3',
													''
												);
											?>
										</div>
										<!-------------------------->
										<!-- After -->
										<!-------------------------->

										<div class="col-sm-6">
											<?php
												echo echoSelectControl(
													$list_generate_count,
													'IMLinker[after_count]',
													$module_label,
													'label_after_count',
													'3',
													''
												);
											?>
										</div>
									</div>
									<!-------------------------->
									<!-- Attr Filter -->
									<!-------------------------->
									<div class="col-sm-12">
										<div class="col-sm-12">
											<h2>
												<?php echo
													echoLabel($module_label, 'label_filter_attr_list_header'); 
												?>	
											</h2>	
										</div>
										<!-- Lang -->
										<div class="col-sm-12">
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_lang_attr'); ?>
											</label>
											<?php echo 
												echoHtmlSelect('IMLinker[attr_language_id]', 
													$list_langs, '', '', false, 'language_id'); ?>
											</div>
										</div>
										<!-- Table with Filter -->
										<div class="table-responsive col-sm-12">
											<table class="table table-bordered table-attr-filter">
												<tbody>
													
												</tbody>
											</table>
										</div>
										<!-- Attr Filter -->
										<div class="col-sm-6">
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_attr_list'); ?>
											</label>
											<?php echo 
												echoHtmlSelect('imlinker_attr_list', 
													$list_attr, '', 'imlinker_attr_list'); ?>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
											<label class="control-label">
												&nbsp;
											</label>
											<div>
												<button type="button" class="btn btn-primary button-add-attr">
													<i class="fa fa-plus-circle"></i> 
									  					<?php echo 
															echoLabel($module_btn_label, 'button_attr_add'); ?>
									  			</button>
												<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
											</div>
											</div>
										</div>
									</div>

									<!-------------------------->
									<!-- Option Filter -->
									<!-------------------------->
									<div class="col-sm-12">
										<div class="col-sm-12">
											<h2>
												<?php echo
													echoLabel($module_label, 'label_filter_option_list_header'); 
												?>	
											</h2>	
										</div>
										<!-- Table with Filter -->
										<div class="table-responsive col-sm-12">
											<table class="table table-bordered table-option-filter">
												<tbody>
													
												</tbody>
											</table>
										</div>
										<!-- Option Filter -->
										<div class="col-sm-6">
											<div class="form-group">
											<label class="control-label">
											<?php echo 
												echoLabel($module_label, 'label_filter_option_list'); ?>
											</label>
											<?php echo 
												echoHtmlSelect('imlinker_option_list', 
													$list_option, '', 'imlinker_option_list'); ?>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
											<label class="control-label">
												&nbsp;
											</label>
											<div>
												<button type="button" class="btn btn-primary button-add-option">
													<i class="fa fa-plus-circle"></i> 
									  					<?php echo 
															echoLabel($module_btn_label, 'button_option_add'); ?>
									  			</button>
												<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
											</div>
											</div>
										</div>
									</div>
									
									<?php
										echo echoHiddenOptionData($list_option_data, 'imlinker_option_data_list');
									?>
									
									<!-------------------------->
									<!-- End Filter -->
									<!-------------------------->
									<div class="col-sm-12">
										<hr/>
									</div>
									
									<!-------------------------->
									<!-- Button Generate Seo -->
									<!-------------------------->
									
									<div class="col-sm-12">
										<div class="form-group">
											<div class="buttons">
												<a class="button btn-im-generate btn btn-success" 
													style="color:white">
													<i class="fa fa-save"></i> &nbsp; 
													<?php echo 
														echoLabel($module_btn_label, 'button_generate'); ?>
												</a>
												&nbsp;&nbsp;&nbsp;
												<a class="button btn-im-generate-clear btn btn-warning" 
													style="color:white">
													<i class="fa fa-eraser"></i> &nbsp; 
													<?php echo 
														echoLabel($module_btn_label, 'button_generate_clear'); ?>
												</a>
												&nbsp;&nbsp;&nbsp;
												<span class="generate-status"></span>
											</div>
										</div>
									</div>
									
								</div>
							</div>

							<div class="form panel-body">
							<?php
								echo echoAvalCapabilities();
							?>
							</div>
						</form>
					</div>
				
					<!-- ------------ -->
					<!-- Schema -->
					<!-- ------------ -->
					<?php echo $linker_schema_view; ?>
				
					</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				var module_links = {
					getSettings: 
						decodeURIComponent('<?php echo $module_links["getSettings"] ?>')
						.replace('&amp;', '&'),
					saveSettings: 
						decodeURIComponent('<?php echo $module_links["saveSettings"] ?>')
						.replace('&amp;', '&'),
					deleteSettings: 
						decodeURIComponent('<?php echo $module_links["deleteSettings"] ?>')
						.replace('&amp;', '&'),
					cancel: 
						decodeURIComponent('<?php echo $module_links["cancel"] ?>')
						.replace('&amp;', '&'),
					generateSeo: 
						decodeURIComponent('<?php echo $module_links["generateSeo"] ?>')
						.replace('&amp;', '&'),
					getProductList:
						decodeURIComponent('<?php echo $module_links["getProductList"] ?>')
						.replace('&amp;', '&'),
					generateSeoById:
						decodeURIComponent('<?php echo $module_links["generateSeoById"] ?>')
						.replace('&amp;', '&')
					
				};
				var module_label = {
					attrAdd: "<?php echo echoLabel($module_btn_label, 'button_attr_add'); ?>",
					optionAdd: "<?php echo echoLabel($module_btn_label, 'button_option_add'); ?>"
				};
			</script>
			<script type="text/javascript">
				
				// 1.3
				// Ajax-операция
				function ajaxOperation(options) {
					var form = options.form
					;
					
					if (jQuery(form).length == 0 || !options.form)
						return;
					
					if ((options.status || {}).selector) {
						form.find(options.status.selector)
						.removeClass('fail')
						.removeClass('success')
						.html(options.status.text.action);
					}
					
					// Выполняем запрос
					jQuery.ajax({
						type: 'POST',
						url: options.url,		
						data: (options.data ? options.data : form.serializeArray()),
						dataType: 'json',
						success: function(json) {
							if ((options.status || {}).selector) {
								if (json['success']) {
									form.find(options.status.selector)
									.removeClass('fail')
									.addClass('success')
									.html(options.status.text.success);
								}
								else {
									form.find(options.status.selector)
									.removeClass('success')
									.addClass('fail')
									.html(options.status.text.fail);
								}
							}
							if(typeof options.onLoad == 'function') {
								options.onLoad(json);
							}
						}
					});
				}
				
				// Сохранить настройки
				function saveSettings(form) {
					// Форма еще не выстроена
					if (form.serializeArray().length == 0)
						return;
					
					ajaxOperation({
						form: form,
						url: module_links.saveSettings,
						status: {
							selector: '.save-status',
							text: {
								action: 'Сохраняем...',
								success: 'Настройки cохранены!',
								fail: 'Настройки не cохранены!'
							}
						},
						onLoad: function (json) {
							if(json['success']) {
								var select = form.find('select[name="IMLinker\[pattern_list\]"]'),
									selectedItemValue = form.find('*[name="IMLinker\[pattern_name\]"]').val(),
									vals = json['pattern_list']
								;
								
								select.find('option').remove();
								
								// Перезаполняем список
								for(var cnt = 0; cnt < vals.length; cnt++) {
									var is_selected = (vals[cnt]['name'] == selectedItemValue
												? ' selected="selected" ' : '')
									;
									select.append(
										'<option ' + is_selected +  ' value="' + vals[cnt]['id'] + '" >' 
											+ vals[cnt]['name'] 
										+ '</option>'
									);
								}

								// 1.3
								// Перезагружаем список в схемах
								IML_resetAllPatternList(json);
							}
						}
					});
				}
				
				// Удаление настроек
				function deleteSettings(form) {
					// Форма еще не выстроена
					if (form.serializeArray().length == 0)
						return;

					ajaxOperation({
						form: form,
						url: module_links.deleteSettings,
						status: {
							selector: '.get-delete-settings-status',
							text: {
								action: 'Удаляем...',
								success: 'Шаблон настроек удален!',
								fail: 'Шаблон настроек не удален!'
							}
						},
						onLoad: function (json) {
							if(json['success']) {
								var select = form.find('select[name="IMLinker\[pattern_list\]"]'),
									vals = json['pattern_list']
								;
								
								select.find('option').remove();
								
								// Перезаполняем список
								for(var cnt = 0; cnt < vals.length; cnt++) {
									select.append(
										'<option value="' + vals[cnt]['id'] + '" >' 
											+ vals[cnt]['name'] 
										+ '</option>'
									);
								}

								// 1.3
								// Перезагружаем список в схемах
								IML_resetAllPatternList(json);
							}
						}
					});				
				}
				
				// Получение настроек и восстановление формы
				function getSettings(form) {
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
								
								form.find('.im-product-list-select option').remove();
								
								if ('' + selectPattern.val() != '-1') {
									inputPattern.val(selectPattern.text());
								}
								// 1.3
								else {
									return;
								}

								// 1.3
								form.find('.table-attr-filter tr').remove();
								form.find('.table-option-filter tr').remove();
								
								
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
										else if (item.is('textarea')) {
											item.val(values);
										}
										// Если список с чекбоксами
										else if (itemList.length > 0 && values) {
											itemList.prop('checked', null);
											
											for(var cnt = 0; cnt < values.length; cnt++) {
												itemList.filter('*[value="' + values[cnt] + '"]')
												.prop('checked', 'checked');
											}
										}
										//////////////////////////////////////////
										// Восстановление фильтра по атрибутам
										//////////////////////////////////////////
										else if (key == 'attr_filter') {
											var tableBody = form.find('.table-attr-filter tbody'),
												selectAttr = form.find('.imlinker_attr_list')
											;
											
											// Проходимся по всем атрибутам и восстанавливаем фильтр
											for(var attrItemKey in values) {
												if (values.hasOwnProperty(attrItemKey)) {
													var attrItem = values[attrItemKey],
														attrItemValues = attrItem['values'],
														val = attrItem['id'],
														name = selectAttr.find('option[value=' + val + ']').text()
													;
													
													// Восстанавливаем строку
													tableBody.append(
														'<tr>'
															+ '<td>'
																+ '<b>'
																	+ name
																+ '</b>'
																+ '<input type="hidden" ' 
																	+ ' name="IMLinker[attr_filter][' + val + '][id]" value="' + val + '"/>'
															+ '</td>'
															+ '<td>'
																+ '<div class="col-sm-12">'
																	+ '&nbsp;'
																+ '</div>'
																+ '<div class="col-sm-12">'
																	+ '<button type="button" class="btn btn-add-attr-row-cell btn-primary" >'
																		+ '<i class="fa fa-plus-circle"></i> '
																		+ module_label.attrAdd
																	+ '</button>'
																+ '</div>'
															+ '</td>'
															+ '<td>'
																+ '<button type="button" class="btn btn-delete-attr-row btn-danger" >'
																	+ '<i class="fa fa-minus-circle"></i>'
																+ '</button>'
															+ '</td>'
														+ '</tr>'
													);
													
													var lastRow = tableBody.find('tr:last'),
														lastRowCell = lastRow.find('td:eq(1)'),
														lastRowCellInsertBefore = lastRowCell.find('div:last').prev()
													;
													
													// Восстанавливаем значения
													for (var cntValues = 0; cntValues < attrItemValues.length; cntValues++)
													{
														jq(
															'<div class="col-sm-10">'
																+ '<input type="text" class="form-control" placeholder="' + name + '" '
																	+ ' name="IMLinker[attr_filter][' + val + '][values][]" '
																	+ ' value="' + attrItemValues[cntValues] + '" />'
															+ '</div>'
															+ '<div class="col-sm-2">'
																+ '<button type="button" class="btn btn-delete-attr-row-cell btn-danger" >'
																	+ '<i class="fa fa-minus-circle"></i>'
																+ '</button>'
															+ '</div>'
														)
														.insertBefore(lastRowCellInsertBefore);
													}
												}
											}
											
											// Определяем обработчики событий
											// Удаление строки
											tableBody.find('tr .btn-delete-attr-row').click(function () {
												jq(this).closest('tr').remove();
											});
											
											// Удалить значение
											tableBody.find('tr .btn-delete-attr-row-cell').click(function () { 
												jq(this).closest('div').prev().remove();
												jq(this).closest('div').remove();
											});

											// Добавить значение
											tableBody.find('tr .btn-add-attr-row-cell').click(function () { 
												var appendItem = jq(
														'<div class="col-sm-10">'
															+ '<input type="text" class="form-control" placeholder="' + name + '" '
																+' name="IMLinker[attr_filter][' + val + '][values][]"/>'
														+ '</div>'
														+ '<div class="col-sm-2">'
															+ '<button type="button" class="btn btn-delete-attr-row-cell btn-danger" >'
																+ '<i class="fa fa-minus-circle"></i>'
															+ '</button>'
														+ '</div>'
													)
												;
												
												appendItem.insertBefore(jq(this).closest('div').prev());
												appendItem.find('.btn-delete-attr-row-cell').click(function () { 
													jq(this).closest('div').prev().remove();
													jq(this).closest('div').remove();
												});
											});
										}
										//////////////////////////////////////////
										// Восстановление фильтра по опциям
										//////////////////////////////////////////
										else if (key == 'option_filter') {
											var tableBody = form.find('.table-option-filter tbody'),
												selectOption = form.find('.imlinker_option_list')
											;
											
											// Проходимся по всем атрибутам и восстанавливаем фильтр
											for(var optionItemKey in values) {
												if (values.hasOwnProperty(optionItemKey)) {
													var optionItem = values[optionItemKey],
														optionItemValues = optionItem['values'],
														val = optionItem['id'],
														name = selectOption.find('option[value=' + val + ']').text()
													;
													
													// Восстанавливаем строку
													tableBody.append(
														'<tr>'
															+ '<td>'
																+ '<b>'
																	+ name
																+ '</b>'
																+ '<input type="hidden" ' 
																	+ ' name="IMLinker[option_filter][' + val + '][id]" value="' + val + '"/>'
															+ '</td>'
															+ '<td>'
																+ '<div class="col-sm-12">'
																	+ '&nbsp;'
																+ '</div>'
																+ '<div class="col-sm-12">'
																	+ '<button type="button" class="btn btn-add-option-row-cell btn-primary" >'
																		+ '<i class="fa fa-plus-circle"></i> '
																		+ module_label.optionAdd
																	+ '</button>'
																+ '</div>'
															+ '</td>'
															+ '<td>'
																+ '<button type="button" class="btn btn-delete-option-row btn-danger" >'
																	+ '<i class="fa fa-minus-circle"></i>'
																+ '</button>'
															+ '</td>'
														+ '</tr>'
													);
													
													var lastRow = tableBody.find('tr:last'),
														lastRowCell = lastRow.find('td:eq(1)'),
														lastRowCellInsertBefore = lastRowCell.find('div:last').prev(),
														selectPattern = getOptionSelectHtml(form, val, 
															'IMLinker[option_filter][' + val + '][values][]') 
													;
													
													// Восстанавливаем значения
													for (var cntValues = 0; cntValues < optionItemValues.length; cntValues++)
													{
														var valItem = jq(
															'<div class="col-sm-10">'
																+ selectPattern
															+ '</div>'
															+ '<div class="col-sm-2">'
																+ '<button type="button" class="btn btn-delete-option-row-cell btn-danger" >'
																	+ '<i class="fa fa-minus-circle"></i>'
																+ '</button>'
															+ '</div>'
														);
														
														valItem.insertBefore(lastRowCellInsertBefore);
														
														valItem
														.find('select option[value=' + optionItemValues[cntValues] + ']')
														.prop('selected', 'selected');
													}
												}
											}
											
											// Определяем обработчики событий
											// Удаление строки
											tableBody.find('tr .btn-delete-option-row').click(function () {
												jq(this).closest('tr').remove();
											});
											
											// Удалить значение
											tableBody.find('tr .btn-delete-option-row-cell').click(function () { 
												jq(this).closest('div').prev().remove();
												jq(this).closest('div').remove();
											});

											// Добавить значение
											tableBody.find('tr .btn-add-option-row-cell').click(function () { 
												var appendItem = jq(
														'<div class="col-sm-10">'
															+ getOptionSelectHtml(form, val, 
																'IMLinker[option_filter][' + val + '][values][]') 
														+ '</div>'
														+ '<div class="col-sm-2">'
															+ '<button type="button" class="btn btn-delete-option-row-cell btn-danger" >'
																+ '<i class="fa fa-minus-circle"></i>'
															+ '</button>'
														+ '</div>'
													)
												;
												
												appendItem.insertBefore(jq(this).closest('div').prev());
												appendItem.find('.btn-delete-option-row-cell').click(function () { 
													jq(this).closest('div').prev().remove();
													jq(this).closest('div').remove();
												});
											});
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
				
				// Запуск генерации
				function generateSeo(form) {
					// Форма еще не выстроена
					if (form.serializeArray().length == 0)
						return;

					ajaxOperation({
						form: form,
						url: module_links.generateSeo,
						status: {
							selector: '.generate-status',
							text: {
								action: 'Генерируем...',
								success: 'Данные сгенерированы!',
								fail: 'Данные не сгенерированы!'
							}
						},
						onLoad: null
					});	
				}

				// Запуск генерации
				function generateSeoClear(form) {
					// Форма еще не выстроена
					if (form.serializeArray().length == 0)
						return;

					ajaxOperation({
						form: form,
						url: module_links.generateSeo,
						status: {
							selector: '.generate-status',
							text: {
								action: 'Очищаем...',
								success: 'Связи очищены!',
								fail: 'Связи не очищены!'
							}
						},
						onLoad: function (json) {
							form.find('input[name="IMLinker\[is_clear_only\]"]').remove();
						}
					});	
				}
				
				// Загрузка продуктов
				function getProductList(form) {
					// Форма еще не выстроена
					if (form.serializeArray().length == 0)
						return;

					form.find('.im-product-list-select option').remove();

					ajaxOperation({
						form: form,
						url: module_links.getProductList,
						status: {
							selector: '.get-product-status',
							text: {
								action: 'Получаем список...',
								success: 'Список загружен!',
								fail: 'Данные не получены!'
							}
						},
						onLoad: function (json) {
							var select = form.find('.im-product-list-select')
							;

							$.each(json['data'] || [], function () {
								select.append(
									'<option value="' + this.id + '">'
										+ this.name + ' [' + this.id + ']'
									+ '</option>'
								);
							});
						}
					});	
				}
				
				// Формирование select option_value для js
				function getOptionSelectHtml(form, option_id, name, append_class = '') {
					var jq = jQuery,
						result = ''
					;
					
					form.find('.imlinker_option_data_list data').each(function () {
						var item = jq(this)
						;
						
						if ('' + item.attr('option_id') != '' + option_id)
							return;
						
						result +=
							'<option value="' + item.attr('option_value_id') + '">'
								+ decodeURIComponent(item.attr('option_value_name'))
							+ '</option>'
						;
					});
					
					return '<select name="' + name + '" ' 
								+ ' class="form-control ' + append_class + '" >'
								+ result
							+ '</select>'
					;
				}
				
				jQuery(function () {
					
					/////////////////////////////
					// Верхний фильтр
					/////////////////////////////

					jQuery('.date').datetimepicker({
						pickTime: false
					});
					
					jQuery('#iml-tabs a:first').tab('show');
					
					// Загрузить шаблон
					jQuery('.IMLinker .btn-im-get-settings').click(function () {
						getSettings(jQuery(this).closest('form'));
					});
					
					// Генерация
					jQuery('.IMLinker .btn-im-generate').click(function () {
						generateSeo(jQuery(this).closest('form'));
					});

					// Генерация (очистка)
					jQuery('.IMLinker .btn-im-generate-clear').click(function () {
						jQuery(this).closest('form')
						.append('<input type="hidden" value="1" name="IMLinker[is_clear_only]" />')
						generateSeoClear(jQuery(this).closest('form'));
					});
					
					// Сохранить шаблон
					jQuery('.IMLinker .btn-im-save').click(function () {
						saveSettings(jQuery(this).closest('form'));
					});

					// Удаляем шаблон
					jQuery('.IMLinker .btn-im-delete-settings').click(function () {
						deleteSettings(jQuery(this).closest('form'));
					});

					// Получить список продуктов
					jQuery('.IMLinker .btn-im-get-product').click(function () {
						getProductList(jQuery(this).closest('form'));
					});
					
					/////////////////////////////
					// Фильтр продуктов по атрибутам
					/////////////////////////////
					
					jQuery('.IMLinker .button-add-attr').click(function () {
						var jq = jQuery,
							form = jq(this).closest('form'),
							selectAttr = form.find('.imlinker_attr_list'),
							val = selectAttr.val(),
							name = selectAttr.find(':selected').text(),
							tableBody = form.find('.table-attr-filter tbody'),
							is_exist = tableBody.find('*[name="IMLinker\[attr_filter\]\[' + val + '\]\[id\]"]').length > 0
						;
						
						if (is_exist)
						{
							return;
						}
						
						tableBody.append(
							'<tr>'
								+ '<td>'
									+ '<b>'
										+ name
									+ '</b>'
									+ '<input type="hidden" ' 
										+ ' name="IMLinker[attr_filter][' + val + '][id]" value="' + val + '"/>'
								+ '</td>'
								+ '<td>'
									+ '<div class="col-sm-10">'
										+ '<input type="text" class="form-control" placeholder="' + name + '" '
											+' name="IMLinker[attr_filter][' + val + '][values][]"/>'
									+ '</div>'
									+ '<div class="col-sm-2">'
										+ '<button type="button" class="btn btn-delete-attr-row-cell btn-danger" >'
											+ '<i class="fa fa-minus-circle"></i>'
										+ '</button>'
									+ '</div>'
									+ '<div class="col-sm-12">'
										+ '&nbsp;'
									+ '</div>'
									+ '<div class="col-sm-12">'
										+ '<button type="button" class="btn btn-add-attr-row-cell btn-primary" >'
											+ '<i class="fa fa-plus-circle"></i> '
											+ module_label.attrAdd
										+ '</button>'
									+ '</div>'
								+ '</td>'
								+ '<td>'
									+ '<button type="button" class="btn btn-delete-attr-row btn-danger" >'
										+ '<i class="fa fa-minus-circle"></i>'
									+ '</button>'
								+ '</td>'
							+ '</tr>'
						);
						
						// Удаление строки
						tableBody.find('tr:last .btn-delete-attr-row').click(function () {
							jq(this).closest('tr').remove();
						});
						
						// Удалить значение
						tableBody.find('tr:last .btn-delete-attr-row-cell').click(function () { 
							jq(this).closest('div').prev().remove();
							jq(this).closest('div').remove();
						});

						// Добавить значение
						tableBody.find('tr:last .btn-add-attr-row-cell').click(function () { 
							var appendItem = jq(
									'<div class="col-sm-10">'
										+ '<input type="text" class="form-control" placeholder="' + name + '" '
											+' name="IMLinker[attr_filter][' + val + '][values][]"/>'
									+ '</div>'
									+ '<div class="col-sm-2">'
										+ '<button type="button" class="btn btn-delete-attr-row-cell btn-danger" >'
											+ '<i class="fa fa-minus-circle"></i>'
										+ '</button>'
									+ '</div>'
								)
							;
							
							appendItem.insertBefore(jq(this).closest('div').prev());
							appendItem.find('.btn-delete-attr-row-cell').click(function () { 
								jq(this).closest('div').prev().remove();
								jq(this).closest('div').remove();
							});
						});
					});

					/////////////////////////////
					// Фильтр продуктов по опциям
					/////////////////////////////
					
					jQuery('.IMLinker .button-add-option').click(function () {
						var jq = jQuery,
							form = jq(this).closest('form'),
							selectOption = form.find('.imlinker_option_list'),
							val = selectOption.val(),
							name = selectOption.find(':selected').text(),
							tableBody = form.find('.table-option-filter tbody'),
							is_exist = tableBody.find('*[name="IMLinker\[option_filter\]\[' + val + '\]\[id\]"]').length > 0
						;
						
						if (is_exist)
						{
							return;
						}
						
						tableBody.append(
							'<tr>'
								+ '<td>'
									+ '<b>'
										+ name
									+ '</b>'
									+ '<input type="hidden" ' 
										+ ' name="IMLinker[option_filter][' + val + '][id]" value="' + val + '"/>'
								+ '</td>'
								+ '<td>'
									+ '<div class="col-sm-10">'
										+ getOptionSelectHtml(form, val, 
											'IMLinker[option_filter][' + val + '][values][]')
									+ '</div>'
									+ '<div class="col-sm-2">'
										+ '<button type="button" class="btn btn-delete-option-row-cell btn-danger" >'
											+ '<i class="fa fa-minus-circle"></i>'
										+ '</button>'
									+ '</div>'
									+ '<div class="col-sm-12">'
										+ '&nbsp;'
									+ '</div>'
									+ '<div class="col-sm-12">'
										+ '<button type="button" class="btn btn-add-option-row-cell btn-primary" >'
											+ '<i class="fa fa-plus-circle"></i> '
											+ module_label.optionAdd
										+ '</button>'
									+ '</div>'
								+ '</td>'
								+ '<td>'
									+ '<button type="button" class="btn btn-delete-option-row btn-danger" >'
										+ '<i class="fa fa-minus-circle"></i>'
									+ '</button>'
								+ '</td>'
							+ '</tr>'
						);
						
						// Удаление строки
						tableBody.find('tr:last .btn-delete-option-row').click(function () {
							jq(this).closest('tr').remove();
						});
						
						// Удалить значение
						tableBody.find('tr:last .btn-delete-option-row-cell').click(function () { 
							jq(this).closest('div').prev().remove();
							jq(this).closest('div').remove();
						});

						// Добавить значение
						tableBody.find('tr:last .btn-add-option-row-cell').click(function () { 
							var appendItem = jq(
									'<div class="col-sm-10">'
										+ getOptionSelectHtml(form, val, 
											'IMLinker[option_filter][' + val + '][values][]')
									+ '</div>'
									+ '<div class="col-sm-2">'
										+ '<button type="button" class="btn btn-delete-option-row-cell btn-danger" >'
											+ '<i class="fa fa-minus-circle"></i>'
										+ '</button>'
									+ '</div>'
								)
							;
							
							appendItem.insertBefore(jq(this).closest('div').prev());
							appendItem.find('.btn-delete-option-row-cell').click(function () { 
								jq(this).closest('div').prev().remove();
								jq(this).closest('div').remove();
							});
						});
					});
				});
			</script>
			<!-- --------------------------------------------------- -->
			<!-- OpenCart Style End -->
			<!-- --------------------------------------------------- -->
		</div>
		
  	</div>
</div>

<style type="text/css">
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
	
	.IMLinker .save-status.success,
	.IMLinker .generate-status.success,
	.IMLinker .generate-schema-status.success,
	.IMLinker .get-product-status.success,
	.IMLinker .get-delete-settings-status.success
	{
    	color: green;
	}

	.IMLinker .save-status.fail,
	.IMLinker .generate-status.fail,
	.IMLinker .generate-schema-status.fail,
	.IMLinker .get-product-status.fail,
	.IMLinker .get-delete-settings-status.fail
	{
    	color: red;
	}

	.IMLinker .textcontrol-min-height
	{
		min-height: 100px;
	}

</style>

<?php echo $footer; ?>