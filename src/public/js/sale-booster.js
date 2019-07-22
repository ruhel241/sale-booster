(function($) {
   CountDownTimer(sale_booster_countdown_vars.dateTime, "._sale-booster-countdown");
   function CountDownTimer(date, countdown) {
      var end = new Date(date);
      var _second = 1000;
      var _minute = _second * 60;
      var _hour = _minute * 60;
      var _day = _hour * 24;
      var timer;

      function showRemaining() {
            var now = new Date();
            var distance = end - now;
            if (distance < 0) {
               clearInterval(timer);
               var countDownTopClass = $('._sale-booster-countdown-top');
               var countDownBottomHitsClass = $('._sale-booster-countdown-bottom');
               if( countDownTopClass || countDownBottomHitsClass ){
                  countDownTopClass.hide();
                  countDownBottomHitsClass.hide();
               }
               return;
            }
         var days = Math.floor(distance / _day);
         var hours = Math.floor((distance % _day) / _hour);
         var minutes = Math.floor((distance % _hour) / _minute);
         var seconds = Math.floor((distance % _minute) / _second);

         var countDownViews = $(countdown);
          countDownViews.html(
            `<div class='_sale-discount-countdown-timer'>
               <span class='_sale-discount-time'>${days}</span>
               <span class='_sale-discount-units'>days</span>
            </div>
            <div class='_sale-discount-countdown-timer'>
               <span class='_sale-discount-time'>${hours}</span>
               <span class='_sale-discount-units'>hrs</span>
            </div>
            <div class='_sale-discount-countdown-timer'>
               <span class='_sale-discount-time'>${minutes}</span>
               <span class='_sale-discount-units'>mins</span>
            </div>
            <div class='_sale-discount-countdown-timer'>
               <span class='_sale-discount-time'>${seconds}</span>
               <span class='_sale-discount-units'>secs</span>
            </div>`);
         }
         
         timer = setInterval(showRemaining, 1000);
        
         var topClass = $('._sale-booster-countdown-top');
         countdownTopDivClass(topClass);
   }

   function countdownTopDivClass(topClass){
      if(topClass){
         $('body').prepend( $(topClass) );
         $(window).scroll(function () {
            if ($(window).scrollTop() > 0) {
               topClass.addClass('fixed');
            }
            if ($(window).scrollTop() < 1) {
               topClass.removeClass('fixed');
            }
         });
      }
   }
      
   
})( jQuery );



