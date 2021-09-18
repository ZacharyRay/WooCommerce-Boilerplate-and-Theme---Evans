//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const checkoutExp = function checkoutExports() {
    jQuery(document).ready(function($){    
        //log('checkout js works1');

        
        //dynamic element
        $(document).on('click', '#showgiftcard', function(event){
            log('hi');
            event.preventDefault();
            $('.add_gift_card_form').toggle();

        })
        
    });
}