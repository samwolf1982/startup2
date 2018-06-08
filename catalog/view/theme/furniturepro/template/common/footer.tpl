<!-- production delete  s -->
<footer class="hidden" >
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
    </div>
    <hr>
    <p><?php echo $powered; ?></p>
  </div>
</footer>
<!-- production delete  e -->

<footer id="footer" class="footer"><!--Footer-->
  <div class="footer-bottom">
    <div class="container">
      <div class="col-xs-12 col-sm-6 col-md-3 text-center">
        <h2 class="footer-name ">EKLEKTIT STORE</h2>
        <ul class="">
          <li><a href="#"> Киев</a></li>
          <li><a href="#"><?=$address;?></a></li>
          <li><a href="tel:<?=$telephone;?>"><?=$telephone;?></a></li>
          <?php if (!empty($fax)){ ?>
          <li><a href="#"><?=$fax;?></a></li>
          <?php } ?>

          <li><a href="mailto:info@eklektikstore.com"> info@eklektikstore.com </a></li>

        </ul>
      </div>
      <div class="col-xs-12 col-sm-6  col-md-3 text-center">
        <h2 class="footer-name ">ИНФОРМАЦИЯ</h2>
        <ul>
          <li><a href="/"> Главная </a></li>
          <li><a href="/about_us"> О нас </a></li>
          <li><a href="/blog"> Блог </a></li>
          <li><a href="/about_delivery"> Условия Доставки </a></li>
          <li><a href="/about_return"> Возврат </a></li>
          <li><a href="/contact-us"> Контакты</a></li>
        </ul>
      </div>
      <div class="col-xs-6 col-sm-6  col-md-3 text-center">
        <h2 class="footer-name ">МОЙ АККАУНТ</h2>
        <ul>
          <li><a href="/login"> Вход/Регистрация</a></li>
          <li><a href="/order-history"> Мои заказы</a></li>
          <li><a href="/my-account"> Мой аккаунт</a></li>
          <li><a href="/wishlist"> Избраное</a></li>
        </ul>
      </div>
      <div class="col-xs-6 col-sm-6  col-md-3 text-center">
        <h2 class="footer-name">МЫ В СОЦСЕТЯХ</h2>
        <ul>
          <li><a target="_blank" href="https://www.facebook.com/"><i class="fa fa-facebook-square"></i>Facebook</a>&nbsp; </li>
          <li><a target="_blank" href="https://www.instagram.com/eklektik_store_kyiv"><i class="fa fa-instagram"></i>Instagram</a> </li>
          <li><a target="_blank" href="https://www.pinterest.com/"><i class="fa fa-pinterest"></i>Pinterest</a> </li>

          <li class="hidden" ><a href=""><i class="fa fa-twitter-square"></i>Twitter</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
          <li class="hidden" ><a href=""><i class="fa fa-youtube"></i>Youtube</a>&nbsp;&nbsp;   </li>
          <li class="hidden" ><a href=""><i class="fa fa-google-plus-square"></i>Google +</a>&nbsp;   </li>
          <li class="hidden" ><a href=""><i class="fa fa-linkedin-square"></i>Linkedin</a>&nbsp;&nbsp;   </li>


        </ul>

      </div>


    </div>
  </div>
  <!--    foter2-->
  <div class="footer-bottom footer-bottom1 ">
    <div class="container ">
      <div class="col-xs-6 col-sm-4  col-md-4 wrp_parther_img ">

        <a target="_blank" href="http://eklektikgroup.com.ua/"> <img src="image/verstka/logoEklektik/eklektik-group-e-logo.png" class="img-responsive2" alt="parthner"></a>

      </div>
      <div class="col-xs-6 col-sm-4  col-md-4 wrp_parther_img ">

        <a target="_blank" href="http://www.domedeco.com"> <img src="image/verstka/logoEklektik/tc7Zm3J.png" class="img-responsive2" alt="parthner"></a>

      </div>
      <div class="col-xs-12 col-sm-4  col-md-4 wrp_parther_img ">

        <a target="_blank" href="http://www.kinteriorburo.com/">  <img src="image/verstka/logoEklektik/decolush_logo-1.png" class="img-responsive2" alt="parthner"></a>

      </div>

    </div>
  </div>
</footer><!--/Footer-->
<div class="under_footer">
  <div class="container text-center">
    <section>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. At debitis earum ipsum laborum maiores officiis quas quisquam reiciendis? Explicabo magni necessitatibus nulla tempora voluptatem. Debitis ducimus illum officia pariatur quasi. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias autem consectetur corporis ducimus, earum eligendi maiores minus molestias mollitia officia omnis optio placeat possimus, praesentium, quis recusandae voluptas? Natus, rem!
      </p>
    </section>
  </div>
</div>



<div class="copyrite">
  <div class="container text-center">
    <section>
      <p>Eklektik (c) 2018</p>
    </section>
  </div>
</div>
<div class="clearfix"></div>



<!--modal area-->



<div id="ajaxcontent_dele" class="modal-dialog modal-lg cart_modal" tabindex="-1" role="dialog">

  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Корзина</h2>
      <p class="cart_empty_informer pull-left">Добавлено в корзину</p>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Custombox.modal.close();">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="col-sm-6 ">

        <ul class="cart_items">
          <li>
            <div class="cart_item">
              <img class="item_img" src="/image/verstka/cart/itemincart.png" alt="item">
              <div class="text_item">
                <h3 class="name_item">Название продукта</h3>
                <ul>
                  <li>Артикул : 4654989898</li>
                  <li>Количество: 9шт.</li>
                  <li>Цена: 900грн.</li>
                </ul>
              </div>

            </div>
          </li>
          <li>
            <div class="cart_item">
              <img class="item_img" src="/image/verstka/cart/itemincart.png" alt="item">
              <div class="text_item">
                <h3 class="name item">Название продукта</h3>
                <ul>
                  <li>Артикул : 4654989898</li>
                  <li>Количество: 9шт.</li>
                  <li>Цена: 900грн.</li>
                </ul>
              </div>

            </div>
          </li>
        </ul>

      </div>

      <div class="col-sm-6 ">
        <div class="cart_calculate">
          <p class="count_in_cart">Корзина: 5шт.</p>
          <p class="count_in_cart">Итог: 9 989грн.</p>
          <section>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad animi aperiam consequuntur doloribus ex fugiat iusto libero nemo perspiciatis quasi quidem quo rem reprehenderit, repudiandae rerum sapiente sequi totam?
          </section>
          <div class="cart_button_area">
            <a href="#" class="btn btn-primary btn-lg"          >ПРОДОЛЖИТЬ ПОКУПКУ</a>
            <a href="#" class="btn btn-primary btn-lg sale">ЗАКАЗ</a>
            <a href="#" class="btn btn-primary btn-lg sale"     > БЫСТРЫЙ ЗАКАЗ </a>
          </div>
        </div>

      </div>


      <div class="clearfix"></div>

      <div class="col-sm-12">
        <h3 class="text-center">С этим товаром покупают</h3>
        <section>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad animi aperiam consequuntur doloribus ex fugiat iusto libero nemo perspiciatis quasi quidem quo rem reprehenderit, repudiandae rerum sapiente sequi totam?
        </section>

        <div class="cart_some_product">
          <caption>
            <img class="item_img" src="/image/verstka/cart/itemincart.png" alt="item">
          </caption>
          <caption>
            <img class="item_img" src="/image/verstka/cart/itemincart.png" alt="item">
          </caption>
          <caption>
            <img class="item_img" src="/image/verstka/cart/itemincart.png" alt="item">
          </caption>
          <caption>
            <img class="item_img" src="/image/verstka/cart/itemincart.png" alt="item">
          </caption>

        </div>
      </div>

    </div>
    <div class="clearfix"></div>
    <div class="modal-footer">

    </div>
  </div>

</div>

</div>






<script src="/catalog/view/javascript/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/catalog/view/javascript/bootstrap/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
<script src="https://use.fontawesome.com/67bcd94a23.js"></script>

<!--megamenu start-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script>
    window.Modernizr || document.write('<script src="/catalog/view/javascript/libs/megamenu-js-master/megamenu-js-master/js/vendor/modernizr-2.8.3.min.js"><\/script>')
</script>
<script src="/catalog/view/javascript/libs/megamenu-js-master/megamenu-js-master/js/megamenu.js"></script>
<!--megamenu end-->
<script src="/catalog/view/javascript/furnitureprojs/js/mainpage.js"></script>

<!--custom modal-->
<script src="/catalog/view/javascript/libs/custombox-master/custombox-master/dist/custombox.min.js"></script>
<script src="/catalog/view/javascript/libs/custombox-master/custombox-master/dist/custombox.legacy.min.js"></script>

<!-- opencart script -->
<script src="/catalog/view/javascript/common.js" type="text/javascript"></script>
<script src="/catalog/view/javascript/furnitureprojs/js/likeinit.js"></script>
<script type="text/javascript" src="/catalog/view/javascript/megamenu/megamenu.js?v3"></script>





</body></html>