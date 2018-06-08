<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($attention) { ?>
  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?>
        <?php if ($weight) { ?>
        &nbsp;(<?php echo $weight; ?>)
        <?php } ?>
      </h1>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="table-responsive maintable">
          <table class="table">
            <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-left" style="width: 220px;"><?php if ($product['thumb']) { ?>

                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>

                <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i class="fa fa-times-circle"></i></button>

                <?php } ?></td>
              <td class="info_td">
                <h2> <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
                <?php if (!$product['stock']) { ?>
                <p class="text-danger">***</p>
                <?php } ?>
                <?php if ($product['option']) { ?>
                <?php foreach ($product['option'] as $option) { ?>

                <p><?php echo $option['name']; ?>: <?php echo $option['value']; ?></p>
                <?php } ?>
                <?php } ?>
                <?php if ($product['reward']) { ?>

                <p><?php echo $product['reward']; ?></p>
                <?php } ?>
                <?php if ($product['recurring']) { ?>

                <p class="label label-info"><?php echo $text_recurring_item; ?></p> <small><?php echo $product['recurring']; ?></small>
                <?php } ?>

               <p> Артикул:   <?php echo $product['model']; ?></p>
              </td>
             <td class="text-right total_price">
               <div class="input-group btn-block hidden">
                              <span class="quantity"> <?php echo $product['quantity']; ?>
                 </span> <span class="delimiter"> x</span>
               </div>

               <div class="input-group btn-block" style="max-width: 200px; min-width: 75px; padding-top: 2em;">
                 <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />
                 <span class="input-group-btn">
                    <button type="submit" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
                    </span>
               </div>

             </td>

              <td class="text-right total_price">
                <div class="input-group btn-block">

                  <span class="price_cart"><?php echo $product['price']; ?> </span>
                  <span class="hidden"> <?php echo $product['total']; ?></span>


                </div>
              </td>


            </tr>
            <?php } ?>


            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><?php echo $voucher['description']; ?></td>
              <td class="text-left"><div class="input-group btn-block">
                  <input type="text" name="" value="1" size="1" disabled="disabled" class="form-control" />
                  <span class="input-group-btn">
                    <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="voucher.remove('<?php echo $voucher['key']; ?>');"><i class="fa fa-times-circle"></i></button>
                    </span></div></td>
              <td></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>

            </tr>
            <?php } ?>


              <?php     $c=count($totals);       foreach ($totals as $k => $total) { $cl_b='clear_border'; $pr_cart='';  if($k ==($c-1) ){$cl_b=''; $pr_cart='price_cart';}  ?>
            <tr class="">
              <td class="text-left <?=$cl_b;?>"><strong><?php echo $total['title']; ?>:</strong></td>
              <td class="<?=$cl_b;?>"></td>
              <td class="<?=$cl_b;?>"></td>
              <td class="text-right <?=$cl_b;?>  <?=$pr_cart;?>  "><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>


            </tbody>
          </table>
        </div>
      </form>


      <div class="buttons clearfix">
        <div class="pull-left"><a href="<?php echo $continue; ?>" class="btn btn-primary btn-lg"><?php echo $button_shopping; ?></a></div>
        <div class="pull-right"><a href="<?php echo $checkout; ?>" class="btn btn-primary btn-lg sale"><?php echo $button_checkout; ?></a></div>
      </div>




      <?php if (  0  ) {  ?>
      <?php if (  $modules  ) {  ?>
      <h2><?php echo $text_next; ?></h2>
      <p><?php echo $text_next_choice; ?></p>
      <div class="panel-group" id="accordion">
        <?php foreach ($modules as $module) { ?>
        <?php echo $module; ?>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>

      <br>


      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
