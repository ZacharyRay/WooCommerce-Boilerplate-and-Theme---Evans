//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const shop_notice_Exp = function shop_notice_Exports() {
    jQuery(document).ready(function($){    
        //log('Shop notice js works');
        
        $('#shop_notice_close').on('click', function(event){
            event.stopPropagation();
           
            $.ajax({

                url: ajax_obj.ajaxurl, 
                data: {
                    'action': 'remove_shop_notice',	
                },
                success: function(show_subgoals){
                    $('.shop_notice').remove();
                }
            
            });
            
            
        })
    });
}