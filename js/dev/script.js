$(function () {
    /*********************
     ALL CLICKS
     *********************/
    var pageTimer;
    $('body').on('click', 'a[href]:not([href^="mailto\\:"], [href^="tel\\:"], [data-default], [data-scroll], [target], .play, [href*=".pdf"])', function (e) {
        e.preventDefault();

        if (this.href == window.location.href) {
            //Do nothing
        } else {
            var link = $(this).attr('href');
            var delay = 0,
                    el = this;
            clearTimeout(pageTimer);

            if ($(".cycle").length)
                $(".cycle").cycle("destroy");

            if ($('html').hasClass('open-menu')) {
                $(".menu-tr:first").click();
                delay = 400;
            }

            pageTimer = setTimeout(function () {
                browserhistory._object.pushState(null, null, el.href);
            }, delay);
        }
    });

    $('body').on('click', 'a[data-scroll]', function (e) {
        e.preventDefault();
        var el = $(this),
                sel = el.data('scroll');
        $('html, body').animate({
            'scrollTop': $(sel).offset().top - $(".header").outerHeight() - 30
        }, 1000);
    });

    /********************
     FORM INPUTS
     *********************/

    /********************
     MENU TRIGGER
     *********************/



    /* Resize screen */
    $(window).resize(function () {
        browser.setup(0);
    });


    /********************
     ONE TIME INIT
     *********************/
    browserhistory.init();
    browser.setup(1);
    if (typeof jQueryInit == "function")
        jQueryInit();
    $(window).scroll(browser.scrollEvent);
});

$(window).on("load", function () {
    $(window).scroll(browser.scrollEvent);
});