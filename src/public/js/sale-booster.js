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
             let countDownExpires = document.querySelectorAll(countdown);
               countDownExpires.forEach(countDownExpire => {
                  countDownExpire.innerHTML = '';
               });  
            return;
         }
         var days = Math.floor(distance / _day);
         var hours = Math.floor((distance % _day) / _hour);
         var minutes = Math.floor((distance % _hour) / _minute);
         var seconds = Math.floor((distance % _minute) / _second);


         let countDownViews = document.querySelectorAll(countdown);
            countDownViews.forEach(countDownView => {
            console.log(countDownView);
            countDownView.innerHTML = days + "days " + hours + "hrs " + minutes + "mins " + seconds + "secs";
         });

      }

     timer = setInterval(showRemaining, 1000);
 }