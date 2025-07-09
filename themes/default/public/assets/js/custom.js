/*==================================================================================
    Custom JS (Any custom js code you want to apply should be defined here).
====================================================================================*/

// Temporary fix for preloader issue
$(document).ready(function() {
    // Hide preloader after 3 seconds as a temporary fix
    setTimeout(function() {
        $('.preloader').fadeOut(1000);
    }, 3000);
    
    // Also hide preloader when window is fully loaded
    $(window).on('load', function() {
        $('.preloader').fadeOut(1000);
    });
});

