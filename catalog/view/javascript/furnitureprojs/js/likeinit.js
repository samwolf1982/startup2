// Remove EDIT  THIS !!!!!!


$(document).ready(function(){
    $("body").on('click','.likemeimg',function () {
        // fly to cart n// add to wishlist fron ocart
        var cart = $('#like');
        var imgtodrag = $(this).parent().parent().find("img").eq(0);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                    top: imgtodrag.offset().top,
                    left: imgtodrag.offset().left
                })
                .css({
                    'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '1000000'
                })
                .appendTo($('body'))
                .animate({
                    'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
                }, 1000, 'swing');

            // setTimeout(function () {
            //     cart.effect("shake", {
            //         times: 2
            //     }, 200);
            // }, 1500);

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach()
            });
        }


        // add to like
        $id_prod=$(this).data('id');
        wishlist.add($id_prod);


// $id_prod=$(this).data('id');
        console.log(['rm this',$id_prod]);
    });
});
$('.likemeimg2').click(function(){
    // fly to cart n// add to wishlist fron ocart
    var cart = $('#like');
    var imgtodrag = $(this).parent().parent().find("img").eq(0);
    if (imgtodrag) {
        var imgclone = imgtodrag.clone()
            .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
            .css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 75,
                'height': 75
            }, 1000, 'swing');

        // setTimeout(function () {
        //     cart.effect("shake", {
        //         times: 2
        //     }, 200);
        // }, 1500);

        imgclone.animate({
            'width': 0,
            'height': 0
        }, function () {
            $(this).detach()
        });
    }


    // add to like
    $id_prod=$(this).data('id');
   wishlist.add($id_prod);


// $id_prod=$(this).data('id');
    console.log(['rm this',$id_prod]);
});


$('.fullmeimg').click(function(){
    // fly to cart n// add to wishlist fron ocart
    $('#xzoom-fancy').click();
    console.log('rm this full me');
});

$('.zoomzoomimg').click(function(){
    // fly to cart n// add to wishlist fron ocart


    if(zoomActive){
        var styleTag = $('<style>.xzoom-lens,.loadzooming , .xzoom-preview{ display: none!important;}</style>')
        $('html > head').append(styleTag);
        zoomActive=false;
    }else{
        var styleTag = $('<style>.xzoom-lens, .loadzooming ,.xzoom-preview{ display: initial!important;}</style>')
        $('html > head').append(styleTag);
        zoomActive=true;
    }
    console.log('inst '+zoomActive);

});