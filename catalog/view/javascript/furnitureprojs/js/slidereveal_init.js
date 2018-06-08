$(function($) {

    var slider = $("#inspiration_bar_panel").slideReveal({
        trigger: $("#gwt-ib-tab"),
        overlay: false,
        position: "right",
        push: false,
        top: 150,
        width: 500
    });

    $( "#ib_wrapper" ).sortable({
        revert: true,
        receive: function (event, ui) {   //$(newItem).attr('data-id')
            var pasteItem = checkList("ib_wrapper", $(this).data().uiSortable.currentItem);
            console.log('res '+pasteItem )
            if (pasteItem){
                $(this).data().uiSortable.currentItem.remove();
            }
        }
    });
    // $( "#draggable" ).draggable({
    //     connectToSortable: "#sortable",
    //     helper: "clone",
    //     revert: "invalid"
    // });

    $( ".figure.product-thumb" ).draggable({
        connectToSortable: "#ib_wrapper",
        helper: "clone",
        revert: "invalid",
        start: function() {
  // console.log('start dr');
        },
        drag: function() {
            console.log('dr dr');
        },
        stop: function(event, ui) {

//             var divs = $( "#ib_wrapper" ).get();
//
// // Add 3 elements of class dup too (they are divs)
//             divs = divs.concat( $( ".dup" ).get() );
//             $( "div:eq(1)" ).text( "Pre-unique there are " + divs.length + " elements." );
//
//             divs = jQuery.unique( divs );
            // $( "div:eq(2)" ).text( "Post-unique there are " + divs.length + " elements." )
            //     .css( "color", "red" );


            p_id=$(ui.helper[0]).attr("data-id");
             console.log($(ui.helper[0]).attr("data-id"));
            dropanel.add( p_id);

        },

    });



    $(document).on("click", ".fa-remove", function(e) {

      p_id=  $(this).parent('.figure').attr('data-id');
        $(this).parent('.figure').remove();

        dropanel.del( p_id);
        e.preventDefault();
        console.log("okay");
    });




});


function checkList(listName, newItem){
    var dupl = false;
    $cc=0;
    $("#" + listName + " > .figure").each(function(index, value) {

        console.log([$(value).attr('data-id'),newItem.attr('data-id') ]);

        if (  $(this).attr('data-id')  ==  newItem.attr('data-id') ){
           // dupl = true;
            $cc++;
            console.log('is delete')
        }
    });

    if ($cc==2){ //повторилось 2 раза ок удаляем
        dupl = true;
    }
    return dupl;
}