//Custom jquery function
( function($) {
    $.cleanHTML = function(data) {
        var tempDiv = $('<div/>').html(data);
        tempDiv.find('script[src]').remove();
        tempDiv.find('.ajaxTitle').remove();
        return tempDiv.html();
    };
    $.fn.equalHeights = function (minHeight, maxHeight) {
        tallest = (minHeight) ? minHeight : 0;
        this.each(function () {
            if ($(this).height() > tallest) {
                tallest = $(this).height();
            }
        });
        if ((maxHeight) && tallest > maxHeight) tallest = maxHeight;
        return this.each(function () {
            $(this).height(tallest);
        });
    };
    $.fn.equalMinHeights = function (minHeight, maxHeight) {
        tallest = (minHeight) ? minHeight : 0;
        this.each(function () {
            if ($(this).height() > tallest) {
                tallest = $(this).height();
            }
        });
        if ((maxHeight) && tallest > maxHeight) tallest = maxHeight;
        return this.each(function () {
            $(this).css('min-height', tallest);
        });
    };
}) (jQuery);