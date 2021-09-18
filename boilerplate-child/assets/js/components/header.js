export const headerExp = function testExports() {
  jQuery(document).ready(function ($) {

    //log('header js works');

    //close other dropdown menus
    $('.fake_a').on('click', function(){
      $('.fake_a').not(this).each(function(){
        //log($(this).attr('for'))
        var input = $(this).attr('for');
        $("#"+input).prop('checked', false)
      })
    })

    $(document).on('mouseup', function(e) {
      var container = $(".fake_a");
      var dropdown = $(".sub-menu-wrapper-0");

      // log(e.target);
      // log(e);
     
      // // if the target of the click isn't the container nor a descendant of the container
      if (  !container.is(e.target) && container.has(e.target).length === 0&& 
            !dropdown.is(e.target) && dropdown.has(e.target).length === 0 ){
          $('.fake_a').each(function(){
              var input = $(this).attr('for');
              $("#"+input).prop('checked', false)
          })
      }
  });

    //Open burger menu
    $('#h_icon_menu').on('click', function(){
      $('#menu-header-menu').toggle();
    })

    //open search form
    var search_item = $("#h_icon_search");
    var serach_field_wrapper = $('.search_field');
    var search_input = $('#h_search'); 
    if(search_item.length > 0){
      search_item.on('click', function(){
        serach_field_wrapper.toggle();
        search_input.focus(); 
        
        if(serach_field_wrapper.is(":visible")){
          $("#h_icon_search svg").attr('data-icon', 'times')
        }else{
          $("#h_icon_search svg").attr('data-icon', 'search')
        }

      })

      serach_field_wrapper.on('click', function(){
        search_input.focus();
      })

      $('#search_field svg').on('click', function(){
        log('test');
        $('#searchform').submit();
      })

      
    }

    //Hide search on scroll mobil
    
   

    $(document).scroll(function() {

      if ($(window).width() < 768) {

        var header_height = 0; //$('.header').height();
        var y = $(this).scrollTop();
        if (y > header_height) {        
          $('.search_field').fadeOut(100);
          $('.header .container#main').css('padding-bottom', '0px');
          log('hide');
        } else {
          $('.search_field').fadeIn(100);
          $('.header .container#main').css('padding-bottom', '');
          log('show');
        } 
  
        //log('mobile');
      }else{
        //log('computer');
        $('.search_field').show();
        $('.header .container#main').css('padding-bottom', '');
      }
      
    });
    


      
    

  })
};
