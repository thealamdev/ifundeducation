$(function ($) {
    // menu js
    // var main_menu = $('#main_navigation').offset().top;
    // $(window).on('scroll',function(){
    //   var scroll_value = $(window).scrollTop();
    //   if(scroll_value > main_menu){
    //     $('#main_navigation').addClass('menuFix');
    //   }else{
    //     $('#main_navigation').removeClass('menuFix');
    //   }
    // });

    $(".mobile_menu_icon").on("click", function () {
        $(".account_menu").addClass("fixed");
    });
    $(".account_menu .close_icon").on("click", function () {
        $(".account_menu").removeClass("fixed");
    });
});
