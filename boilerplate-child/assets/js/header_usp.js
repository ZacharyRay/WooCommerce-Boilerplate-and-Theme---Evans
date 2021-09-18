jQuery(document).ready(function ($) {
    $('#header_usp').slick({
            dots: false,
            arrows: true,
            prevArrow: '<span class="slick-prev"><i class="far fa-angle-left"></i></span>',
                  nextArrow: '<span class="slick-next"><i class="far fa-angle-right"></i></span>',
            infinite: true,
            autoplaySpeed: 2000,  
            mobileFirst: true, 
            slidesToShow: 1,
            slideToScroll: 1,
            autoplay: true, 
            rows:0,        
            responsive: [
              {
                breakpoint: 767,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  
                }
              },
              {
                breakpoint: 1023,
                settings: {
                  arrows: false,
                  slidesToShow: 3,
                  slidesToScroll: 1,
                  
                }
              },
              {
                breakpoint: 1199,
                settings: {
                  arrows: false,
                  slidesToShow: 4,
                  slidesToScroll: 1,
                  variableWidth: true,
                }
              }
            ]                                                     
        });
        })