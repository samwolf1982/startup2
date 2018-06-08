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
          <div class="wrp">
          <img src="/image/catalog/404.png" alt="not found" class="img-responsive">
          </div>
        </div>
      </div>

      <h1 class="text-center"><?php echo $heading_title; ?></h1>




      <p class="text-center">
        Страница не найдена, неправильно набран адрес или такой страницы на сайте больше не существует
        Перейдите на главную страницу или выберите
        подходящую категорию
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
