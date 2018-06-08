<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-bottomlistcategory" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-cogs"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
		<p>Модуль категорий под слайдером</p>





        <!-- hiiden for ancestor  -->
        <table class="hidden">
          <?=$ancestor ?>
        </table>


		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bottomlistcategory" class="form-horizontal">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status">Состояние</label>
            <div class="col-sm-10">
              <select name="bottomlistcategory_status" id="bottomlistcategory_status" class="form-control">
                <?php if ($bottomlistcategory_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>


          <div class="form-group">
            <div class="tab-pane" id="tab-recurring">

              <!-- test zone s -->

              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <td class="text-left">Категория</td>
                    <td class="text-left">Название(не обязательно)</td>
                    <td class="text-left">Сортировка</td>
                    <td class="text-left"></td>
                  </tr>
                  </thead>
                  <tbody class="tbody" id="table1">

                  <?=$ancestor_data1;?>


                  </tbody>
                  <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    <td class="text-left"><button type="button" data-ancestorid="jek"  data-toggle="tooltip" title="добавить" class="btn btn-primary clone_ancestor"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                  </tfoot>
                </table>
              </div>

              <!-- test zone e -->

            </div>
          </div>



        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript"><!--


    $( ".clone_ancestor" ).on( "click", function() {
        console.log( $( this ).data('ancestorid') );
        var $clone = $('#'+$( this ).data('ancestorid')).clone();
        $clone.removeAttr('id');
        $(this).parent().parent().parent().parent().append($clone);
    });

    //--></script>



<?php echo $footer; ?>