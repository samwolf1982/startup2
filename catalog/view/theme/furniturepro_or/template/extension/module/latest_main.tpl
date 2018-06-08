<!--блок с новинки-->
<div class="container  text_in_line p30">
  <div class="title title--center">Новинки</div>
</div>

<div class="container blocknew_img ">

  <?php $ic=0; foreach ($products as $product) { ?>

  <div class="col-xs-6 col-sm-6 col-md-3">
    <figure class="figure product-thumb ui-draggable ui-draggable-handle project-hover ui-sortable-handle" data-id="<?php echo $product['product_id'];?>">

      <i class="fa fa-remove" ></i>
      <div class="like_me hvr-grow">
        <img class="likemeimg"  src="/image/verstka/categorynprod/likeme.png"  alt="like_me" data-toggle="tooltip"  data-original-title="Нравится" data-id="<?php echo $product['product_id']; ?>">
      </div>
      <div class="quicklook hvr-grow">
        <img class="quicklookimg"  src="/image/verstka/categorynprod/quicklook.png" onclick="quickview_open(<?php echo $product['product_id'];?>);" alt="quicklook" data-toggle="tooltip"  data-original-title="Посмотреть" data-id="<?php echo $product['product_id']; ?>">
      </div>

      <?php if ($product['price']) { ?>
      <span class="price drop_price">
        <?php if (!$product['special']) { ?>
        <?php echo $product['price']; ?>
        <?php } else { ?>
        <span class="price-new"><?php echo $product['special']; ?></span> <br> <span class="price-old"><?php echo $product['price']; ?></span>
        <?php } ?>
        <?php if ($product['tax']) { ?>
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
        <?php } ?>
      </span>
      <?php } ?>





      <a href="<?php echo $product['href']; ?>"> <img  src="<?php echo $product['thumb']; ?>" class="figure-img img-fluid rounded img-responsive" alt="<?php echo $product['name']; ?>"> </a>

      <div class="btn-view transition text-center">
        <a  onclick="cart.add('<?php echo $product['product_id']; ?>');"  class="btn btn-default">В корзину</a>
      </div>

      <figcaption class="figure-caption text-center"><?php echo $product['name']; ?></figcaption>
    </figure>
  </div>
  <?php if($ic++ == 3){  ?>
  <div class="clearfix"></div>
  <?php     }  ?>

  <?php } ?>
</div>
<div class="clearfix"></div>









