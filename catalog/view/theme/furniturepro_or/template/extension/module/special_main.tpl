<!--блок с картинками-->


<style>
  .small_images a{
    padding: 1em;
  }
  .small_images {
    padding-top: 1em;
  }

</style>


<?php   if(count($products)){ ?>
<div class="container  text_in_line p30">
  <div class="title title--center"><?=$name_center;?></div>
</div>
<div class="clearfix"></div>
<div class="container  images_area">
  <div class="largeimg col-xs-12 col-sm-12 col-md-12 col-lg-6 text-center">
    <a href="<?=$products[0]['href'];?>"> <img class="img-responsive" src="<?=$products[0]['image'];?>" alt="large img"> </a>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
    <div class="small_images">
      <?php    $cnt=0;              foreach ($products  as $product) { if( ++$cnt==1){ continue;}   ?>
      <a href="<?=$product['href'];?>"><img class="img-responsive" src="<?=$product['thumb'];?>" alt="<?=$product['name'].'_'.$cnt;?>"></a>
             <?php  if($cnt >4){
                    break; } } ?>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="text-center wrp_all_actions_button">
    <a href="<?=$special_url;?>" class="btn btn-primary btn-lg sale"> все акции </a>
  </div>
</div>
<div class="clearfix"></div>
<?php }else{   ?>
      <h3>Извините на сегодня акционных товаров уже нету.</h3>
<?php }  ?>
<div class="clearfix"></div>