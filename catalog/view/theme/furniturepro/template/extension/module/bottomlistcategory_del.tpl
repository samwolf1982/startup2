<!-- Start Bottomlistcategory module -->

<!--category-block-->
<div class="container-fluid category-block">
  <div class="container">
    <?php foreach ($ready_category_list as $k ){   ?>
    <div class="simple_category">
      <a href="<?=$k['url'];?>"><?=$k['text'];?></a>
    </div>
    <?php }  ?>

  </div>

</div>

<div class="clearfix"></div>


<!-- End Bottomlistcategory module -->