//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const cartExp = function cartExports() {
    jQuery(document).ready(function($){    
        //log('Cart js works');
        $(document).on('click', '.chart_quantity_btn', function(e){
            e.preventDefault();

            var fieldname = $(this).data('field');
            var type = $(this).data('type');
            var input = $("input[name='" + fieldname + "']");
            var currentVal = parseFloat(input.val());
    
            log('change quantity: '+currentVal+' '+type);
    
            if (!isNaN(currentVal)) {
                
                if (type == 'minus') {
    
                     if(currentVal > input.attr('min') || input.attr('min') == '') {
                        input.val(currentVal - 1).change();
                      }
    
                } else if (type == 'plus') {
          
                    if(input.attr('max') == '' || currentVal < input.attr('max')){
                        input.val(currentVal + 1).change();
                    }
                }
    
              } else {
                    input.val(0);
              }
        });

        //tricker update cart button
        var timeout;
        $(document).on('change', 'td.product-quantity .qty', function(e){	
            if ( timeout !== undefined ) {
                clearTimeout( timeout );
            }
            timeout = setTimeout(function() {
                $("[name='update_cart']").trigger("click");
            }, 1000 ); // 1 second delay
        });

        $('.cross-sells ul.products').slick({
            dots: false,
            arrows: true,
            infinite: true,
            autoplaySpeed: 2000,  
            mobileFirst: true, 
            slidesToShow: 2,
            slideToScroll: 1,
            autoplay: false,  //EDIT
            rows:0,
            prevArrow: '<span class="slick-prev"><i class="far fa-angle-left"></i></span>',
			nextArrow: '<span class="slick-next"><i class="far fa-angle-right"></i></span>',
            responsive: [
              
                {
                    breakpoint: 1199,
                    settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    }
                }
            ]                                                     
        })


    });
}