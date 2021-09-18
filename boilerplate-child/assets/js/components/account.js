//this file is an example. Create as many js files as you want in the utils folder, just remember to export them like this, and import them in app.js
export const accountExp = function utilsExports() {
    jQuery(document).ready(function($){    
        //log('account js works');
        
        $('#customer_login .col-2 h2').on('click', function(){
            log('test');
            $(this).siblings(".woocommerce-form-register").toggle();
        })
    });
}