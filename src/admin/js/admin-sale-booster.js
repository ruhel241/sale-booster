(function($) {
    // discount Timer
    var discountTimerVars = sale_booster_discount_timer_vars.discount_timer;
    if(discountTimerVars === 'yes'){
        $("#_sale_booster_discounttimer_showhide").show();
    } else {
        $("#_sale_booster_discounttimer_showhide").hide();
    }
    $("#_sale_booster_discount_timer").change(function(e){
        var value = e.target.checked;
        if(value === true){
            $("#_sale_booster_discounttimer_showhide").show();
        } else {
            $("#_sale_booster_discounttimer_showhide").hide();
        }
    }) 
   

//   date picker
    $('#_sale_booster_expire_date_time').datetimepicker({
        format:'m/d/Y H:i',
        minDate: 0
    });
  

})( jQuery );
