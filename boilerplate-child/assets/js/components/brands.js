//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const brandsExp = function brandsExports() {
    jQuery(document).ready(function($){    
        //log('brands js works');


        $(window).resize(function(e){
            if($(window).width() > 767) {
                
                $('.brand-slider').each(function(){
                    if(!$(this).hasClass('slick-initialized')){
                        $(this).slick({
                            dots: false,
                            arrows: false,
                            infinite: true,
                            autoplaySpeed: 2000,  
                            mobileFirst: true, 
                            slidesToShow: 4,
                            slideToScroll: 1,
                            autoplay: true,  
                            rows:0,
                            responsive: [
                                {
                                  breakpoint: 1199,
                                  settings: {
                                    slidesToShow: 6,
                                    slidesToScroll: 1,
                                  }
                                }
                            ]                                                     
                        })
                    }
                });                
        
            }else{              
                $('.brand-slider').each(function(){
                    if($(this).hasClass('slick-initialized')){
                        $(this).slick('unslick');
                    }
                });
            }
        }).resize();
      
    });
}