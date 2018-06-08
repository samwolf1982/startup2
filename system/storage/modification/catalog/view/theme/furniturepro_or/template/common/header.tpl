<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title;  ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $og_url; ?>" />
<?php if ($og_image) { ?>
<meta property="og:image" content="<?php echo $og_image; ?>" />
<?php } else { ?>
<meta property="og:image" content="<?php echo $logo; ?>" />
<?php } ?>
<meta property="og:site_name" content="<?php echo $name; ?>" />


  <!--  s del -->

  <!-- e  del -->
  <style>


      /*overflow-x: scroll;*/
    /*overflow-y: auto;*/
      html{ overflow-y: scroll; overflow-x: auto; }
    body{
      margin-left: 0!important;
      margin-right: 0!important;

    }
      body{
        padding-right: 0 !important;
      }

  </style>

  <script src="//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
  <link href="/catalog/view/theme/furniturepro/stylesheet/css/fontsulpoad.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="/catalog/view/javascript/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/catalog/view/javascript/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">
  <link href="/catalog/view/javascript/libs/megamenu-js-master/megamenu-js-master/css/stylemega.css" rel="stylesheet">
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="/catalog/view/javascript/bootstrap/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">



  <!-- Custom styles for this template -->
  <link href="/catalog/view/theme/furniturepro/stylesheet/css/main.css" rel="stylesheet">
  <link href="/catalog/view/theme/furniturepro/stylesheet/css/modalcart.css" rel="stylesheet">

  <link href="/catalog/view/javascript/libs/Hover-master/Hover-master/css/hover-min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="/catalog/view/javascript/libs/custombox-master/custombox-master/dist/custombox.min.css">

  <link rel="stylesheet" href="/catalog/view/theme/default/stylesheet/megamenu.css?v3">


  <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
  <!--[if lt IE 9]><script src="catalog/view/javascript/bootstrap/docs/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <link href="css/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css2" rel="stylesheet">
  <![endif]-->


<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>


  <script src="/catalog/view/javascript/bootstrap/docs/assets/js/ie-emulation-modes-warning.js"></script>
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <script>window.jQuery || document.write('<script src="catalog/view/javascript/bootstrap/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>



<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>

			<script src="catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js" type="text/javascript"></script>
			<script src="catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
			<script src="catalog/view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
			<script src="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
			<link href="catalog/view/javascript/jquery/magnific/magnific-popup.css" rel="stylesheet">
			<link href="catalog/view/javascript/jquery/owl-carousel/owl.carousel.css" type="text/css" rel="stylesheet" media="screen">
			<link href="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen">
			<link href="catalog/view/theme/default/stylesheet/quickview.css" rel="stylesheet">
			<script type="text/javascript">
			var color_schem = '1';
			var loading_masked_img = '<img src="catalog/view/theme/default/image/ring-alt-'+ color_schem +'.svg" />';
			function loading_masked(action) {
				if (action) {
					$('.loading_masked').html(loading_masked_img);
					$('.loading_masked').show();
				} else {
					$('.loading_masked').html('');
					$('.loading_masked').hide();
				}
			}
			function creatOverlayLoadPage(action) {
				if (action) {
					$('#messageLoadPage').html(loading_masked_img);
					$('#messageLoadPage').show();
				} else {
					$('#messageLoadPage').html('');
					$('#messageLoadPage').hide();
				}
			}
			function quickview_open(id) {
			$('body').prepend('<div id="messageLoadPage"></div><div class="mfp-bg-quickview"></div>');
				$.ajax({
					type:'post',
					data:'quickviewpost=1',
					url:'index.php?route=product/product&product_id='+id,	
					beforeSend: function() {
						creatOverlayLoadPage(true); 
					},
					complete: function() {
						$('.mfp-bg-quickview').hide();
						$('#messageLoadPage').hide();
						creatOverlayLoadPage(false); 
					},	
					success:function (data) {
						$('.mfp-bg-quickview').hide();
						$data = $(data);
						var new_data = $data.find('#quickview-container').html();							
						$.magnificPopup.open({
							tLoading: loading_masked_img,
							items: {
								src: new_data,
							},
							type: 'inline'
						});
					}
			});							
			}
			</script>
			
</head>
<body class="<?php echo $class; ?>">
<!-- production delete  s -->
<div class="wrp_content">
<?php if(0){ ?>
<nav id="top" class="hidden">
  <div class="container">
    <?php echo $currency; ?>
    <?php echo $language; ?>
    <div id="top-links" class="nav pull-right">
      <ul class="list-inline">
        <li><a href="<?php echo $contact; ?>"><i class="fa fa-phone"></i></a> <span class="hidden-xs hidden-sm hidden-md"><?php echo $telephone; ?></span></li>
        <li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span> <span class="caret"></span></a>
          <ul class="dropdown-menu dropdown-menu-right">
            <?php if ($logged) { ?>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
            <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
            <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
            <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wishlist; ?></span></a></li>
        <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_shopping_cart; ?></span></a></li>
        <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><i class="fa fa-share"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_checkout; ?></span></a></li>
      </ul>
    </div>
  </div>
</nav>
<header>
  <div class="container hidden">
    <div class="row">
      <div class="col-sm-4">
        <div id="logo">
          <?php if ($logo) { ?>
            <?php if ($home == $og_url) { ?>
              <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" />
            <?php } else { ?>
              <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
            <?php } ?>
          <?php } else { ?>
            <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
          <?php } ?>
        </div>
      </div>
      <div class="col-sm-5"><?php echo $search; ?>
      </div>
      <div class="col-sm-3"><?php echo $cart; ?></div>
    </div>
  </div>
</header>
<?php }?>
<!-- production delete e -->


<!--naw bar top-->
<nav class="navbar  navbar-fixed-top ">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation MOBILE</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="pull-right mobile-nav hidden-lg hidden-md">
        <ul class=" nav navbar-nav navbar-right" >
          <li><a class="location"  href="<?=$show_room_href;?>">Шоуm рум</a></li>
          <li ><a class="like"  href="<?=$wishlist;?>">Понравилось</a></li>
          <li><a class="user"  href="<?=$account;?>">Кабинет</a></li>
        </ul>
      </div>
    </div>




    <div class="col-md-8 collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">

         <?php    foreach ($top_links as $tp) {   ?>
        <li class="active"><a href="<?=$tp['href']?>"   <?= isset($tp['blank'])?'target="_blank"':''; ?>      ><?=$tp['name']?></a></li>
       <?php   }  ?>



      </ul>
    </div>
    <div class="col-md-4 pull-right">
      <ul class=" nav navbar-nav navbar-right hidden-sm hidden-xs">
        <li ><a class="location"  href="<?=$show_room_href;?>">Шоу рум</a></li>
        <li id="like"><a class="like"  href="<?=$wishlist;?>">Понравилось</a></li>
        <li><a class="user"  href="<?=$account;?>">Кабинет</a></li>
      </ul>
    </div>
    <div class="clearfix"></div>



    <!--/.nav-collapse -->





  </div>
</nav>
<div class="clearfix"></div>

<!--search -->
<div class="container search">
  <div class="col-md-6 wrp_logo">
    <a href="/"> <img src="image/verstka/logo.png" alt="logo"> </a>
  </div>
  <div class="col-md-6">


    <div class="wrp_search_cart">



        <div id="search" class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
        <button class="btn btn-default" type="button">&nbsp;&nbsp;&nbsp;</button>
      </span>
      </div><!-- /input-group -->
      <div  class="cart cartlook" title="<?=$count_in_cart;?>" >
        <img class="cart_image" src="image/verstka/cart.png" alt="cart">
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>


<!--naw bar bottom-->
<!--mega menu-->





  <?   // взято из мегаменю
			if($use_megamenu) {  ?>
<div class="navbar navbar_bottom">

  <div class="container nav-container">
  <nav id="megamenu-menu" class="navbar">
  <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $menu_title; ?></span>
  <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
  </div>
  <div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav">
  <?php foreach ($items as $item) {   ?>
  <?php if ($item['children']) { ?>
  <li class="dropdown  <?=$curent_cat_id?> <?= isset($item['cat_id'])?$item['cat_id']:'';?>"   >

  <a href="<?php echo $item['href']; ?>" <?php if($item['use_target_blank'] == 1) { echo ' target="_blank" ';} ?> <?php if($item['type'] == "link") {echo 'data-target="link"';} else {echo 'class="dropdown-toggle dropdown-img" data-toggle="dropdown"';} ?>><?if($item['thumb']){ ?>
    <img class="megamenu-thumb" src="<?=$item['thumb']?>"/>
    <?}?><?php echo $item['name']; ?></a>

  <?if($item['type']=="category"){ ?>
  <?if($item['subtype']=="simple"){ ?>
  <div class="dropdown-menu megamenu-type-category-simple">
  <div class="dropdown-inner">
  <?php foreach (array_chunk($item['children'], ceil(count($item['children']) / 1)) as $children) { ?>


  <ul class="list-unstyled megamenu-haschild">
  <?php foreach ($children as $child) { ?>
  <li class="<?if(count($child['children'])){ ?> megamenu-issubchild<?}?>"><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>

  <?if(count($child['children'])){ ?>
  <ul class="list-unstyled megamenu-ischild megamenu-ischild-simple">
  <?php foreach ($child['children'] as $subchild) { ?>
  <li><a href="<?php echo $subchild['href']; ?>"><?php echo $subchild['name']; ?></a></li>
  <?}?>
  </ul>
  <?}?>
  </li>
  <?php } ?>
  </ul>



  <?php } ?>
</div>
</div>
<?}?>
<?}?>

<?if($item['type']=="category"){ ?>
<?if($item['subtype']=="full"){ ?>
<div class="dropdown-menu megamenu-type-category-full megamenu-bigblock">
<div class="dropdown-inner">
<?php foreach (array_chunk($item['children'], ceil(count($item['children']) / 1)) as $children) { ?>

<?if($item['add_html']){ ?>
<div style="" class="menu-add-html">
<?=$item['add_html'];?>
</div>
<?}?>

<ul class="list-unstyled megamenu-haschild">
<?php foreach ($children as $child) { ?>
<li class="megamenu-parent-block<?if(count($child['children'])){ ?> megamenu-issubchild<?}?>"><a class="megamenu-parent-title" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>

				<?if(count($child['children'])){ ?>
<ul class="list-unstyled megamenu-ischild">
<?php foreach ($child['children'] as $subchild) { ?>
<li><a href="<?php echo $subchild['href']; ?>"><?php echo $subchild['name']; ?></a></li>
<?}?>
				</ul>
				<?}?>
				</li>
                <?php } ?>
				</ul>
              <?php } ?>
            </div>
			</div>
			<?}?>
			<?}?>

			<?if($item['type']=="category"){ ?>
<?if($item['subtype']=="full_image"){ ?>
<div class="dropdown-menu megamenu-type-category-full-image megamenu-bigblock">
<div class="dropdown-inner">
<?php foreach (array_chunk($item['children'], ceil(count($item['children']) / 1)) as $children) { ?>

<?if($item['add_html']){ ?>
<div style="" class="menu-add-html">
<?=$item['add_html'];?>
</div>
<?}?>

<ul class="list-unstyled megamenu-haschild">
<?php foreach ($children as $child) { ?>
<li class="megamenu-parent-block<?if(count($child['children'])){ ?> megamenu-issubchild<?}?>">
				<a class="megamenu-parent-img" href="<?php echo $child['href']; ?>"><img src="<?php echo $child['thumb']; ?>" alt="" title=""/></a>
				<a class="megamenu-parent-title" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>

				<?if(count($child['children'])){ ?>
<ul class="list-unstyled megamenu-ischild">
<?php foreach ($child['children'] as $subchild) { ?>
<li><a href="<?php echo $subchild['href']; ?>"><?php echo $subchild['name']; ?></a></li>
<?}?>
				</ul>
				<?}?>
				</li>
                <?php } ?>
				</ul>
              <?php } ?>
            </div>
			</div>
			<?}?>
			<?}?>


			<?if($item['type']=="html"){ ?>

<div class="dropdown-menu megamenu-type-html">
<div class="dropdown-inner">




<ul class="list-unstyled megamenu-haschild">

<li class="megamenu-parent-block<?if(count($child['children'])){ ?> megamenu-issubchild<?}?>">
<div class="megamenu-html-block">
<?=$item['html']?>
</div>
</li>
</ul>

</div>
</div>

<?}?>




		<?if($item['type']=="manufacturer"){ ?>

<div class="dropdown-menu megamenu-type-manufacturer <?if($item['add_html']){ ?>megamenu-bigblock<?}?>">
<div class="dropdown-inner">
<?php foreach (array_chunk($item['children'], ceil(count($item['children']) / 1)) as $children) { ?>

<?if($item['add_html']){ ?>
<div style="" class="menu-add-html">
<?=$item['add_html'];?>
</div>
<?}?>

<ul class="list-unstyled megamenu-haschild <?if($item['add_html']){ ?>megamenu-blockwithimage<?}?>">
                <?php foreach ($children as $child) { ?>
                <li class="megamenu-parent-block">
				<a class="megamenu-parent-img" href="<?php echo $child['href']; ?>"><img src="<?php echo $child['thumb']; ?>" alt="" title="" /></a>
				<a class="megamenu-parent-title" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>


				</li>
                <?php } ?>
				</ul>
              <?php } ?>
            </div>
			</div>

			<?}?>

				<?if($item['type']=="information"){ ?>

<div class="dropdown-menu megamenu-type-information <?if($item['add_html']){ ?>megamenu-bigblock<?}?>">
<div class="dropdown-inner">
<?php foreach (array_chunk($item['children'], ceil(count($item['children']) / 1)) as $children) { ?>

<?if($item['add_html']){ ?>
<div style="" class="menu-add-html">
<?=$item['add_html'];?>
</div>
<?}?>

<ul class="list-unstyled megamenu-haschild <?if($item['add_html']){ ?>megamenu-blockwithimage<?}?>">
                <?php foreach ($children as $child) { ?>
                <li class=""><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>


				</li>
                <?php } ?>
				</ul>
              <?php } ?>
            </div>
			</div>

			<?}?>



				<?if($item['type']=="product"){ ?>

<div class="dropdown-menu megamenu-type-product <?if($item['add_html']){ ?>megamenu-bigblock<?}?>">
<div class="dropdown-inner">
<?php foreach (array_chunk($item['children'], ceil(count($item['children']) / 1)) as $children) { ?>

<?if($item['add_html']){ ?>
<div style="" class="menu-add-html">
<?=$item['add_html'];?>
</div>
<?}?>

<ul class="list-unstyled megamenu-haschild <?if($item['add_html']){ ?>megamenu-blockwithimage<?}?>">
                <?php foreach ($children as $child) { ?>
                <li class="megamenu-parent-block">
				<a class="megamenu-parent-img" href="<?php echo $child['href']; ?>"><img src="<?php echo $child['thumb']; ?>" alt="" title="" /></a>
				<a class="megamenu-parent-title" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
				<div class="dropprice">
				<?if($child['special']){ ?><span><?}?><?php echo $child['price']; ?><?if($child['special']){ ?></span><?}?><?php echo $child['special']; ?>
				</div>
				</li>
                <?php } ?>
				</ul>
              <?php } ?>
            </div>
			</div>

			<?}?>
					<?if($item['type']=="auth"){ ?>

<div class="dropdown-menu megamenu-type-auth">
<div class="dropdown-inner">
<ul class="list-unstyled megamenu-haschild">
<li class="megamenu-parent-block<?if(count($child['children'])){ ?> megamenu-issubchild<?}?>">
<div class="megamenu-html-block">

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
<div class="form-group">
<label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
<input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
</div>
<div class="form-group">
<label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
<input type="password" name="password" value="" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
<a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></div>

<input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary" />

</form>


</div>
</li>
</ul>

</div>
</div>

<?}?>

        </li>



        <?php } else { ?>
        <li><a href="<?php echo $item['href']; ?>"><?php echo $item['name']; ?></a></li>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </nav>
</div>
<?}?>
</div>
<?php if ($categories && !$use_megamenu) { ?>

<?php } ?>

<div class="clearfix"></div>


