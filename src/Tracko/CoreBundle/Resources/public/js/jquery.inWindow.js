/**
 A simple jQuery plugin to find out if dom is in window or not
 */

(function ($) {
    $.fn.inWindow = function () {
        if ($(this).length > 0)
            return $(window).scrollTop() + $(window).height() > $(this).offset().top;
        return false;
    };
})(jQuery);
