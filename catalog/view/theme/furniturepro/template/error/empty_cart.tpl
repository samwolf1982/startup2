<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <style>
    .wrp{
      padding-top: 20px;
      display: flex;
      justify-content: center;
    }
    .error_link{
      text-decoration: underline!important;
      font-size: 32px;
    }
  </style>

  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>

      <div class="row">
        <div class="col-sm-12 text-center">
          <h2>Корзина покупок пуста</h2>


          <div class="wrp">
          <img style="max-height: 360px;" src="/image/empty-cart-bear.png" alt="not found" class="img-responsive">
          </div>
        </div>
      </div>


      <p class="text-center">

      </p>
      <br>
      <div class="text-center">
        <a href="<?php echo $continue; ?>" class="error_link">НА ГЛАВНУЮ</a>
      </div>
      </div>
    <?php echo $column_right; ?></div>
  <br><br>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>
