 $(document).ready(function() {
      
         
             $('.slider').slick({
                 dots: false,
                 arrows: true,
                 slidesToShow: 1,
                 slidesToScroll: 1,
                 autoplay: true,
                 autoplaySpeed: 4000,
             });
     
//     $('.nav-menu').each(function(e) => {
//            // window.loca
//            var path = '';
//            if (path == '/aoub') {
//         $(e).a
//     }
//     }
                         
     
     //
     $("a").click(function() {
             var targetDiv = $(this).attr('href');
             $('html, body').animate({
                 scrollTop: $(targetDiv).offset().top
             }, 2000);
         });
    });
         