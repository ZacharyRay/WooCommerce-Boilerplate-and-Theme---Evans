//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const utilsExp = function utilsExports() {
    jQuery(document).ready(function($){    
        //log('utilss js works');

        //popup
        $('[data-popup]').on('click', function(){         
            var popup_id = $(this).data('popup');
            $('#'+popup_id).css('display', 'flex');
        })
        
        $('.popup_close').on('click', function(){
            $(this).closest('.popup').hide();
        })

        $('.pupup_content').on('click', function(e){
          e.stopPropagation();
        })

        $('.popup').on('click', function(){
            $(this).closest('.popup').hide();
        })
          
    });
}