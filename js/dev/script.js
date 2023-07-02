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
    $('body').on('mouseover', '.hover_div', function (e) {
        e.preventDefault();
        var el = $(this), val = el.attr('data-hover');
        $('.hover_div').removeClass('active');
        $('.circle_image').removeClass('active');
        el.addClass('active');
        $('.circle_image[data-key=' + val + ']').addClass('active');
    });

    $('body').on('click', '.faq_title', function (e) {
        e.preventDefault();
        var close = $(this).closest('.faq_div');
        if (close.hasClass('faq_opened')) {
            $(this).next('.faq_text').slideUp('slow');
            close.removeClass('faq_opened');
        } else {
            close.removeClass('faq_opened');
            $(this).next('.faq_text').slideToggle('slow');
            close.addClass('faq_opened');
        }
    });

    //Open a overlay
    $('body').on('click', 'a.video-player', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        e.preventDefault();
        video.embed(this.href);
    });

    //Close overlay
    $('body').on('click', '.video-overlay .close', function (e) {
        e.stopPropagation();
        video.close();
    });

    $('body').on('click', '.video-overlay .close', function (e) {
        e.stopPropagation();
        video.close();
    });

    $('html').on('click', '.home .header_menu a', function (e) {
        e.preventDefault();
        console.log('.header_menu a');
        browser.scrollPage(this.href);
    });


    /* Resize screen */
    $(window).resize(function () {
        browser.setup(0);
    });


    /********************
     ONE TIME INIT
     *********************/
    browserhistory.init();
    browser.setup(1);
    if (typeof jQueryInit == "function") {
        jQueryInit();
    }
    $(window).scroll(browser.scrollEvent);
});

$(window).on('load', function () {
    browser.scrollEvent();
});