//Load pages via AJAX for animations
var page = {
    timer: '',
    loadInBackground: function(link, callback) {
        $.ajaxq.abort("pageload");
        $.ajaxq("pageload", {
            url: link, 
            type: 'post',
            data: {'ajax' : 'yes', '_csrf' : browser._csrf},
            success: function(data){
                $('.content').html($.cleanHTML(data));
                browser.setup(1);

                //Execute callback function
                if ($.isFunction(callback)){
                    callback();
                }
            },
            error: function(xhr, status, error) {}
        });
    },
    open: function (link) {
        page.load(link);
    },
    line: function (percentage, duration, callback) {
        $('.loader-line div').stop(true).animate({
            'width': percentage
        }, duration, callback);
    },
    load: function(link) {
        $('.loader-line').css('display', 'block');
        page.line("90%", 4000);
        $.ajaxq.abort("pageload");
        $.ajaxq("pageload", {
            url: link, 
            type: 'post',
            data: {'ajax' : 'yes', '_csrf' : browser._csrf},
            success: function(data){
                page.display($.cleanHTML(data));
                document.title = $.trim($(data).filter('.ajaxTitle').text());
            },
            error: function(xhr, status, error) {
                page.display($.cleanHTML(xhr.responseText));
            }
        });
    },
    display: function(data) {
        $('.content').html(data);
        browser.setup(1);
        $(window).scrollTop(0);
        page.line("100%", 500, function() {
            $('.loader-line').css('display', 'none');
            $('.loader-line div').css('width', 0);
        });
    }
};