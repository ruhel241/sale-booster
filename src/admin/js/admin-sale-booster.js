(function($) {
    // Discound Timer
    var discoundTimerVars = sale_booster_discound_timer_vars.discound_timer;
    if(discoundTimerVars === 'yes'){
        $("#_sale_booster_discoundtimer_showhide").show();
    } else {
        $("#_sale_booster_discoundtimer_showhide").hide();
    }
    $("#_sale_booster_discound_timer").change(function(e){
        var value = e.target.checked;
        if(value === true){
            $("#_sale_booster_discoundtimer_showhide").show();
        } else {
            $("#_sale_booster_discoundtimer_showhide").hide();
        }
    }) 
   

//   date picker
    $('#_sale_booster_expire_date_time').datetimepicker({
        format:'m/d/Y H:i',
        minDate: 0
    });
  

})( jQuery );
