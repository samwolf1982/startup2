


<!--блок с соцсети-->
<div class="container  text_in_line p30">
    <div class="title title--center">INSTAGRAM</div>
</div>
<div class="clearfix"></div>


<div id="instagram">
    <style>
        .insta-img{
            max-width: 100%;
            margin-bottom: 30px;
        }
        #instagram{
            margin-bottom: 30px;
        }
    </style>
    <?php if(!empty($title)) { ?>
        <h3 class="instagram-title">
            <?php echo $title; ?>
        </h3>
    <?php } ?>
    <?php if($is_error){ ?>
        <h4><?php echo $error; ?><h4>
    <?php } else { ?>
            <div class="container blocknew_img  blocknew_img_social"  id="more-photo">
            <?php foreach ($images as $image){
                echo '<div class="col-xs-6 col-sm-6 col-md-3">';
                echo '<figure class="figure"><a href="'.$image['original'].'" class="ista-popup ">';
                echo '<img src="'.$image['thumbnail'].'" class="insta-img figure-img img-fluid rounded img-responsive"/>';
                echo '</a><figure class="figure">';
                echo '</div>';
            } ?>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
    <div class="text-center mt">
        <a class="btn btn-primary insta-more-btn btn-lg" data-from="<?php echo $limit; ?>"><?php echo $text_load; ?></a>
    </div>
</div>
<div class="clearfix"></div>
<script type="text/javascript"><!--
$('.insta-more-btn').on('click', function(){
    var from = parseInt($(this).data('from'));
    $.ajax({
        url: 'index.php?route=extension/module/instagram/loadmore',
        data: 'from='+from,
        success: function(data){
            $('#more-photo').html(data);
            $('.insta-more-btn').data('from',from + <?php echo $limit; ?>);
        }
    });
});
$(document).ready(function() {
    $('#instagram').magnificPopup({
        type:'image',
        delegate: 'a.ista-popup',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
        },
    });
});
//--></script>