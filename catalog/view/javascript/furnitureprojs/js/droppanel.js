


var dropanel = {
    'add': function (product_id) {
        $.ajax({
            url: '/index.php?route=extension/module/droppanel/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            beforeSend: function () {
                // $('#cart > button').button('loading');
            },
            complete: function () {
                // $('#cart > button').button('reset');
            },
            success: function (json) {

                console.log(json);
                if (json.remove==1){ // удалить есть дубль
                    $(document).on("click", ".fa-remove", function(e) {
                        $(this).parent('.figure').remove();
                        e.preventDefault();
                        console.log("okay");
                    });
                }
                // $('.alert, .text-danger').remove();
                //
                // if (json['redirect']) {
                //     location = json['redirect'];
                // }
                //
                // if (json['success']) {
                //     $('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                //
                //     // Need to set timeout otherwise it wont update the total
                //     setTimeout(function () {
                //         $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                //     }, 100);
                //
                //     $('html, body').animate({ scrollTop: 0 }, 'slow');
                //
                //     $('#cart > ul').load('index.php?route=common/cart/info ul li');
                // }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });



           // $('#ib_wrapper .figure').each(function() { $(this).sortable('destroy'); });
          //  $('#ib_wrapper .product-thumb').each(function() { $(this).draggable('destroy'); });



    }
    ,
    'del': function (product_id) {
        $.ajax({
            url: '/index.php?route=extension/module/droppanel/del',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            beforeSend: function () {
                // $('#cart > button').button('loading');
            },
            complete: function () {
                // $('#cart > button').button('reset');
            },
            success: function (json) {

                console.log(json);
                if (json.remove==1){ // удалить есть дубль
                    $(document).on("click", ".fa-remove", function(e) {
                        $(this).parent('.figure').remove();
                        e.preventDefault();
                        console.log("okay");
                    });
                }
                // $('.alert, .text-danger').remove();
                //
                // if (json['redirect']) {
                //     location = json['redirect'];
                // }
                //
                // if (json['success']) {
                //     $('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                //
                //     // Need to set timeout otherwise it wont update the total
                //     setTimeout(function () {
                //         $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                //     }, 100);
                //
                //     $('html, body').animate({ scrollTop: 0 }, 'slow');
                //
                //     $('#cart > ul').load('index.php?route=common/cart/info ul li');
                // }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}


$(function () {
    console.log('drop panel');
    $('#inspiration_bar_panel').removeClass('hidden');
});
