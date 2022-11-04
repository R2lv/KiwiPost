/**
 * @param options - Options for hamburger
 * @param options.animation - Hamburger animation, default: 'slide'
 * @param options.color - Hamburger color (html HEX) ex: #FF0000
 * @param options.nav - Nav jquery selector. ex: $("#nav")
 * @param options.hamburgerOpenClass - CSS class for hamburger when opened
 * @param options.navOpenClass - CSS class for {nav} when opened
 *
 * */
$.fn.hamburger = function(options) {
    options = options || {};
    $(this).html('<span></span><span></span><span></span>');

    $(this).addClass(options.animation || 'slide');

    options.color&&$(this).find('span').css({
        'background-color': options.color
    });

    $(this).click(function() {
        $(this).toggleClass(options.hamburgerOpenClass||"open");
        options.nav && options.nav.toggleClass(options.navOpenClass||"open");
    });

    
};