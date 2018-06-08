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
      <?php if ($thumb || $description) { ?>
      <div class="row">
        <?php if ($thumb) { ?>
        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="col-sm-10"><?php echo $description; ?></div>
        <?php } ?>
      </div>
      <hr>
      <?php } ?>

<div class="col-sm-12  category_wraper_up ">
    <?php if ($categories) { ?>
    <div class="row">


                <?php foreach ($categories as $category) { ?>
        <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12 category_wraper text-center">
                <a href="<?php echo $category['href']; ?>">
                    <img src="<?php echo $category['img']; ?>" class="img-responsive" alt="<?php echo $category['name']; ?>">
                    <span class="cat_name"> <?php echo $category['name']; ?></span>
                </a>
            
            
        </div>
                <?php } ?>


    </div>
    <?php } ?>
</div>

<div class="clearfix"></div>
        <br><br>
<?php if(0){ ?>
        <div class="col-sm-12 wrp_filter_area">
            <div class="row">
        <div class="bf-attr-filter bf-attr-<?php echo $groupUID; ?> bf-row me_attr_ch">
            <div class="bf-cell">
                <select name="<?php echo "bfp_{$groupUID}"; ?>">

                <?php foreach ($group['values'] as $value) : ?>
                <?php $isSelected = isset($selected[$groupUID]) && in_array($value['id'], $selected[$groupUID]); ?>
                <option value="<?php echo $value['id']; ?>" class="bf-attr-val" <?php if ($isSelected) : ?>selected="true"<?php endif; ?>
                <?php if(!isset($totals[$groupUID][$value['id']]) && !$isSelected): ?>
                disabled="disabled"
                <?php endif; ?>
                <?php if (isset($totals[$groupUID][$value['id']]) && !$isSelected) : ?>
                data-totals="<?php echo (isset($totals[$groupUID][$value['id']]) ? $totals[$groupUID][$value['id']] : 0); ?>"
                <?php endif; ?>>
                <?php echo $value['name']; ?>
                </option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>

            </div>
        </div>
<?php } ?>
        <style>
            .bf-horizontal.bf-sliding-cont{
overflow: visible!important;
            }
        </style>



        <br><br>
      <!--filter area  123-->
      <div class="col-sm-6 wrp_filter_area">
        <div class="row">



        </div>

      </div>
      <div class="col-sm-6 wrp_filter_area filter_area_right ">
       <div class="row">

           <div class="col-xs-12  col-sm-12 col-md-6 filter_area ">

               
       </div>


           <div class="col-xs-12  col-sm-12 col-md-6 filter_area ">

               <p class="text-left"><?php echo $text_sort; ?></p>

               <select id="input-sort"  onchange="location = this.value;">
                   <?php
                     $ex_list=[1,2,5,6];
                    foreach ($sorts as $kk => $sorts_ ) {  if(in_array($kk,$ex_list) ) { continue; }
                   if($kk==7) { $sorts_['text']='По популярности (убыванию)'; }
                   if($kk==8) { $sorts_['text']='По популярности (возрастанию)'; }
                   ?>
                   <?php if ($sorts_['value'] == $sort . '-' . $order) { ?>
                   <option value="<?php echo $sorts_['href']; ?>" selected="selected"><?php echo $sorts_['text']; ?></option>
                   <?php } else { ?>
                   <option value="<?php echo $sorts_['href']; ?>"><?php echo $sorts_['text']; ?></option>
                   <?php } ?>
                   <?php } ?>
               </select>
           </div>



       </div>

      </div>
      <div class="clearfix"></div>


      <?php if ($products) { ?>

        <!--  category content           -->
        <div class="row category_content">

            <?php foreach ($products as $product) { ?>
            <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="figure product-thumb ui-draggable ui-draggable-handle project-hover ui-sortable-handle"  data-id="<?php echo $product['product_id'];?>" >
                    <i class="fa fa-remove" ></i>
                    <div class="image">
	
				<?php if($config_on_off_category_page_quickview =='1'){?>
					<div class="quickview"><a class="btn btn-quickview" onclick="quickview_open(<?php echo $product['product_id']?>);"><i class="fa fa-external-link fa-fw"></i><?php echo $config_quickview_btn_name[$lang_id]['config_quickview_btn_name']; ?></a></div>
				<?php } ?>
			





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









      <div class="row pag_flex">
          <div class="col-sm-5 text-left"><?php echo $results; ?></div>
        <div class="col-sm-7 text-right"><?php echo $pagination; ?></div>

      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary btn-lg"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>


    </div>
    <?php echo $column_right; ?></div>
</div>

<?php echo $content_bottom; ?>
<?php echo $footer; ?>
