//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const produkt_filterExp = function produktfilterExports() {
    jQuery(document).ready(function($){    
        //log('filter js works');

        var slider_range = $('.slider-range');
        if(slider_range.length){

            slider_range.each(function(num, elem) {
                var min = $(this).data('min') ? $(this).data('min') : 0;
                var max = $(this).data('max') ? $(this).data('max') : 3000;
                var after = $(this).data('after') ? $(this).data('after') : '';

                var start_min = $(this).data('start-min') ? $(this).data('start-min') : min;
                var start_max = $(this).data('start-max') ? $(this).data('start-max') : max;

                $( this ).slider({ 
                    range: true,
                    min: min, 
                    max: max,
                    values: [ start_min, start_max ],
                    slide: function( event, ui ) {                       
                        $( this ).siblings('.range-amount').html( ui.values[ 0 ]+' '+after+" - "+ui.values[ 1 ]+' '+after );
                        $( this ).siblings('.min').val(ui.values[ 0 ]);
                        $( this ).siblings('.max').val(ui.values[ 1 ]);
                    },
                    stop: function(event, ui) {                        
                        $( '#product_filter  .min').trigger('change');
                    
                    }
                });

                //set input values
                $( this ).siblings('.range-amount').html($( this).slider( "values", 0 )+' '+after+" - "+$( this ).slider( "values", 1 )+' '+after);
                $( this ).siblings('.min').val($( this).slider( "values", 0 ));
                $( this ).siblings('.max').val($( this).slider( "values", 1 ));
            })
        }

        //Show/hide Remove filter on load
        set_clear_filter_state();
        
        $('#product_filter .dropdown input, #p_num').on('change', function(e, info){
            
            log('change filter: ');
           
            var elementType = $(this).attr('type');
           
            if(elementType == 'checkbox' || (info && info['remove']) || $(this).attr("id") == "storrelse-min" || $(this).attr("id") == "storrelse-max"){
                $('#p_num').val(1); 
                //log('change to page 1');
            }else{
                //log('dont change page');
            }

            
            
            var filter = $('#product_filter');
            //log(filter.serialize());

            $.ajax({ //action: product_filter. er gemt som hidden input
                url: ajax_obj.ajaxurl, 
                data: filter.serializeArray(), 
                type:filter.attr('method'),
                beforeSend:function(){
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                   
                    var result = $.parseJSON(data)
                    //log(result['html']);
                    //log('pagination: '+result['pagination']);
                    // log(result['post']);
                    // log(result['query_string']);

                    $('.products').html(result['html']); 

                    $('.woocommerce-pagination').html(result['pagination']);

                    if( info && info['new_url'] ){ //if pagination
                        var new_url = info['new_url'];  

                        var header_offset = $('.header').height();
                        $('html, body').animate({
                            scrollTop: $('.op_product_filter').offset().top - header_offset
                          }, 800, function(){
                            
                        });                      
                    }else{
                       var new_url = window.location.href.split('?')[0]+ result['query_string'];
                        
                    }
                    window.history.pushState("string", "Title", new_url);

                    //Show hide Remove filter
                    set_clear_filter_state();

                   
                    
                },
                error: function(errorThrown){
                    //log(errorThrown);
                },
                complete: function(){
                } 
            });


            //Update counter
            $('.op_check_product_filter').each(function () {
              
                var number = $(this).find('.dropdown input:checkbox:checked').length;
                if (number == 0) {
                    $(this).find('.counter').html('');
                } else {
                    $(this).find('.counter').html(' (' + number + ')');
                }
            })

            var sort_radio = $('.p_sort_filter').find('input:radio:checked').length;
            //log($('.p_sort_filter').find('input:radio:checked'));
            if(sort_radio== 0){
                $('.p_sort_filter').find('.counter').html('');
            } else {
                $('.p_sort_filter').find('.counter').html(' (' + sort_radio + ')');
            }
            

        });


        //Use ajax pagination
        $(document).on('click', 'body.tax-product_cat .woocommerce-pagination a, body.tax-product_brand .woocommerce-pagination a', function(event){
            event.preventDefault();
            log('ajax pagination');
            
            var url = $(this).attr('href');
            //change pagenumber
            
            //change url
            //window.history.pushState("string", "Title", url);

            $('#p_num').val(get_page_number(url)).trigger('change', [{new_url : url}]);
            
            //close dropdown
            $('.dropdown_controle_trigger').each(function(){
                var input = $(this).attr('for');
                $("#"+input).prop('checked', false)
            })
        })

        $(document).on('click', '.clear_filter', function(){
            log('clear filter');
            $('#product_filter')[0].reset();

            var min = slider_range.data('min') ? slider_range.data('min') : 0;
            var max = slider_range.data('max') ? slider_range.data('max') : 3000;
            var after = slider_range.data('after') ? slider_range.data('after') : '';

            slider_range.slider("values", 0, min);  
            slider_range.slider("values", 1, max ); 

            $('#storrelse-min').val(min);
            $('#storrelse-max').val(max);

            $( ".range-amount" ).html( min+' '+after+ " - " + max +' '+after);

            $('#product_filter input[type=checkbox]').prop('checked',false);
            
            var url = $('#url').val();
            $( '#product_filter .dropdown input').first().trigger('change', [{remove:true, new_url : url }]);
            
            window.history.pushState("string", "Title", window.location.href.split('?')[0]);


            $(this).css('opacity', '0');
            //location.reload();
        })

        //close other dropdown menus
        $('.dropdown_controle_trigger').on('click', function(){
        //     $('.dropdown_controle_trigger').focus();
        //    log('focus');
            $('.dropdown_controle_trigger').not(this).each(function(){
                //log($(this).attr('for'))
                var input = $(this).attr('for');
                $("#"+input).prop('checked', false)
            })
        })

        $(document).on('mouseup', function(e) {
            var container = $(".dropdown_controle_trigger");
            var dropdown = $(".dropdown");

            //log(e.target);
           
            // if the target of the click isn't the container nor a descendant of the container
            if (
                !container.is(e.target) && container.has(e.target).length === 0 && 
                !dropdown.is(e.target) && dropdown.has(e.target).length === 0
            ){
                $('.dropdown_controle_trigger').each(function(){
                    var input = $(this).attr('for');
                    $("#"+input).prop('checked', false);
                })
            }
        });

        $(".ui-slider-handle").on("mousedown touchstart", function(e) {
            $(this).addClass('grabbing')
        })
        
        $(".ui-slider-handle").on("mouseup touchend", function(e) {
            $(this).removeClass('grabbing')
        })


        function set_clear_filter_state(){

            var query = getUrlVars(window.location.href);

            var min = $('.slider-range').data('start-min');
            var max = $('.slider-range').data('start-max');

            if( 
                Object.keys(query).length <= 3 
                && (query['orderby'] == 'price' || query['orderby'] == null) 
                && (query['min'] == min || query['min'] == null)
                && (query['max'] == max || query['max'] == null)
            ){
                $('.clear_filter').css('opacity', '0'); 
            }else{
                $('.clear_filter').css('opacity', '1');                 
            }

        }

    });


    function getUrlVars($url){
        var vars = {}, hash;
        
        var hashes = $url.slice($url.indexOf('?') + 1).split('&');        
        //log(hashes);

        hashes.forEach(function(data){
            var split = data.split('=');
            vars[split[0]] = split[1];
            
        })

        return vars;
    }

    function get_page_number(url){
       
        //var url = window.location.href
        var url = url.split('?')[0].split('/');
        var number = url.indexOf('page') + 1;
        return (url[number] != 0 ? url[number] : '1');
    }
    
}