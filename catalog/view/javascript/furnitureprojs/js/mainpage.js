(function( $ ) {

    //Function to animate slider captions
    function doAnimations( elems ) {
        //Cache the animationend event in a variable
        var animEndEv = 'webkitAnimationEnd animationend';

        elems.each(function () {
            var $this = $(this),
                $animationType = $this.data('animation');
            $this.addClass($animationType).one(animEndEv, function () {
                $this.removeClass($animationType);
            });
        });
    }

    //Variables on page load
    var $myCarousel = $('#carousel-example-generic'),
        $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");

    //Initialize carousel
    $myCarousel.carousel();

    //Animate captions in first slide on page load
    doAnimations($firstAnimatingElems);

    //Pause carousel
    $myCarousel.carousel('pause');


    //Other slides to be animated on carousel slide event
    $myCarousel.on('slide.bs.carousel', function (e) {
        var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
        doAnimations($animatingElems);
    });
    $('#carousel-example-generic').carousel({
        interval:3000,
        pause: "false",

    });

})(jQuery);


// menu

// cart look


// quickniew cart modal
$('.cartlook').click(function(){
    // Instantiate new modal
     modal = new Custombox.modal(
        {
            content: {
                effect: 'blur',
                target: '/index.php?route=common/cart/modal',
                // target: '#ajaxcontent',
                // width: '50%',
                positionX: 'center',
                positionY: 'top',


            },
            overlay: {
                active: true,
                color: '#000',
                opacity: .48,
                close: true,
                speedIn: 300,
                speedOut: 300,

                onOpen: null,
                onComplete: null,
                onClose: null,
            },
            loader: {
                active: true,
                color: '#fff',
                speed: 1500,
            }
        }
    );

// Open
    modal.open();
    console.log('rm this');
});


function qiuck_buy_page() {
    console.log('qiuck_buy');
    Custombox.modal.close();
    // Instantiate new modal
    modal = new Custombox.modal(
        {
            content: {
                effect: 'blur',
                target: '/index.php?route=common/cart/modal_quick',
                // target: '#ajaxcontent',
                // width: '50%',
                positionX: 'center',
                positionY: 'top',


            },
            overlay: {
                active: true,
                color: '#000',
                opacity: .48,
                close: true,
                speedIn: 300,
                speedOut: 300,

                onOpen: null,
                onComplete: null,
                onClose: null,
            },
            loader: {
                active: true,
                color: '#fff',
                speed: 1500,
            }
        }
    );

// Open
    modal.open();

    return false;
}


function occmAjaxPostAdd_quick() {

    $("#occm-form-container").find("input[type=text]").removeClass("error-in-input-text");
    dataSet=$("#quick_form_buy").serialize();
    $.ajax({
        url: '/index.php?route=extension/module/occm/add',
        type: 'post',
        data: dataSet,
        dataType: 'json',
        success: function(json) {
            console.log(['oki',json]);
            var printR = function(o, printR) {
                var c = 0;
                if ('object' == typeof o) {
                    for (var i in o) {
                        c += printR(o[i], printR);
                    }
                } else if ('string' == typeof o) {
                  //  alert(o);
                    c++;
                }
                return c;
            };
            if (json['error']) {
                console.log(['error ',json]);
                if ('string' == typeof json["error"]) {
                    if ("undefined" != typeof json["addErrorClass"] && json["addErrorClass"].length) {
                        for (var i in json["addErrorClass"]) {
                            $("#occm-form-container").find(json["addErrorClass"][i]).addClass("error-in-input-text");
                        }
                    }
                    alert(json['error']);
                } else if ("object" == typeof json['error']) {
                    if (printR(json['error'], printR)) {
                        $.colorbox.close();
                    } else {
                        alert("Unexpected error, please, contact administrator <?php echo $z->c('config_email') ?>");
                    }
                } else {
                    alert("Unexpected error, please, contact administrator <?php echo $z->c('config_email') ?>");
                }
            } else if (json['success']) {
               // alert(json['success']);
                //$.colorbox.close();
                show_thanks();
            } else {
              //   alert("Unexpected error, please, contact administrator <?php echo $z->c('config_email') ?>");
            console.log('empty maybe')
            }
        }
    });

    return false;
}



function show_thanks() {
    console.log('thanks');
    $('.cartlook').attr('title','0');
    Custombox.modal.close();
    // Instantiate new modal
    modal = new Custombox.modal(
        {
            content: {
                effect: 'blur',
                target: '/index.php?route=common/cart/thanks',
                // target: '#ajaxcontent',
                // width: '50%',
                positionX: 'center',
                positionY: 'top',


            },
            overlay: {
                active: true,
                color: '#000',
                opacity: .48,
                close: true,
                speedIn: 300,
                speedOut: 300,

                onOpen: null,
                onComplete: null,
                onClose: null,
            },
            loader: {
                active: true,
                color: '#fff',
                speed: 1500,
            }
        }
    );

// Open

    modal.open();

    return false;
}
