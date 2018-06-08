<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-min-order-total" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($update) { ?>
    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $update; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>	
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-min-order-total" class="form-horizontal">
			<ul class="nav nav-tabs" id="tabs">
				<li class="active"><a href="#tab-setting" data-toggle="tab"><i class="fa fa-fw fa-wrench"></i> <?php echo $tab_setting; ?></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-setting">  
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select name="min_order_total_status" id="input-status" class="form-control">
								<?php if ($min_order_total_status) { ?>
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
						<label class="col-sm-2 control-label" for="input-total-type"><?php echo $entry_total_type; ?></label>
						<div class="col-sm-10">
							<select name="min_order_total_type" id="input-total-type" class="form-control">
								<?php if ($min_order_total_type == 'total') { ?>
								<option value="total" selected="selected"><?php echo $text_use_total; ?></option>
								<option value="subtotal"><?php echo $text_use_subtotal; ?></option>
								<?php } else { ?>
								<option value="total"><?php echo $text_use_total; ?></option>
								<option value="subtotal" selected="selected"><?php echo $text_use_subtotal; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>						
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-amount"><span data-toggle="tooltip" title="<?php echo $help_min_order_amount; ?>"><?php echo $entry_min_order_amount;?></span></label>
						<div class="col-sm-3">
							<div class="input-group">
								<input type="text" name="min_order_total_amount" placeholder="<?php echo $entry_min_order_amount;?>" id="input-amount" value="<?php echo $min_order_total_amount; ?>" class="form-control" />
								<span class="input-group-addon"><?php echo $currency_symbol; ?></span>
							</div>	
							<?php if ($error_min_order_amount) { ?>
							<div class="text-danger"><?php echo $error_min_order_amount; ?></div>
							<?php } ?>
						</div>
					</div>			  

					<ul class="nav nav-tabs" id="language">
						<?php foreach ($languages as $language) { ?>
						<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
						<?php } ?>
					</ul>
					
					<div class="tab-content">
						<?php foreach ($languages as $language) { ?>
						<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">						    
							<div class="form-group required subtotal-msg">
								<label class="col-sm-2 control-label" for="input-subtotal-message<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_subtotal_warning; ?>"><?php echo $entry_subtotal_warning; ?></span></label>
								<div class="col-sm-10">
								  <input type="text" name="min_order_total_message[<?php echo $language['language_id']; ?>][subtotal_message]" value="<?php echo isset($min_order_total_message[$language['language_id']]) ? $min_order_total_message[$language['language_id']]['subtotal_message'] : ''; ?>" placeholder="<?php echo $entry_subtotal_warning; ?>" id="input-subtotal-message-<?php echo $language['language_id']; ?>" class="form-control" />
								  <?php if (isset($error_subtotal_message[$language['language_id']])) { ?>
								  <div class="text-danger"><?php echo $error_subtotal_message[$language['language_id']]; ?></div>
								  <?php } ?>
								</div>
							</div>
							<div class="form-group required total-msg">
								<label class="col-sm-2 control-label" for="input-total-message<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_total_warning; ?>"><?php echo $entry_total_warning; ?></span></label>
								<div class="col-sm-10">
								  <input type="text" name="min_order_total_message[<?php echo $language['language_id']; ?>][total_message]" value="<?php echo isset($min_order_total_message[$language['language_id']]) ? $min_order_total_message[$language['language_id']]['total_message'] : ''; ?>" placeholder="<?php echo $entry_total_warning; ?>" id="input-total-message-<?php echo $language['language_id']; ?>" class="form-control" />
								  <?php if (isset($error_total_message[$language['language_id']])) { ?>
								  <div class="text-danger"><?php echo $error_total_message[$language['language_id']]; ?></div>
								  <?php } ?>
								</div>
							</div>
						</div>		
						<?php } ?>
					</div>	
				</div>
				
			</div>
        </form>
    </div>
  </div>
</div> 
<script type="text/javascript"><!--
$('#language li:first-child a').tab('show');

$('select[name=\'min_order_total_type\']').on('change', function() {
	if ($(this).val() == 'total') {
		$('.subtotal-msg').hide();
		$('.total-msg').show();
	} else {
		$('.total-msg').hide();
		$('.subtotal-msg').show();
	}
});

$('select[name=\'min_order_total_type\']').trigger('change');
//--></script>
<?php echo $footer; ?>