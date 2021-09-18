//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const udvalgteExp = function udvalgteExports() {
    jQuery(document).ready(function($){    
        //log('Udvalgte varer js works');

        $('.udvalgte_varer .products').each(function(){
            
            $(this).slick({
                dots: false,
                arrows: false,
                infinite: true,
                autoplaySpeed: 2000,  
                mobileFirst: true, 
                slidesToShow: 2,
                slideToScroll: 1,
                autoplay: true, //OBS 
                rows:0,
                responsive: [
                    {
                        breakpoint: 767,
                        settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 1023,
                        settings: {
                          slidesToShow: 5,
                          slidesToScroll: 1
                        }
                    },
                ]                                                     
            })
        });                
    });
}