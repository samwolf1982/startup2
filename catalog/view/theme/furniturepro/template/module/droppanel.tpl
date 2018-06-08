

<div class="wrp_ hidden" hidden>
    <div id="slider_drop">Hello World!!111</div>

    <button id="trigger_drop">Hello World!!__sasa</button>
</div>



<div id="inspiration_bar_panel" class="hidden">

        <div id="gwt-ib-tab" class="tab_ib_big tab_ib_close">

            <img class="drop_label" src="/image/verstka/heap/idea-board-pin.png" alt="drop_me">

            <div class="gwt-HTML inspiration-bar inspiration-bar-title">Перетащите элементы чтобы создать Панель Идей</div>
            <br>
            <div class="view"></div>

            <div class="gwt-success-addition-plus-indicator" id="gwt-plus-indicator" style="visibility: hidden;"></div>

        </div>
    <h4 class="text-center">Добро пожаловать на Доску ваших Идей </h4>

        <hr>

        <div class="clearfix"></div>



        <div id="ib_wrapper" class="ui-wrapper">


            <div class="project-hover hidden">
                <img src="http://placehold.it/360x360" class="img-responsive transition">
                <div class="text-view transition text-center">
                    <h3>More Information On</h3>
                    <p>Improved Glass Conservatory Roofs</p>
                </div>
                <div class="btn-view transition text-center">
                    <a type="submit" class="btn btn-default">Submit</a>
                </div>
            </div>


            <!-- drop zone start -->
            <?php $ic=0; foreach ($products as $product) { ?>


                <figure class="figure product-thumb ui-draggable ui-draggable-handle project-hover ui-sortable-handle" data-id="<?php echo $product['product_id'];?>">

                    <i class="fa fa-remove" ></i>
                    <div class="like_me hvr-grow">
                        <img class="likemeimg"  src="/image/verstka/categorynprod/likeme.png"  alt="like_me" data-toggle="tooltip"  data-original-title="Нравится" data-id="<?php echo $product['product_id']; ?>">
                    </div>
                    <div class="quicklook hvr-grow">
                        <img class="quicklookimg"  src="/image/verstka/categorynprod/quicklook.png" onclick="quickview_open(<?php echo $product['product_id'];?>);" alt="quicklook" data-toggle="tooltip"  data-original-title="Посмотреть" data-id="<?php echo $product['product_id']; ?>">
                    </div>

                    <?php if ($product['price']) { ?>
                    <span class="price drop_price">
        <?php if (!$product['special']) { ?>
                        <?php echo $product['price']; ?>
                        <?php } else { ?>
                        <span class="price-new"><?php echo $product['special']; ?></span> <br> <span class="price-old"><?php echo $product['price']; ?></span>
                        <?php } ?>
                        <?php if ($product['tax']) { ?>
                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                        <?php } ?>
      </span>
                    <?php } ?>





                    <a href="<?php echo $product['href']; ?>"> <img  src="<?php echo $product['thumb']; ?>" class="figure-img img-fluid rounded img-responsive" alt="<?php echo $product['name']; ?>"> </a>

                    <div class="btn-view transition text-center">
                        <a  onclick="cart.add('<?php echo $product['product_id']; ?>');"  class="btn btn-default">В корзину</a>
                    </div>

                    <figcaption class="figure-caption text-center"><?php echo $product['name']; ?></figcaption>
                </figure>


            <?php } ?>









            <!-- drop zone end -->
            </div>

</div>

