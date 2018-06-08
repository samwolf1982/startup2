<div id="quickview-container">
<div id="popup-quickview">
	<div class="popup-center">








	<div class="tab-content">
		<div class=" active" id="tab-general">
				<div class="col-md-6 col-sm-12">
			<div class="product-img-box thumbnails_view">
<?php if($on_off_quickview_additional_image =='1'){?>
<script>
 $(function(){
 $(".product-img-box.thumbnails_view").each(function (indx, el){
  var image = $(".img", el),
  next = $(el).parent();
  var oldsrc;
  $(".hover", next).hover(function (){
   var newsrc = $(this).attr("rel");
   image.attr({src: newsrc});
  });
  $(".thumbnails_view").hover(function (){oldsrc = image.attr('src');},
  function(){
   image.attr({src: oldsrc}); 
  })
 });
});	
$('.gallery-image').owlCarousel({						
	items : 3,
	navigation: true,
	navigationText: ['<div class="btn-carousel featured-btn-next next-prod"><i class="fa fa-angle-left arrow"></i></div>', '<div class="btn-carousel featured-btn-prev prev-prod"><i class="fa fa-angle-right arrow"></i></div>'],
	pagination: false
}); 
</script>
<?php } ?>
			<div class="thumbnails-image product-thumb">
    <div class="like_me hvr-grow">
    <img class="likemeimg" src="/image/verstka/categorynprod/likeme.png" alt="like_me" data-toggle="tooltip" data-original-title="Нравится" data-id="41">
    </div>
					<img class="img img-responsive" src="<?php echo $popup;?>" alt="<?php echo $heading_title;?>" />
				</div>
			<?php if($on_off_quickview_additional_image =='1'){?>
				<div class="gallery-image owl-carousel text-center">
					<?php if ($images) { ?>					
						<?php foreach ($images as $image) { ?>
						<span class="item">
								<img style="cursor:pointer;" class="hover" src="<?php echo $image['thumb']; ?>" rel="<?php echo $image['popup'];?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
						</span>
						<?php } ?>				
					<?php } ?>
				</div>	
			<?php } ?>	
			</div>			
		</div>
			<div class="col-md-6 col-sm-12">
				<div class="product-name-quick"><?php echo $heading_title;?></div>
				<hr>
				<?php if($on_off_quickview_tab_review_quickview =='1') { ?>	
				<?php if ($review_status) { ?>
					  <div class="rating">
						<p>
						  <?php for ($i = 1; $i <= 5; $i++) { ?>
						  <?php if ($rating < $i) { ?>
						  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
						  <?php } else { ?>
						  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
						  <?php } ?>
						  <?php } ?>
						  <a href="" onclick="$('a[href=\'#tab-review-quickview\']').trigger('click'); return false;"><?php echo $reviews; ?></a> / <a href="" onclick="$('a[href=\'#tab-review-quickview\']').trigger('click'); return false;"><?php echo $text_write; ?></a></p>
					  </div>
					  <?php } ?>
				<hr>
				<?php } ?>
					<?php if ($price) { ?>
					  <ul class="list-unstyled">
						<?php if (!$special) { ?>
						<li>
						  <span class="price"><?php echo $price; ?></span>
						</li>
						<?php } else { ?>
						<li><li><span class="price-old" style="text-decoration: line-through;"><?php echo $price; ?></span>&nbsp;&nbsp;<span class="price-new"><?php echo $special; ?></span></li></li>
						<?php } ?>
						<?php if ($tax) { ?>
						<li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
						<?php } ?>
						<?php if ($points) { ?>
						<li><?php echo $text_points; ?> <?php echo $points; ?></li>
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
				<hr>

<?php echo $description; ?>
<hr>

<?php if($on_off_quickview_tab_specification =='1') { ?>
<?php if ($attribute_groups) { ?>
    <div class="tab-pane" id="tab-specification">
            <table class="table table-bordered">
        <?php foreach ($attribute_groups as $attribute_group) { ?>
        <thead>
            <tr>
            <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
            <tr>
                <td><?php echo $attribute['name']; ?></td>
                <td><?php echo $attribute['text']; ?></td>
                </tr>
                <?php } ?>
        </tbody>
            <?php } ?>
    </table>
        </div>
        <?php } ?>
<?php } ?>
<hr>




			<?php if($on_off_quickview_manufacturer =='1'){?>	
				<div class="quick-manufacturer"><span><i class="fa fa-check fa-fw"></i><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></div>
			<?php } ?>
			<?php if($on_off_quickview_model =='1'){?>	
				<div class="quick-model"><span><i class="fa fa-check fa-fw"></i><?php echo $text_model; ?></span> <span><?php echo $model; ?></span> </div>
			<?php } ?>
			<?php if($on_off_quickview_quantity =='1'){?>	
				<?php if($quantity_prod <=0) { ?>				
					<div class="quick-stock"><span><i class="fa fa-check fa-fw"></i><?php echo $text_stock; ?></span> <span class="qty-not-in-stock"><?php echo $stock; ?></span></div>
				<?php } else { ?>
					<div class="quick-stock"><span><i class="fa fa-check fa-fw"></i><?php echo $text_stock; ?></span> <span class="qty-in-stock"><?php echo $stock; ?></span></div>
				<?php } ?>
			<?php } ?>
			<?php if( ($on_off_quickview_quantity =='1') || ($on_off_quickview_model =='1') || ($on_off_quickview_quantity =='1')) { ?>
				<hr>
			<?php } ?>
<?php if ($options) { ?>
<?php $coun_options = count($options);?>
	<?php if($coun_options > $on_off_quickview_options_count){ ?>
	<div class="options-expand panel panel-default">
        <a href="javascript:void(0);" onclick="$('.options').toggleClass('hidden-options');$('.options-expand a .caret').toggleClass('rotate');" title="<?php echo $text_option; ?>"><?php echo $text_option; ?> <span class="caret"></span></a>
    </div>
	<?php } else { ?>
	<div class="options-close panel panel-default">
        <a href="javascript:void(0);" onclick="$('.options').toggleClass('hidden-options');$('.options-expand a .caret').toggleClass('rotate');" title="<?php echo $text_option; ?>"><?php echo $text_option; ?> <span class="caret"></span></a>
    </div>
	<?php } ?>
      <div class="options <?php if($coun_options > $on_off_quickview_options_count) { ?>hidden-options<?php } ?>">
        <br />
            <?php foreach ($options as $option) { ?>
            <?php if ($option['type'] == 'select') { ?>
            <div class="form-group">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
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
            <?php if ($option['type'] == 'radio') { ?>
            <div class="form-group">
				<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio-checbox-options">
                  <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="<?php echo $option['product_option_id']; ?>_<?php echo $option_value['product_option_value_id']; ?>" />
									<label for="<?php echo $option['product_option_id']; ?>_<?php echo $option_value['product_option_value_id']; ?>">
                    <span class="option-name"><?php echo $option_value['name']; ?></span>
                    <?php if ($option_value['price']) { ?>
                    <span class="option-price"><?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?></span>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'checkbox') { ?>
            <div class="form-group">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio-checbox-options">
                  <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="<?php echo $option['product_option_id']; ?>_<?php echo $option_value['product_option_value_id']; ?>" />
									<label for="<?php echo $option['product_option_id']; ?>_<?php echo $option_value['product_option_value_id']; ?>">
                    <span class="option-name"><?php echo $option_value['name']; ?></span>
                    <?php if ($option_value['price']) { ?>
                    <span class="option-price"><?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?></span>
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'image') { ?>
				<?php if ($option['status_color_type'] =='1') { ?>
				<div class="form-group">
				 <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
							<?php if ($option['required']) { ?>
								<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
							<?php } ?>
						<?php echo $option['name']; ?>
					</label>
				  <div id="input-option<?php echo $option['product_option_id']; ?>">
					<?php foreach ($option['product_option_value'] as $option_value) { ?>
					<div class="image-radio">
					  <label>
						<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
						<span class="color-option" data-toggle="tooltip" title="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" style="background-color:<?php echo $option_value['color']?>"></span> 
					  </label>
					</div>
					<?php } ?>
				  </div>
				</div>
				<?php } else { ?>
				<div class="form-group">
				 <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
							<?php if ($option['required']) { ?>
								<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
							<?php } ?>
						<?php echo $option['name']; ?>
					</label>
				  <div id="input-option<?php echo $option['product_option_id']; ?>">
					<?php foreach ($option['product_option_value'] as $option_value) { ?>
					<div class="image-radio">
					  <label>
						<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
						<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" data-toggle="tooltip" title="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /> 
					  </label>
					</div>
					<?php } ?>
				  </div>
				</div>
				<?php } ?>
            <?php } ?>
            <?php if ($option['type'] == 'text') { ?>
            <div class="form-group">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'textarea') { ?>
            <div class="form-group">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'file') { ?>
            <div class="form-group">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'date') { ?>
            <div class="form-group">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <div class="input-group date">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'datetime') { ?>
            <div class="form-group">
				<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <div class="input-group datetime">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'time') { ?>
            <div class="form-group">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>">
						<?php if ($option['required']) { ?>
							<i class="fa fa-exclamation-triangle required" data-toggle="tooltip" data-placement="left" title="<?php echo $required_text_option; ?>"></i>
						<?php } ?>
					<?php echo $option['name']; ?>
				</label>
              <div class="input-group time">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
			
            <?php } ?>
				</div>
            <?php } ?>
			<?php if ($minimum > 1) { ?>
			<hr>
            <div class="quantity-minimum"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
            <?php } ?>
			<?php if($options){?><hr><?php } ?>
			<div class="btn-group-product">
			<?php if($on_off_quickview_addtocart=='1'){?>
			<div class="qty pull-left">
					<div class="quantity-adder clearfix">
						<div>
							<div class="quantity-number pull-left">
								<input class="quantity-product form-control" type="text" name="quantity" size="5" value="<?php echo $minimum; ?>" id="input-quantity" />
							</div>
							<div class="quantity-wrapper pull-left">
							<span onclick="btnplus_card_prod();" class="add-up add-action fa fa-plus"></span>
							<span onclick="btnminus_card_prod(<?php echo $minimum; ?>);" class="add-down add-action fa fa-minus"></span>
							</div>
						</div>
						<input type="hidden" name="product_id"  value="<?php echo $product_id; ?>" />
					</div>
			</div>
			<script type="text/javascript">
				function btnminus_card_prod(a){
					document.getElementById("input-quantity").value>a?document.getElementById("input-quantity").value--:document.getElementById("input-quantity").value=a
				}
				function btnplus_card_prod(){
					document.getElementById("input-quantity").value++
				};

			</script>
			<?php } ?>
			<style>
				.btn-add-to-cart-quickview {
					background:<?php echo $config_quickview_background_btnaddtocart;?>;
					color:<?php echo $config_quickview_textcolor_btnaddtocart;?>;
					border:1px solid <?php echo $config_quickview_background_btnaddtocart;?>;
				}
				.btn-add-to-cart-quickview:hover {
					background:<?php echo $config_quickview_background_btnaddtocart_hover;?>;
					color:<?php echo $config_quickview_textcolor_btnaddtocart_hover;?>;
					border:1px solid <?php echo $config_quickview_background_btnaddtocart_hover;?>;
				}
				.btn-wishlist-quickview {
					background:<?php echo $config_quickview_background_btnwishlist;?>;
					color:<?php echo $config_quickview_textcolor_btnwishlist;?>;
					border:1px solid <?php echo $config_quickview_background_btnwishlist;?>;
				}
				.btn-wishlist-quickview:hover {
					background:<?php echo $config_quickview_background_btnwishlist_hover;?>;
					color:<?php echo $config_quickview_textcolor_btnwishlist_hover;?>;
					border:1px solid <?php echo $config_quickview_background_btnwishlist_hover;?>;
				}
				.btn-compare-quickview {
					background:<?php echo $config_quickview_background_btncompare;?>;
					color:<?php echo $config_quickview_textcolor_btncompare;?>;
					border:1px solid <?php echo $config_quickview_background_btncompare;?>;
				}
				.btn-compare-quickview:hover {
					background:<?php echo $config_quickview_background_btncompare_hover;?>;
					color:<?php echo $config_quickview_textcolor_btncompare_hover;?>;
					border:1px solid <?php echo $config_quickview_background_btncompare_hover;?>;
				}
			</style>
			<?php if($on_off_quickview_addtocart=='1'){?>
				<?php if (($product_quantity <= 0) and $disable_cart_button){ ?>
					<button type="button" id="button-cart-quickview" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg sale" disabled><?php if($change_text_cart_button_out_of_stock ==1) { ?><span><?php echo $disable_cart_button_text; ?></span><?php } else { ?><i class="fa fa-shopping-basket"></i> <span><?php echo $button_cart; ?></span><?php } ?></button></button>
				<?php } else {?>
					<button type="button" id="button-cart-quickview" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg sale"><?php if($change_text_cart_button_out_of_stock ==1 && $product_quantity <= 0) { ?><span><?php echo $disable_cart_button_text; ?></span><?php } else { ?><i class="fa fa-shopping-basket"></i> <span><?php echo $button_cart; ?></span><?php } ?></button>
				<?php } ?>
			<?php } ?>
			<div class="btn-group">
			<?php if($on_off_quickview_wishlist=='1'){?>
				<button type="button" data-toggle="tooltip" class="btn btn-wishlist-quickview" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i></button>
			<?php } ?>
			<?php if($on_off_quickview_compare=='1'){?>
				<button type="button" data-toggle="tooltip" class="btn btn-compare-quickview" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-exchange"></i></button>
			<?php } ?>
			</div>
			</div>
<hr/>
<div class="wrp_go">
    <a href="<?=$share;?>">   <button type="button" data-toggle="tooltip" class="btn btn-primary btn-lg sale" title="Подробней " >Подробней</button></a>

</div>


    </div>


		</div>
		<?php if($on_off_quickview_tab_description =='1') { ?>
			<div class="tab-pane" id="tab-description">
				<?php echo $description; ?>
			</div>
		<?php } ?>	
		<?php if($on_off_quickview_tab_specification =='1') { ?>
		<?php if ($attribute_groups) { ?>
            <div class="tab-pane" id="tab-specification">
              <table class="table table-bordered">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                <thead>
                  <tr>
                    <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                  <tr>
                    <td><?php echo $attribute['name']; ?></td>
                    <td><?php echo $attribute['text']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <?php } ?>
              </table>
            </div>
            <?php } ?>
		<?php } ?>


		<?php if($on_off_quickview_tab_review_quickview =='1') { ?>	
		<?php if ($review_status) { ?>
            <div class="tab-pane" id="tab-review-quickview">
              <form class="form-horizontal" id="form-review-quickview">
                <div id="review-quickview"></div>
                <h2><?php echo $text_write; ?></h2>
                <?php if ($review_guest) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="" id="input-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                    <div class="help-block"><?php echo $text_note; ?></div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label"><?php echo $entry_rating; ?></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
               <?php if (isset($site_key)) { ?>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                    </div>
                  </div>
                <?php } ?>
                <div class="buttons clearfix">
                  <div class="pull-right">
                    <button type="button" id="button-review-quickview" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_review; ?></button>
                  </div>
                </div>
                <?php } else { ?>
                <?php echo $text_login; ?>
                <?php } ?>
              </form>
            </div>
            <?php } ?>
            <?php } ?>
	</div>
	</div>
<script type="text/javascript"><!--
$('#button-cart-quickview').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#popup-quickview input[type=\'text\'], #popup-quickview input[type=\'hidden\'], #popup-quickview input[type=\'radio\']:checked, #popup-quickview input[type=\'checkbox\']:checked, #popup-quickview select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart-quickview').button('loading');
		},
		complete: function() {
			$('#button-cart-quickview').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));
						$('.options').removeClass('hidden-options');
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
	
					html  = '<div id="modal-addcart" class="modal" style="z-index:99999999">';
					html += '  <div class="modal-dialog" style="overflow:hidden">';
					html += '    <div class="modal-content">';
					html += '      	<div class="modal-body"><div class="text-center">' + json['success'] + '<br><br></div><div class="text-center"><button data-dismiss="modal" class="btn btn-default">Продожить покупки</button>&nbsp;&nbsp;<a href="/index.php?route=checkout/onepagecheckout" class="btn btn-primary">Оформить заказ</a></div></div>';
					html += '    </div>';
					html += '  </div>';
					html += '</div>';
					
					$('body').append(html);

					$('#modal-addcart').modal('show');
				
					setTimeout(function () {
						$('.cart-total').html(json['total']);
					}, 100);	
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
                $('.cartlook').attr('title',json['quantity']);

			}
				$('#modal-addcart').on('hide.bs.modal', function (e) {
					$('#modal-addcart').remove();
				});
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
<script type="text/javascript"><!--
$('#review-quickview').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review-quickview').fadeOut('slow');

    $('#review-quickview').load(this.href);

    $('#review-quickview').fadeIn('slow');
});

$('#review-quickview').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review-quickview').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review-quickview").serialize(),
		beforeSend: function() {
			$('#button-review-quickview').button('loading');
		},
		complete: function() {
			$('#button-review-quickview').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review-quickview').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review-quickview').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#popup-quickview .date').datetimepicker({
	pickTime: false
});

$('#popup-quickview .datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('#popup-quickview .time').datetimepicker({
	pickDate: false
});

$('#popup-quickview button[id^=\'button-upload\']').on('click', function() {
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

						$(node).parent().find('input').attr('value', json['code']);
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
</div>
</div>	  
</div>	  
	 