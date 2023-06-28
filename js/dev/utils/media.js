//Embed Video as overlay
var video = {
    embedUrl: function (link, autoplay) {
        if (typeof autoplay == "undefined")
            autoplay = true;

        var pattern1 = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;
        var pattern2 = /(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;
        var embedUrl = "";

        if (pattern1.test(link)) {
            embedUrl = link.replace(pattern1, "https://player.vimeo.com/video/$1");
            if (autoplay)
                embedUrl += "?autoplay=1";

        } else if (pattern2.test(link)) {
            embedUrl = link.replace(pattern2, "https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0");
            if (autoplay)
                embedUrl += "&autoplay=1";
        }

        return embedUrl;
    },
    embed: function (link) {
        var url = this.embedUrl(link);
        this.iframeEmbed(url);
    },
    iframeEmbed: function (link) {
        var iframe = '<iframe width="420" height="345" src="' + link + '" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>',
                html = '<div class="overlay video-overlay">' + iframe + '<a class="close">&#215;</a></div>';

        $('body').append(html);
        this.objectFit();

        scrollbar.disable('has-overlay');
    },
    close: function () {
        scrollbar.enable('has-overlay', function () {
            $('.video-overlay').remove();
        });
    },
    objectFit: function () {
        var wid = 1280,
                hei = 720,
                wrapper = $('.overlay'),
                wrapperWid = wrapper.width() * .9,
                wrapperHei = wrapper.height() * .9,
                newWid = wrapperWid,
                newHei = Math.floor(newWid * hei / wid);

        if (newHei > wrapperHei) {
            newHei = wrapperHei;
            newWid = Math.floor(newHei * wid / hei);
        }

        $('.video-overlay iframe').css({
            'width': newWid + 'px',
            'height': newHei + 'px'
        });
    },
    iframeFit: function (el) {
        var wid = 1920, hei = 1080,
                wrapper = el.parent(),
                wrapperWid = wrapper.width(),
                wrapperHei = wrapper.height(),
                newWid = wrapperWid,
                newHei = Math.floor(newWid * hei / wid);

        if (newHei > wrapperHei) {
            newHei = wrapperHei;
            newWid = Math.floor(newHei * wid / hei);
        }

        el.css({
            'top': '50%',
            'left': '50%',
            'margin-top': -1 * Math.round(newHei / 2) + 'px', 'margin-left': -1 * Math.round(newWid / 2) + 'px', 'width': newWid + 'px',
            'height': newHei + 'px'
        });
    },
    iframeRemove: function (el) {
        //Show background image
        $(el).find('.video_placeholder').removeClass('hide');
        //Remove iframe
        $(el).find('iframe').remove();
    }
};