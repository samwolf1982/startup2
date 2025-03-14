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

      <style>
        .card-title{
          font-size: 20px;
        }
      </style>

      <div class="">
        <div class="">
          <div class="row">
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
                <img class="card-img-top img-responsive" src="/image/catalog/frominsta/frominsta/(1)22710650_132618774061590_6361290055109050368_n.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title text-center">Наш адрес</h5>
                  <p>
                    <strong><?php echo $store; ?></strong><br />
                  <address>
                    <?php echo $address; ?>
                  </address>
                  </p>

                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
                <img class="card-img-top img-responsive" src="image/catalog/frominsta/frominsta/(1)22860558_966623276809558_7970780344355913728_n.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title text-center">Контакты</h5>
                  <p class="card-text">

                    <a href="tel:<?php echo $telephone; ?>"> <i class="fa fa-phone-square" aria-hidden="true"></i>  <?php echo $telephone; ?></a><br />
                    <br />
                    <?php if ($fax) { ?>
                    <a href="tel:<?php echo $fax; ?>"> <i class="fa fa-phone-square" aria-hidden="true"></i>    <?php echo $fax; ?></a>
                    <?php } ?>

                  </p>

                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
                <img class="card-img-top img-responsive" src="image/catalog/frominsta/frominsta/22710445_148599649217994_2822302475686510592_n.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title text-center">Время работы</h5>
                  <p class="card-text">
                    <?php if ($open) { ?>
                    <strong><?php echo $text_open; ?></strong><br />
                    <?php echo $open; ?><br />
                    <br />
                    <?php } ?>
                    <?php if ($comment) { ?>
                    <strong><?php echo $text_comment; ?></strong><br />
                    <?php echo $comment; ?>
                    <?php } ?>

                  </p>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php if ($locations) { ?>
      <h3><?php echo $text_store; ?></h3>
      <div class="panel-group" id="accordion">
        <?php foreach ($locations as $location) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><a href="#collapse-location<?php echo $location['location_id']; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $location['name']; ?> <i class="fa fa-caret-down"></i></a></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-location<?php echo $location['location_id']; ?>">
            <div class="panel-body">
              <div class="row">
                <?php if ($location['image']) { ?>
                <div class="col-sm-3"><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
                <?php } ?>
                <div class="col-sm-3"><strong><?php echo $location['name']; ?></strong><br />
                  <address>
                  <?php echo $location['address']; ?>
                  </address>
                  <?php if ($location['geocode']) { ?>
                  <a href="https://maps.google.com/maps?q=<?php echo urlencode($location['geocode']); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                  <?php } ?>
                </div>
                <div class="col-sm-3"> <strong><?php echo $text_telephone; ?></strong><br>
                  <?php echo $location['telephone']; ?><br />
                  <br />
                  <?php if ($location['fax']) { ?>
                  <strong><?php echo $text_fax; ?></strong><br>
                  <?php echo $location['fax']; ?>
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                  <?php if ($location['open']) { ?>
                  <strong><?php echo $text_open; ?></strong><br />
                  <?php echo $location['open']; ?><br />
                  <br />
                  <?php } ?>
                  <?php if ($location['comment']) { ?>
                  <strong><?php echo $text_comment; ?></strong><br />
                  <?php echo $location['comment']; ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend><?php echo $text_contact; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
            <div class="col-sm-10">
              <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <div class="text-danger"><?php echo $error_enquiry; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php echo $captcha; ?>
        </fieldset>
        <div class="buttons">
          <div class="pull-right">
            <input class="btn btn-primary bth-lg" type="submit" value="<?php echo $button_submit; ?>" />
          </div>
        </div>
      </form>
      </div>
    <?php echo $column_right; ?></div>


  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>
