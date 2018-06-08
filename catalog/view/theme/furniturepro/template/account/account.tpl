<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <h2> Здравствуйте <?php echo $user_name; ?></h2>
      <?php echo $content_top; ?>

      <style>
        .info{
          font-size: 16px;
        }
      </style>

      <div class="col-sm-12 col-md-6">
              <div class="wrp text-center">
                <a href="/address-book">
                  <img src="/image/catalog/account/account_1.jpg" alt="go here">
                  <p style="info"> Aдресса доставки</p>
                </a>
              </div>
      </div>

      <div class="col-sm-12 col-md-6">
        <div class="wrp text-center">
          <a href="/wishlist">
            <img src="/image/catalog/account/account_2.jpg" alt="go here">
            <p style="info">Мои закладки</p>
          </a>
        </div>
      </div>

      <div class="col-sm-12 col-md-6">
        <div class="wrp text-center">
          <a href="/edit-account/">
            <img src="/image/catalog/account/account_3.jpg" alt="go here">
            <p style="info">Учетная запись</p>
          </a>
        </div>
      </div>

      <div class="col-sm-12 col-md-6">
        <div class="wrp text-center">
          <a href="/change-password/">
            <img src="/image/catalog/account/account_4.jpg" alt="go here">
            <p style="info">Смена пароля</p>
          </a>
        </div>
      </div>

      <div class="col-sm-12 col-md-6">
        <div class="wrp text-center">
          <a href="<?php echo $newsletter; ?>">
            <img src="/image/catalog/account/account_5.jpg" alt="go here">
            <p style="info"><?php echo $text_my_newsletter; ?></p>
          </a>
        </div>
      </div>





      <ul class="list-unstyled hidden" hidden>
        <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
        <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
        <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
        <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      </ul>
      <?php if ($credit_cards) { ?>
      <h2><?php echo $text_credit_card; ?></h2>
      <ul class="list-unstyled">
        <?php foreach ($credit_cards as $credit_card) { ?>
        <li><a href="<?php echo $credit_card['href']; ?>"><?php echo $credit_card['name']; ?></a></li>
        <?php } ?>
      </ul>
      <?php } ?>
      <h2 class="" ><?php echo $text_my_orders; ?></h2>
      <ul class="list-unstyled" >
        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
        <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
        <?php if ($reward) { ?>
        <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
        <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
        <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
      </ul>


    <?php echo $column_right; ?></div>
    <?php echo $content_bottom; ?></div>
</div>
<?php echo $footer; ?> 