<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <?php if ($products) { ?>

<div class="row">
      <?php foreach ($products as $product) { ?>

  <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="product-thumb">

      <div class="image">

        <div class="like_me hvr-grow">
          <img class="likemeimg"  src="/image/verstka/categorynprod/liked.png" alt="like_me" data-toggle="tooltip"  data-original-title="Нравится" data-id="<?php echo $product['product_id']; ?>">
        </div>
        <div class="quicklook hvr-grow">
          <img class="quicklookimg"  onclick="quickview_open(<?php echo $product['product_id'];?>);"  src="/image/verstka/categorynprod/quicklook.png" alt="quicklook" data-toggle="tooltip"  data-original-title="Посмотреть" data-id="<?php echo $product['product_id']; ?>">
        </div>


        <a href="<?php echo $product['href']; ?>"><img class="img-responsive" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
        <a href="<?php echo $product['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-times"></i></a>
      </div>
      <div>
        <div class="caption">
          <p><?php echo $product['name']; ?></p>



        </div>

      </div>
    </div>
  </div>







      <?php } ?>


</div>



      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="/" class="btn btn-primary btn-lg"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>

  </div>
</div>
<?php echo $footer; ?>