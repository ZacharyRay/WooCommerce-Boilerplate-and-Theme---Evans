//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const favoritterExp = function favoritterExports() {
    jQuery(document).ready(function($){    
        //log('favoritter js works');

        $(document).on('click', 'button.favoritter',function(event){
            event.preventDefault();
            event.stopPropagation();

            var id = $(this).data('id');
            var type = $(this).data('type');

            if(type !="nothing"){ //prevent not login user to fire ajax event

                $.ajax({
                    url: ajax_obj.ajaxurl, 
                    data: {
                        'action': 'update_favoritter',
                        'product_id' :  id, 
                        'type' :  type, 		
                    },
                    beforeSend:function(){
                        $('.favoritter').css( "cursor", "wait" );
                    },
                    success:function(response) {
                        // This outputs the result of the ajax request
                        update_fave_count();
                        
                        if(type == 'remove_me'){
                            $('li.post-'+id).remove();

                            if( $('.favoritter ul.products li').length == 0 ) {
                                $('.favoritter ul.products').html('<li>'+response+'</li>');
                                
                            }else{
                                log('not empty');
                            }
                            
                        }
                        else{
                            $( ".favoritter" ).replaceWith(response);
                        }
                        $('.favoritter').css( "cursor", "pointer" );
                    },
                    error: function(errorThrown){
                        //log(errorThrown);
                    },
                    complete: function(){
                        //log('hej');
                    } 
                });
            }
        })

        function update_fave_count(){
            $.ajax({
                url: ajax_obj.ajaxurl, 
                data: {
                    'action': 'update_favoritter_count',                    		
                },
                success:function(response) {
                   $('#whishlist_count').html(response);
                },
            });
        }

    });
}