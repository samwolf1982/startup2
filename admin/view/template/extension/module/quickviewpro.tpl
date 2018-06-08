<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
	   
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab-general-setting" data-toggle="tab"><?php echo $tab_general_setting; ?></a></li>
				<li><a href="#tab-btn-setting" data-toggle="tab"><?php echo $tab_btn_setting; ?></a></li>
				<li><a href="#tab-on-off-setting" data-toggle="tab"><?php echo $tab_on_off_setting; ?></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-general-setting">
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_additional_image; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_additional_image" id="input-status" class="form-control">
                <?php if ($config_quickview_additional_image) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_addtocart; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_addtocart" id="input-status" class="form-control">
                <?php if ($config_quickview_addtocart) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_wishlist; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_wishlist" id="input-status" class="form-control">
                <?php if ($config_quickview_wishlist) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>   
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_compare; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_compare" id="input-status" class="form-control">
                <?php if ($config_quickview_compare) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_tab_description; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_tab_description" id="input-status" class="form-control">
                <?php if ($config_quickview_tab_description) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_specification; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_tab_specification" id="input-status" class="form-control">
                <?php if ($config_quickview_tab_specification) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_review_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_tab_review_quickview" id="input-status" class="form-control">
                <?php if ($config_quickview_tab_review_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_options_count; ?></label>
            <div class="col-sm-10">
             <input class="form-control" name="config_quickview_options_count"  value="<?php echo $config_quickview_options_count;?>"/>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_manufacturer; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_manufacturer" id="input-status" class="form-control">
                <?php if ($config_quickview_manufacturer) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_model; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_model" id="input-status" class="form-control">
                <?php if ($config_quickview_model) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_quantity; ?></label>
            <div class="col-sm-10">
              <select name="config_quickview_quantity" id="input-status" class="form-control">
                <?php if ($config_quickview_quantity) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
			<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $entry_btn_name; ?></label>
					<div class="col-sm-5">
					<tr>
						<td class="text-left"><?php foreach ($languages as $language) { ?>
                <div class="input-group"><span class="input-group-addon"><img src="<?php echo version_compare(VERSION, '2.2.0', '>=') ? "language/{$language['code']}/{$language['code']}.png" : "view/image/flags/{$language['image']}"; ?>" title="<?php echo $language['name']; ?>" /></span>
                          <input name="config_quickview_btn_name[<?php echo $language['language_id']; ?>][config_quickview_btn_name]" value="<?php echo isset($config_quickview_btn_name[$language['language_id']]) ? $config_quickview_btn_name[$language['language_id']]['config_quickview_btn_name'] : ''; ?>" class="form-control" />
                        </div>
                        <?php } ?></td>
					</tr>
					</div>
			</div>
				</div>
				<div class="tab-pane" id="tab-btn-setting">
				<?php if(empty($config_quickview_background_btnaddtocart)) $config_quickview_background_btnaddtocart           			= "#2B8CDB";?>
			<?php if(empty($config_quickview_textcolor_btnaddtocart)) $config_quickview_textcolor_btnaddtocart           			= "#FFFFFF";?>
			<?php if(empty($config_quickview_background_btnaddtocart_hover)) $config_quickview_background_btnaddtocart_hover     	= "#1c7dcc";?>
			<?php if(empty($config_quickview_textcolor_btnaddtocart_hover)) $config_quickview_textcolor_btnaddtocart_hover       	= "#FFFFFF";?>
			<?php if(empty($config_quickview_background_btnwishlist)) $config_quickview_background_btnwishlist           			= "#333333";?>
			<?php if(empty($config_quickview_textcolor_btnwishlist)) $config_quickview_textcolor_btnwishlist           				= "#FFFFFF";?>
			<?php if(empty($config_quickview_background_btnwishlist_hover)) $config_quickview_background_btnwishlist_hover          = "#1c7dcc";?>
			<?php if(empty($config_quickview_textcolor_btnwishlist_hover)) $config_quickview_textcolor_btnwishlist_hover           	= "#FFFFFF";?>
			<?php if(empty($config_quickview_background_btncompare)) $config_quickview_background_btncompare           				= "#333333";?>
			<?php if(empty($config_quickview_textcolor_btncompare)) $config_quickview_textcolor_btncompare           				= "#FFFFFF";?>
			<?php if(empty($config_quickview_background_btncompare_hover)) $config_quickview_background_btncompare_hover           	= "#1c7dcc";?>
			<?php if(empty($config_quickview_textcolor_btncompare_hover)) $config_quickview_textcolor_btncompare_hover           	= "#FFFFFF";?>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_background_btnaddtocart; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_background_btnaddtocart"  value="<?php echo $config_quickview_background_btnaddtocart;?>"/>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_textcolor_btnaddtocart; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_textcolor_btnaddtocart"  value="<?php echo $config_quickview_textcolor_btnaddtocart;?>"/>
            </div>
          </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_background_btnaddtocart_hover; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_background_btnaddtocart_hover"  value="<?php echo $config_quickview_background_btnaddtocart_hover;?>"/>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_textcolor_btnaddtocart_hover; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_textcolor_btnaddtocart_hover"  value="<?php echo $config_quickview_textcolor_btnaddtocart_hover;?>"/>
            </div>
          </div>
		  
		  
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_background_btnwishlist; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_background_btnwishlist"  value="<?php echo $config_quickview_background_btnwishlist;?>"/>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_textcolor_btnwishlist; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_textcolor_btnwishlist"  value="<?php echo $config_quickview_textcolor_btnwishlist;?>"/>
            </div>
          </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_background_btnwishlist_hover; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_background_btnwishlist_hover"  value="<?php echo $config_quickview_background_btnwishlist_hover;?>"/>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_textcolor_btnwishlist_hover; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_textcolor_btnwishlist_hover"  value="<?php echo $config_quickview_textcolor_btnwishlist_hover;?>"/>
            </div>
          </div>
		  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_background_btncompare; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_background_btncompare"  value="<?php echo $config_quickview_background_btncompare;?>"/>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_textcolor_btnwishlist; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_textcolor_btncompare"  value="<?php echo $config_quickview_textcolor_btncompare;?>"/>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_background_btncompare_hover; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_background_btncompare_hover"  value="<?php echo $config_quickview_background_btncompare_hover;?>"/>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_textcolor_btnwishlist_hover; ?></label>
            <div class="col-sm-10">
             <input class="form-control" type="color" name="config_quickview_textcolor_btncompare_hover"  value="<?php echo $config_quickview_textcolor_btncompare_hover;?>"/>
            </div>
          </div>
		  
	</div>
	<div class="tab-pane" id="tab-on-off-setting">
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_featured_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_featured_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_featured_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div> 
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_latest_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_latest_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_latest_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_bestseller_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_bestseller_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_bestseller_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_special_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_special_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_special_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_category_page_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_category_page_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_category_page_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_search_page_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_search_page_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_search_page_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_manufacturer_page_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_manufacturer_page_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_manufacturer_page_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_on_off_special_page_quickview; ?></label>
            <div class="col-sm-10">
              <select name="config_on_off_special_page_quickview" id="input-status" class="form-control">
                <?php if ($config_on_off_special_page_quickview) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>		
	</div>
</div>
			
			
			
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>