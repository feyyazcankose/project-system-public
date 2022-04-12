/*=========================================================================================
    File Name: advance-cards.js
    Description: intialize advance cards
    ----------------------------------------------------------------------------------------
    Item Name: Stack - Responsive Admin Theme
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
// Area chart
// ------------------------------
$(window).on("load", function() {
    var recent_buyers = new PerfectScrollbar("#recent-buyers", {
        wheelPropagation: false
    });
    /********************************************
     *               PRODUCTS SALES              *
     ********************************************/



    /********************************************
     *               Monthly Sales               *
     ********************************************/



    /************************************************************
     *               Social Cards Content Slider                 *
     ************************************************************/
    // RTL Support
    var rtl = false;
    if ($('html').data('textdirection') == 'rtl') {
        rtl = true;
    }
    if (rtl === true)
        $(".tweet-slider").attr('dir', 'rtl');
    if (rtl === true)
        $(".fb-post-slider").attr('dir', 'rtl');

    // Tweet Slider
    $(".tweet-slider").unslider({
        autoplay: true,
        delay: 3500,
        arrows: false,
        nav: false,
        infinite: true
    });

    // FB Post Slider
    $(".fb-post-slider").unslider({
        autoplay: true,
        delay: 4500,
        arrows: false,
        nav: false,
        infinite: true
    });
});