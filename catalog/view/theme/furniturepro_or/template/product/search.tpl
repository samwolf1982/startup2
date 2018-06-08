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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
      <div class="row">
        <div class="col-sm-4 categotyselectinput">
          <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
        </div>
        <div class="col-sm-3  categotyselect">
          <select name="category_id" class="form-control">
            <option value="0"><?php echo $text_category; ?></option>
            <?php foreach ($categories as $category_1) { ?>
            <?php if ($category_1['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_1['children'] as $category_2) { break; ?>
            <?php if ($category_2['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_2['children'] as $category_3) { break; ?>
            <?php if ($category_3['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-3">

        </div>
      </div>
      <p>
        <label class="checkbox-inline">
          <?php if ($description) { ?>
          <input type="checkbox" name="description" value="1" id="description" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="description" value="1" id="description" />
          <?php } ?>
          <?php echo $entry_description; ?></label>


        <label class="checkbox-inline hidden">
        <label class="checkbox-inline hidden">
          <?php if ($sub_category) { ?>
          <input type="checkbox" name="sub_category" value="1" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="sub_category" value="1" />
          <?php } ?>
          <?php echo $text_sub_category; ?></label>
      </p>
      <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary btn btn-primary btn-lg" />
      <h2><?php echo $text_search; ?></h2>
      <?php if ($products) { ?>



      <!--filter area-->
      <div class="col-sm-6 wrp_filter_area " style="opacity: 0;">
        <div class="row">

          <p>Фильтр</p>
          <div class="col-xs-6  col-sm-6 filter_area">
            <select id="input-sort"  onchange="location = this.value;">
              <option value="#" selected="selected">Цена</option>
              <option value="#">Name (A - Z)</option>
              <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>
            </select>
          </div>
          <div class="col-xs-6 col-sm-6 filter_area ">
            <select id="input-sort"  onchange="location = this.value;">
              <option value="#" selected="selected">Стиль</option>
              <option value="#">Name (A - Z)</option>
              <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>     <option value="#">Name (A - Z)</option>
            </select>

          </div>
        </div>

      </div>
      <div class="col-sm-6 wrp_filter_area filter_area_right ">




        <p class="text-right"><?php echo $text_sort; ?></p>

        <select id="input-sort" class="pull-right"  onchange="location = this.value;">
          <?php foreach ($sorts as $sorts_) { ?>
          <?php if ($sorts_['value'] == $sort . '-' . $order) { ?>
          <option value="<?php echo $sorts_['href']; ?>" selected="selected"><?php echo $sorts_['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $sorts_['href']; ?>"><?php echo $sorts_['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>

      </div>
      <div class="clearfix"></div>



      <div class="row category_content">
        <?php foreach ($products as $product) { ?>

        <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="figure product-thumb ui-draggable ui-draggable-handle project-hover ui-sortable-handle"  data-id="<?php echo $product['product_id'];?>" >
            <i class="fa fa-remove" ></i>
            <div class="image">





              <div class="like_me hvr-grow">
                <img class="likemeimg"  src="/image/verstka/categorynprod/likeme.png" alt="like_me" data-toggle="tooltip"  data-original-title="Нравится" data-id="<?php echo $product['product_id']; ?>">
              </div>
              <div class="quicklook hvr-grow">
                <img class="quicklookimg"  onclick="quickview_open(<?php echo $product['product_id'];?>);"  src="/image/verstka/categorynprod/quicklook.png" alt="quicklook" data-toggle="tooltip"  data-original-title="Посмотреть" data-id="<?php echo $product['product_id']; ?>">
              </div>

              <?php if ($product['price']) { ?>
              <p class="price drop_price hidden_drop">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                <?php } ?>

                <?php if ($product['tax']) { ?>
                <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                <?php } ?>

              </p>
              <?php } ?>



              <a href="<?php echo $product['href']; ?>"><img class="img-responsive" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>


              <div class="btn-view transition text-center">
                <a  onclick="cart.add('<?php echo $product['product_id']; ?>');"  class="btn btn-default">В корзину</a>
              </div>

              <figcaption class="figure-caption text-center"><?php echo $product['name']; ?></figcaption>
              <div class="caption figure-caption ">
                <?php if ($product['price']) { ?>
                <p class="price drop_price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>

                  <?php if ($product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                  <?php } ?>

                </p>
                <?php } ?>

              </div>

            </div>




          </div>
        </div>


        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script>
<?php echo $footer; ?>