export const productExp = function productExports() {
    jQuery(document).ready(function ($) {
  
        //log('product js works');

        //product slider
        $('.woocommerce-product-gallery__wrapper').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            rows:0,
            arrows:false,
            asNavFor: '.woocommerce-product-gallery-thumbnails',
        });

        $('.woocommerce-product-gallery-thumbnails').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            rows:0,
            asNavFor: '.woocommerce-product-gallery__wrapper',
            dots: false,
            centerMode: false,
            focusOnSelect: true,
            prevArrow: '<span class="slick-prev"><i class="far fa-angle-left"></i></span>',
            nextArrow: '<span class="slick-next"><i class="far fa-angle-right"></i></span>',
            
            responsive: [
                {
                  breakpoint: 767,
                  settings: {
                    arrows: false,
                  }
                } 
            ]
        });

        //Update variation price
        var p = $('p.price').html();
        $('form.variations_form.cart').on('show_variation', function( event, data ) {
          log(data);
            if ( data.price_html ) {
              $('p.price').html(data.price_html);

              var display_price = data.display_price;
              var display_regular_price = data.display_regular_price;
              log(display_price+' '+display_regular_price);
              if(display_price == display_regular_price){
                var percent = 0; 
                $('#sale_badge').hide();
              }
              else{
                var percent = Math.round(100 - (display_price / display_regular_price * 100))
                $('#sale_badge').find('.sale_text').text(percent+'%');
                $('#sale_badge').show();
              }
             
              log(parseInt(percent));
            }
        }).on('hide_variation', function( event ) {
            $('p.price').html(p);
        });

        //select pa_stoerrelse
        $('select#pa_stoerrelse').hide();
        $('#pa_stoerrelse_variations').css('display', 'flex');

        $('.variation_button:not(deactivated)').on('click', function(){
          var attribute = $(this).data('attribute-name');
          var attribute_value = $(this).data('value');
          $("#"+attribute).val(attribute_value).change();
        })

        $('#pa_stoerrelse').on('change', function(){
          $('.variation_button').removeClass('active');

          if($(this).val()){
            $('.variation_button[data-value='+$(this).val()+']').addClass('active');
          }
        })
        $("#pa_stoerrelse").change();

        $( "#pa_stoerrelse" ).on( "DOMSubtreeModified", function () {
            // Fires whenever variation selects are changed
            //$('#pa_stoerrelse').find("option").each(function() {log(this.value);});

            $('.variation_button').removeClass('deactivated');
            $('.variation_button ').each(function() {
              var attribute_value = $(this).data('value');
              if(!$("#pa_stoerrelse option[value='"+attribute_value+"']").length > 0){
                $(this).addClass('deactivated');               
              }
            })

        } );

        //countdown
        if($('[data-countdown]').length){

            var get_date = $('[data-countdown]').data('countdown');
            log(get_date);
            var countDownDate = new Date(get_date).getTime();
          
            // Update the count down every 1 second
            var x = setInterval(function() {

              // Get today's date and time
              var now = new Date().getTime();
              

              // Find the distance between now and the count down date
              var distance = countDownDate - now;

              // Time calculations for hours, minutes and seconds 
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));            
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);

              // Display the result in the element with id="demo"
              if(days == 0){
                $('#days').remove();
               
              }else{
                var days_text =  $('#days').data(days == 1 ? 'single' :'multiple');
                $('#days').text(days+' '+days_text);
              }
             
              var hours_text =  $('#hours').data(hours == 1 ? 'single' :'multiple');
              $('#hours').text(hours+' '+hours_text);

              var minutes_text =  $('#minutes').data(minutes == 1 ? 'single' :'multiple');
              $('#minutes').text(minutes+' '+minutes_text);
              
              var seconds_text =  $('#seconds').data(seconds == 1 ? 'single' :'multiple');
              $('#seconds').text(seconds+' '+seconds_text);

              // If the count down is finished, write some text
              if (distance < 0) {
                clearInterval(x);
                var relaod_text = $('[data-countdown]').data('reload');
                $('[data-countdown]').text(relaod_text);
              }
            }, 1000);
        }

    })
  };
  