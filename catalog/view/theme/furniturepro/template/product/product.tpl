<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <?php echo $content_top; ?>




      <div class="container main-container"  >
        <div class="row">
          <!--        left menu-->
          <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="wrp_zoom">
              <section id="fancy">
                <div class="xzoom-container">
                  <div class="like_me hvr-grow">
                    <img class="likemeimg" src="/image/verstka/categorynprod/likeme.png" alt="like_me" data-toggle="tooltip" data-original-title="Add to Wish List" data-id="<?php echo $product_id; ?>">
                  </div>

                  <div class="full_me hvr-grow">
                    <img class="fullmeimg img-responsive" src="/image/verstka/heap/full.png" alt="full" data-toggle="tooltip" data-original-title="Full screen">
                  </div>

                  <div class="zoomzoom_me hvr-grow">
                    <img class="zoomzoomimg" src="/image/verstka/heap/zoomzoom.png" alt="zoomzoom" data-toggle="tooltip" data-original-title="Zoom">
                  </div>
                  <!--  previev     origianl -->
                  <img   class="xzoom4"  id="xzoom-fancy" src="<?php echo $popup; ?>" xoriginal="<?php echo $popup; ?>"  title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"  />
                </div>

                <div class="clearfix"></div>
                <div class="xzoom-thumbs">
                  <div class="wrp_zoom_nav">

                    <a href="<?php echo $popup; ?>"><img class="xzoom-gallery4 img-responsive"  src="<?php echo $thumb; ?>"  xpreview="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
                  </div>
                  <?php if ($images) { ?>
                  <?php foreach ($images as $image) { ?>

                  <!--       origianl thumbs previev -->
                  <div class="wrp_zoom_nav">
                    <a href="<?php echo $image['popup']; ?>"><img class="xzoom-gallery4 img-responsive"  src="<?php echo $image['thumb']; ?>"  xpreview="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
                  </div>



                  <?php } ?>
                  <?php } ?>



                </div>
            </div>
            <div class="clearfix"></div>
            <div class="share_this">
              <div class="block">
                ПОДЕЛИТЬСЯ
              </div>
              <div class="block">
                <ul>
                  <li><a href=""><i class="fa fa-facebook-square"></i></a>&nbsp;&nbsp; </li>
                  <li><a href=""><i class="fa fa-instagram"></i></a>&nbsp;&nbsp; </li>
                  <li><a href=""><i class="fa fa-pinterest"></i></a>&nbsp;&nbsp; </li>
                </ul>
              </div>
            </div>

          </div>
          <!--        main_content-->
          <div id="content_prod" class="col-xs-12 col-sm-12 col-md-6">
            <!-- Slider start -->
            <div class="">
              <section>
                <h1 class="text-center"><?php echo $heading_title; ?></h1>
                <div id="product">
                  <!--  Area radio options  s  -->
                  <?php if ($options) { ?>
                  <h3 class="hidden"><?php echo $text_option; ?></h3>

                  <div class="panel-group-radio" id="accordion_radio" role="tablist" aria-multiselectable="true">
                    <?php foreach ($options as $key => $option) { ?>
                    <?php if ($option['type'] == 'radio') {  ?>
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion_radio" href="#collapse_radio_<?=$key?>" aria-expanded="true" aria-controls="collapse_radio_<?=$key?>">
                            <label class="control-label"><?php echo $option['name']; ?></label>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse_radio_<?=$key?>" class="panel-collapse collapse   in" role="tabpanel" aria-labelledby="collapse_radio_<?=$key?>">
                        <div class="panel-body">
                          <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">

                            <div id="input-option<?php echo $option['product_option_id']; ?>" class="btn-group" data-toggle="buttons">
                              <?php foreach ($option['product_option_value'] as $option_value) { ?>
                              <div class="radio">
                                <label class="btn btn-primary">
                                  <input autocomplete="off" type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                  <?php if ($option_value['image']) { ?>
                                  <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
                                  <?php } ?>
                                  <?php echo $option_value['name']; ?>
                                  <?php if ($option_value['price']) { ?>
                                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                  <?php } ?>
                                </label>
                              </div>
                              <?php } ?>
                            </div>
                          </div>



                        </div>
                      </div>
                    </div>
                    <?php } ?>



                    <?php } ?>
                  </div>
                  <!--  Area radio options  e  -->
                  <?php } ?>
                 <div class="clearfix"></div>


                  <!--  price area s -->
                  <div class="col-sm-12">


                    <?php if ($price) { ?>
                    <ul class="list-unstyled price">
                      <?php if (!$special) { ?>
                      <li>
                        <span class="<?php echo $live_options['live_options_price_container']; ?> hidden"><?=$price; ?></span>
                        <span class="price-new-live single_price"><?=$price; ?></span>
                        
                      </li>
                      <?php } else { ?>
                      <li>  <span class="<?php echo $live_options['live_options_price_container']; ?>"><?=$price; ?></span></li>
                      <li>
                        <span class="<?php echo $live_options['live_options_special_container']; ?>"><?=$special; ?></span>
                      </li>
                      <?php } ?>
                      <?php if ($tax) { ?>
                      <li> <span class="<?php echo $live_options['live_options_tax_container']; ?>"><?=$tax; ?></span></li>
                      <?php } ?>
                      <?php if ($points) { ?>
                      <li>  <span class="<?php echo $live_options['live_options_points_container']; ?>"><?=$points; ?></span></li>
                      <?php } ?>
                      <?php if ($discounts) { ?>
                      <li>
                        <hr>
                      </li>
                      <?php foreach ($discounts as $discount) { ?>
                      <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
                      <?php } ?>
                      <?php } ?>
                    </ul>
                    <?php } ?>



                    <p class="price hidden">
                      <span class="<?php echo $live_options['live_options_price_container']; ?>"><?=$price; ?></span>
                      <span class="<?php echo $live_options['live_options_special_container']; ?>"><?=$special; ?></span>
                      <span class="<?php echo $live_options['live_options_points_container']; ?>"><?=$points; ?></span>
                      <span class="<?php echo $live_options['live_options_reward_container']; ?>"><?=$reward; ?></span>
                      <span class="<?php echo $live_options['live_options_tax_container']; ?>"><?=$tax; ?></span>
                    </p>
                  </div>

                  <!--  price area e -->
                  <div class="clearfix"></div>


                  <!--  count area s -->

                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="count-input space-bottom">
                        <a class="incr-btn" data-action="decrease" href="#">–</a>
                        <input class="quantity" type="text" name="quantity" value="1"/>
                        <a class="incr-btn" data-action="increase" href="#">&plus;</a>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                      </div>


                    </div>
                    <?php if ($minimum > 1) { ?>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
                    <?php } ?>
                  </div>
                  <!--  count area  e-->








                  <div class="clearfix"></div>
                  <?php if ($options) { ?>
                  <!--  Area select options  s  -->
                  <div class="wrp_select_area">
                  <?php foreach ($options as $option) { ?>
                  <?php if ($option['type'] == 'select') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">

                      <?php if(count($option['product_option_value'])>1000){  ?>
                      <option value=""><?php echo $text_select; ?></option>
                      <?php } ?>


                      <?php foreach ($option['product_option_value'] as $option_value) { ?>
                      <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                        <?php } ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                  <?php } ?>
                  <?php } ?>
                  </div>
                  <!--  Area select options  e  -->





                  <?php foreach ($options as $option) { ?>
                  <?php if ($option['type'] == 'checkbox') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label"><?php echo $option['name']; ?></label>
                    <div id="input-option<?php echo $option['product_option_id']; ?>">
                      <?php foreach ($option['product_option_value'] as $option_value) { ?>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                          <?php if ($option_value['image']) { ?>
                          <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
                          <?php } ?>
                          <?php echo $option_value['name']; ?>
                          <?php if ($option_value['price']) { ?>
                          (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                          <?php } ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($option['type'] == 'text') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                  </div>
                  <?php } ?>
                  <?php if ($option['type'] == 'textarea') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                  </div>
                  <?php } ?>
                  <?php if ($option['type'] == 'file') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label"><?php echo $option['name']; ?></label>
                    <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                    <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
                  </div>
                  <?php } ?>
                  <?php if ($option['type'] == 'date') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <div class="input-group date">
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                      <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
                  </div>
                  <?php } ?>
                  <?php if ($option['type'] == 'datetime') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <div class="input-group datetime">
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                      <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                  </div>
                  <?php } ?>
                  <?php if ($option['type'] == 'time') { ?>
                  <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <div class="input-group time">
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                      <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                  </div>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                  <?php if ($recurrings) { ?>
                  <hr>
                  <h3><?php echo $text_payment_recurring; ?></h3>
                  <div class="form-group required">
                    <select name="recurring_id" class="form-control">
                      <option value=""><?php echo $text_select; ?></option>
                      <?php foreach ($recurrings as $recurring) { ?>
                      <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
                      <?php } ?>
                    </select>
                    <div class="help-block" id="recurring-description"></div>
                  </div>
                  <?php } ?>






   <div class="hidden">
                <div class="col-sm-6 wrp_filter_area filter_area_right ">
                  <p class="text-left">Что-то выбрать</p>
                  <select id="input-sort"  onchange="location = this.value;">
                    <option value="#" selected="selected">От дешевых к дорогим</option>
                    <option value="#">Name (A - Z)</option>
                    <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>
                  </select>
                </div>
                <div class="col-sm-6 wrp_filter_area filter_area_right ">
                  <p class="text-left">&nbsp;</p>
                  <select id="input-sort"  onchange="location = this.value;">
                    <option value="#" selected="selected">От дешевых к дорогим</option>
                    <option value="#">Name (A - Z)</option>
                    <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>
                  </select>
                </div>
   </div>

                <div class="clearfix"></div>





                  <div class="form-group">
                    <br />
                    <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg sale"><?php echo $button_cart; ?></button>
                  </div>



                   <div class="info_block">
                  <div class="clearfix"></div>
                  <!--  atribute groups area s  -->
                  <?php if ($attribute_groups) { ?>
                  <div class="tab-pane atribute_group"  >
                    <table class="table">
                      <?php foreach ($attribute_groups as $ki => $attribute_group) {   ?>
                      <thead>
                      <tr>
                        <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <td>Модель</td>
                        <td><?=$model;?></td>
                      </tr>
                      <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                      <tr>
                        <td><?php echo $attribute['name']; ?></td>
                        <td><?php echo $attribute['text']; ?></td>
                      </tr>
                      <?php } ?>






                      <?php if ($manufacturer) { ?>
                      <tr>
                        <td><?php echo $text_manufacturer; ?></td>
                        <td><a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></td>
                      </tr>
                      <?php } ?>







                      </tbody>
                      <?php } ?>
                    </table>
                  </div>
                  <?php } ?>
                  <!--  atribute groups area e  -->



                  <div class="clearfix"></div>
                  <!--  description area s  -->
                  <?php echo $description; ?>
                  <!--  description groups area e  -->
                  <div class="clearfix"></div>
                   </div>

                </div>






              </section>
            </div>
            <!-- End of slider -->
            <div class="clearfix"></div>


            <div class="clearfix"></div>






          </div>  <!--     end   main_content-->
        </div>
      </div>








      <?php if ($products) { ?>
      <div class="container  text_in_line p30">
        <div class="title title--center">К этому товару подходят</div>
      </div>

      <div class="container blocknew_img ">

        <?php $ic=0; foreach ($products as $product) { ?>

        <div class="col-xs-6 col-sm-6 col-md-3">
          <figure class="figure product-thumb">
            <div class="like_me hvr-grow">
              <img class="likemeimg"  src="/image/verstka/categorynprod/likeme.png" alt="like_me" data-toggle="tooltip"  data-original-title="Нравится" data-id="<?php echo $product['product_id']; ?>">
            </div>
            <div class="quicklook hvr-grow">
              <img class="quicklookimg"  src="/image/verstka/categorynprod/quicklook.png" alt="quicklook" data-toggle="tooltip"  data-original-title="Add to Wish List" data-id="<?php echo $product['product_id']; ?>">
            </div>

            <a href="<?php echo $product['href']; ?>"> <img  src="<?php echo $product['thumb']; ?>" class="figure-img img-fluid rounded img-responsive" alt="<?php echo $product['name']; ?>"> </a>
            <figcaption class="figure-caption text-center"><?php echo $product['name']; ?></figcaption>
          </figure>
        </div>
        <?php if($ic++ == 3){  ?>
        <div class="clearfix"></div>
        <?php     }  ?>

        <?php } ?>
      </div>
      <div class="clearfix"></div>




      <?php } ?>
      <?php if ($tags) { ?>
      <p><?php echo $text_tags; ?>
        <?php for ($i = 0; $i < count($tags); $i++) { ?>
        <?php if ($i < (count($tags) - 1)) { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
        <?php } else { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
        <?php } ?>
        <?php } ?>
      </p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>







<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

				$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#cart > ul').load('index.php?route=common/cart/info ul li');

				// update  title cart
                console.log('f prod '+ json['quantity']);
                $('.cartlook').attr('title',json['quantity']);

			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').val(json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
    grecaptcha.reset();
});

$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});

$(document).ready(function() {
	var hash = window.location.hash;
	if (hash) {
		var hashpart = hash.split('#');
		var  vals = hashpart[1].split('-');
		for (i=0; i<vals.length; i++) {
			$('#product').find('select option[value="'+vals[i]+'"]').attr('selected', true).trigger('select');
			$('#product').find('input[type="radio"][value="'+vals[i]+'"]').attr('checked', true).trigger('click');
			$('#product').find('input[type="checkbox"][value="'+vals[i]+'"]').attr('checked', true).trigger('click');
		}
	}
})
//--></script>



<script type="text/javascript" src="index.php?route=product/live_options/js&p_id=<?php echo $product_id; ?>"></script>

        <div class="clearfix"></div><?=$footer; ?>
