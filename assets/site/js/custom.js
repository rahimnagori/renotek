 /*slider*/
 $('#slider1').owlCarousel({
         loop: true,
         // margin:15,
         nav: true,
         responsive: {
             0: {
                 items: 1
             },
             600: {
                 items: 1
             },
             1000: {
                 items: 1
             }
         }
     })
     /*slider close*/

      /*slider2*/
 $('#slider2').owlCarousel({
    loop: true,
     margin:15,
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 3
        }
    }
})
/*slider2 close*/

 /*nav*/
 $(window).on("scroll", function() {
     if ($(window).scrollTop() > 50) {
         $(".main_nav").addClass("fixed_top");
     } else {
         $(".main_nav").removeClass("fixed_top");
     }
 });
 /*nav close*/

 /*counter*/
 $('.counter').each(function() {
     var $this = $(this),
         countTo = $this.attr('data-count');

     $({ countNum: $this.text() }).animate({
             countNum: countTo
         },

         {
             duration: 8000,
             easing: 'linear',
             step: function() {
                 $this.text(Math.floor(this.countNum));
             },
             complete: function() {
                 $this.text(this.countNum);
             }
         });

 });

 /*counter*/


 $(document).ready(function() {
     //called when key is pressed in textbox
     $(".quantity").keypress(function(e) {
         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             //display error message
             //$("#errmsg").html("Digits Only").show().fadeOut("slow");
             return false;
         }
     });
 });


 $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

