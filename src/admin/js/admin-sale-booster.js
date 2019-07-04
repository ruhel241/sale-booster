(function($) {
    var alter_cart_button = $( "#_sale_booster_alter_cart_button" ).val();
    if('inquire_us' === alter_cart_button){
        $("._sale_booster_inquire").css('display', 'block'); 
    } 

    $( "#_sale_booster_alter_cart_button" ).change(function(e) {
    var value = e.target.value;
        if(value === 'inquire_us'){
            $("._sale_booster_inquire").css('display', 'block'); 
        } else {
            $("._sale_booster_inquire").css('display', 'none');
        }
    });

})( jQuery );
