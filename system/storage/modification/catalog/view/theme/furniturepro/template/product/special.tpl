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




      <div class="clearfix"></div>

      <!--filter area-->

      <div class="col-sm-12  wrp_filter_area filter_area_right ">
 <div class="pull-right">
   <select id="input-sort"  onchange="location = this.value;">
     <?php foreach ($sorts as $sorts_) { ?>
     <?php if ($sorts_['value'] == $sort . '-' . $order) { ?>
     <option value="<?php echo $sorts_['href']; ?>" selected="selected"><?php echo $sorts_['text']; ?></option>
     <?php } else { ?>
     <option value="<?php echo $sorts_['href']; ?>"><?php echo $sorts_['text']; ?></option>
     <?php } ?>
     <?php } ?>
   </select>

 </div>



      </div>
      <div class="clearfix"></div>


      <?php if ($products) { ?>

      <!--  category content          -->
      <div class="row category_content">

        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="product-thumb">
            <div class="image">
	
				<?php if($config_on_off_special_page_quickview =='1'){?>
					<div class="quickview"><a class="btn btn-quickview" onclick="quickview_open(<?php echo $product['product_id']?>);"><i class="fa fa-external-link fa-fw"></i><?php echo $config_quickview_btn_name[$lang_id]['config_quickview_btn_name']; ?></a></div>
				<?php } ?>
			

              <div class="like_me hvr-grow">
                <img class="likemeimg"  src="/image/verstka/categorynprod/likeme.png" alt="like_me" data-toggle="tooltip"  data-original-title="Нравится" data-id="<?php echo $product['product_id']; ?>">
              </div>
              <div class="quicklook hvr-grow">
                <img class="quicklookimg"  onclick="quickview_open(<?php echo $product['product_id'];?>);"  src="/image/verstka/categorynprod/quicklook.png" alt="quicklook" data-toggle="tooltip"  data-original-title="Посмотреть" data-id="<?php echo $product['product_id']; ?>">
              </div>


              <a href="<?php echo $product['href']; ?>"><img class="img-responsive" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
            </div>
            <div>
              <div class="caption">
                <p><?php echo $product['name']; ?></p>

                <?php if ($product['price']) { ?>
                <p class="price">
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









      <div class="row pag_flex">
        <div class="col-sm-6 text-left"><?php echo $results; ?></div>
        <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>

      </div>
      <?php } ?>
      <?php if ( !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>


    </div>
    <?php echo $column_right; ?></div>
</div>

<?php echo $content_bottom; ?>






<?php echo $footer; ?>