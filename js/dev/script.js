$(function () {
    /*********************
     ALL CLICKS
     *********************/
    var pageTimer;
    
     $('body').on('click', '#heatmap a', function (e) {
          e.preventDefault();
     });
     
    $('body').on('click', 'a[href]:not([href^="mailto\\:"], [href^="tel\\:"], [data-default], [data-scroll], [target], .play, [href*=".pdf"])', function (e) {
        e.preventDefault();
        if($(this).attr('href') !== '#') {
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
        }}
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
        browser.scrollPage(this.href);
    });

    $('body').on('click', '.tab', function (e) {
        e.preventDefault();
        var el = $(this), v = el.attr('data-tab');
        $('.tab').removeClass('active');
        el.addClass('active');
        $('.tab_content').hide();
        $('#' + v).fadeIn();
    });

    $('body').on('click', '.register_section', function (e) {
        e.preventDefault();
        $('.forms').css('transform', 'translate(-100%)');
    });

    $('body').on('click', '.login_section', function (e) {
        e.preventDefault();
        $('.forms').css('transform', 'translate(0)');
    });


    $('body').on('click', '.forgot_section', function (e) {
        e.preventDefault();
        $('.forms').css('transform', 'translate(-200%)');
    });
    
      $('body').on('blur', 'input[name=from_strike_price], input[name=to_strike_price]', function () {
        browser.getHistoryData();
    });
    
      $('body').on('change', 'input[name=trade_date], input[name=expiry_date], input[name=start_time], input[name=end_time], input[name=stocks_type]', function () {
          var  strike_price = $('input[name=stocks_type]:checked').attr('data-value');
           var stocks_type = $('input[name=stocks_type]:checked').val();
           if(stocks_type === 'nifty') {
            $('input[name=to_strike_price]').val(parseFloat(strike_price) + parseFloat(500));
            $('input[name=from_strike_price]').val(parseFloat(strike_price) - parseFloat(500));
           } else {
              $('input[name=to_strike_price]').val(parseFloat(strike_price) + parseFloat(1000));
            $('input[name=from_strike_price]').val(parseFloat(strike_price) - parseFloat(1000));  
           }
          
        browser.getHistoryData();
    });
    
      $('body').on('change', 'input[name=start_time], input[name=end_time]', function () {
          var start_time = $('input[name=start_time]').val();
           var end_time = $('input[name=stocks_type]').val();
        //   browser.timeRangeSlider([browser.minutesHours(start_time), browser.minutesHours(end_time)]);
        //   console.log(browser.minutesHours(start_time));
          $("#slider-range").slider('values',0,browser.minutesHours(start_time));
            $("#slider-range").slider('values',0,browser.minutesHours(end_time));
       
      });
    
    
    $('body').on('change', 'select[name=future_minutes], input[name=future_expiry_date], input[name=future_trade_date], input[name=future_stocks_type]', function () {
        browser.getFuturesData();
    });
    
     $('body').on('click', 'input[name=minutes]', function () {
         var el = $(this), v = el.val();
        var now = new Date();
        var startDate = new Date();
        startDate.setHours(09, 15, 0, 0);
        var endDate = new Date();
        endDate.setHours(15, 30, 0, 0); /* Param Order: Hours, Minutes, Seconds, Milliseconds */
         var endTimeDate = new Date();
        endTimeDate.setHours(15, 30, 0, 0); /* Param Order: Hours, Minutes, Seconds, Milliseconds */
        var startTime = '';
        var endTime = '';
        if(v === 'full') {
            startTime = startDate;
            endTime = endDate;
        } else {
            if (now >= startDate && now <= endDate) {
                startTime = browser.subtractMinutes(now, v);
                endTime = new Date();
            } else {
                startTime = browser.subtractMinutes(endDate, v);
                endTime = endTimeDate;
            }
        }
        
       
        $('input[name=start_time]').val((startTime.getHours()<10?'0':'') + ""+ startTime.getHours() + ":" + (startTime.getMinutes()<10?'0':'') + ""+ startTime.getMinutes());
        $('input[name=end_time]').val((endTime.getHours()<10?'0':'') + ""+ endTime.getHours() + ":" + (endTime.getMinutes()<10?'0':'') + ""+ endTime.getMinutes());
      browser.getHistoryData();
    });

    $('body').on('change', '#customer-stateid', function () {
        var el = $(this), id = el.val();
        $.ajax({
            url: '/get-city',
            type: "post",
            data: { id: id },
            success: function (data) {
                $('#customer-cityid').html(data);
                if ($('#customer-cityid').attr('data-attr') !== undefined) {
                    var v = $('#customer-cityid').attr('data-attr');
                    $('#customer-cityid').val(v).trigger('change');
                    $('#customer-cityid').removeAttr('data-attr');
                }
            },
            error: function () {
                alertify.error("We are unable toget data");
            }
        });
    });

    $('body').on('change', '.historical_deropdown_select', function () {
        var el = $(this), v = el.val(), type = $('.fii_dii_get_data.active').attr('data-type');
        $.ajax({
            url: '/get-fii-historical',
            type: "post",
            dataType: "JSON",
            data: { val: v, type: type },
            success: function (data) {
                browser.fiiDiiChart.updateOptions({
                    series: data.result,
                    xaxis: { text: type, categories: data.cat }
                });
            }
        });
    });

    $('body').on('change', 'input[name=market_stocks_type]', function () {
        
        var el = $(this), types = el.val(), cap = $('.market_cap:checked').val();
        $('.market_pluse_dashboard').addClass('loading');
        $.ajax({
            url: '/get-market-pulse',
            type: "post",
            dataType: "JSON",
            data: { types: types, cap: cap },
            success: function (data) {
               $('.custom_table_data').DataTable().destroy();
                $('.pre_market_data').html(data.pre_market_data);
                browser.topGainerChart.updateOptions({
                    series: [{ data: data.gainers_prices }],
                    xaxis: { categories: data.top_gainers_cat }
                });
                browser.topLosersChart.updateOptions({
                    series: [{ data: data.losers_prices }],
                    xaxis: { categories: data.top_losers_cat }
                });
                $('.market_pluse_dashboard').removeClass('loading');
                $('.custom_table_data').DataTable({language: { search: '', searchPlaceholder: "Search..." }}).draw();
            }
        });

        var cap = $('.market_sheet_cap:checked').val();
        $.ajax({
            url: '/get-market-pulse',
            type: "post",
            dataType: "JSON",
            data: { types: types, cap: cap },
            success: function (data) {
                $('.custom_table_data').DataTable().destroy();
                $('.market_cheat_sheet').html(data.market_cheat_sheet);
                $('.custom_table_data').DataTable({language: { search: '', searchPlaceholder: "Search..." }}).draw();
                //$('.dataTables_filter').prepend($('.cheat_sheet_radio').clone());
            }
        });
    });

    $('body').on('change', '.market_cap', function () {
        var el = $(this), cap = el.val(), types = $('.stocks_type:checked').val();
        el.attr('checked', 'checked');
        $.ajax({
            url: '/get-market-pulse',
            type: "post",
            dataType: "JSON",
            data: { types: types, cap: cap },
            success: function (data) {
                $('.custom_table_data').DataTable().destroy();
                $('.pre_market_data').html(data.pre_market_data);
                 $('.custom_table_data').DataTable({language: { search: '', searchPlaceholder: "Search..." }}).draw();
                 browser.topGainerChart.updateOptions({
                    series: [{ data: data.gainers_prices }],
                    xaxis: { categories: data.top_gainers_cat }
                });
                 browser.topLosersChart.updateOptions({
                    series: [{ data: data.losers_prices }],
                    xaxis: { categories: data.top_losers_cat }
                });
            }
        });
    });


    $('body').on('change', '.market_sheet_cap', function () {
        var el = $(this), cap = el.val(), types = $('.stocks_type:checked').val();
        el.attr('checked', 'checked');
        $.ajax({
            url: '/get-market-pulse',
            type: "post",
            dataType: "JSON",
            data: { types: types, cap: cap },
            success: function (data) {
                $('.custom_table_data').DataTable().destroy();
                $('.market_cheat_sheet').html(data.market_cheat_sheet);
                 $('.custom_table_data').DataTable({language: { search: '', searchPlaceholder: "Search..." }}).draw();
                ///$('.dataTables_filter').append($('.cheat_sheet_radio').clone());
            }
        });
    });

    $('body').on('change', '.market_sheet_cap', function () {
        var el = $(this), cap = el.val(), types = $('.stocks_type:checked').val();
        el.attr('checked', 'checked');
        $.ajax({
            url: '/get-market-pulse',
            type: "post",
            dataType: "JSON",
            data: { types: types, cap: cap },
            success: function (data) {
                $('.custom_table_data').DataTable().destroy();
                $('.market_cheat_sheet').html(data.market_cheat_sheet);
                 $('.custom_table_data').DataTable({language: { search: '', searchPlaceholder: "Search..." }}).draw();
                ///$('.dataTables_filter').append($('.cheat_sheet_radio').clone());
            }
        });
    });

    $('body').on('click', '.fii_dii_get_data', function (e) {
        e.preventDefault();
        var el = $(this), v = $('.historical_deropdown_select').val();
        $('.fii_dii_get_data').removeClass('active');
        el.addClass('active');
        $.ajax({
            url: '/get-fii-historical',
            type: "post",
            dataType: "JSON",
            data: { val: v, type: el.attr('data-type') },
            success: function (data) {
                browser.fiiDiiChart.updateOptions({
                    series: data.result,
                    xaxis: { text: el.attr('data-type'), categories: data.cat }
                });
            }
        });
    });


    $('body').on('change', '#customer-countryid', function () {
        var el = $(this), id = el.val();
        $.ajax({
            url: '/get-state',
            type: "post",
            data: { id: id },
            success: function (data) {
                $('#customer-stateid').html(data);
                if ($('#customer-stateid').attr('data-attr') !== undefined) {
                    var v = $('#customer-stateid').attr('data-attr');
                    $('#customer-stateid').val(v).trigger('change');
                    $('#customer-stateid').removeAttr('data-attr');
                }
            },
            error: function () {
                alertify.error("We are unable toget data");
            }
        });
    });

    //Clone Header for Sticky
    var header = $('.header').clone().addClass('sticky');
    header.prependTo('body');
    $('.header').addClass('visi_hidd');
    $('.header.sticky').removeClass('visi_hidd');


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