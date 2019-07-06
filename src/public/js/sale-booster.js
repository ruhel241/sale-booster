CountDownTimer(sale_booster_countdown_vars.dateTime, "_sale-booster-countdown-top", "_sale-booster-countdown-bottom");
function CountDownTimer(date, countdown_top, countdown_bottom ) {
     var end = new Date(date);

     var _second = 1000;
     var _minute = _second * 60;
     var _hour = _minute * 60;
     var _day = _hour * 24;
     var timer;

     function showRemaining(date) {
         var now = new Date();
         var distance = end - now;
         if (distance < 0) {
            //  clearInterval(timer);
            //  document.getElementById(id).innerHTML = "EXPIRED!";
            return;
         }
         var days = Math.floor(distance / _day);
         var hours = Math.floor((distance % _day) / _hour);
         var minutes = Math.floor((distance % _hour) / _minute);
         var seconds = Math.floor((distance % _minute) / _second);

         var  countdownTop = document.getElementById(countdown_top);
         var  countdownBottom    = document.getElementById(countdown_bottom);

         if(sale_booster_countdown_vars.dateTime !== ''){
            //  bootom
            countdownBottom.innerHTML = days + "days " + hours + "hrs " + minutes + "mins " + seconds + "secs";
            countdownBottom.innerHTML += "<div class='_sale-booster-hits'> Prices go up when the timer hits zero.</div>";
            // Top
            countdownTop.innerHTML = days + "days " + hours + "hrs " + minutes + "mins " + seconds + "secs";
           
         }

     }

     timer = setInterval(showRemaining, 1000);
 }