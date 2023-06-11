$(function () {
    $('body').on('click', 'a[data-scroll]', function (e) {
        e.preventDefault();
        var el = $(this),
            sel = el.data('scroll');
        $('html, body').animate({
            'scrollTop': $(sel).offset().top - $(".header").outerHeight() - 30
        }, 1000);
    });
    /**********************
     SEARCH BAR
     **********************/
    $('body').on('click', 'a', function (e) {
        e.stopPropagation();
    });

    $('body').on('click', '.panel_left_button', function (e) {
        e.stopPropagation();
        $('body').toggleClass('panel_left_bar')
    });

    $('body').on('click', '.options a.fa-search, .search-bar a.fa-arrow-left', function () {
        $('html').toggleClass('has-search');
    });
    $('body').on('click', '.search-bar a.fa-search', function () {
        $('.search-form form').submit();
    });
    $('body').on('click', '.search-bar a.fa-refresh', function () {
        $('.search-form input[type="text"], .search-form select').val('');
    });

    /**********************
     SORTING
     **********************/
    $('body').on('click', '.options a.fa-reorder', function (e) {
        e.preventDefault();
        sort.init('.table tbody');
        $('html').addClass('has-sort');
    });


    $('body').on('click', '.option_current_date_clear', function (e) {
        $('#option_current_date').val('');
        page.getOptionChain();
    });


    page.load();
    page.table();

    if ($('.nifty_data').length) {
        page.getNiftyExpiryDate();
        setInterval(function () {
            page.getRealDatas();
        }, 60 * 1000);
    }

    if ($('.option_chain').length) {
        setInterval(function () {
            console.log('setInterval');
            page.getOptionChain();
        }, 60 * 1000);
    }

    $('body').on('change', '#option_expiry_date,#option_options_minute, #option_options_contracts, #from_strike_price, #to_strike_price, #option_current_date', function () {
        page.getOptionChain();
    });

    if ($('#chart').length) {
        page.getCandleStikeChart();
    }

    $('body').on('change', '#expiry_date, #options_contracts', function () {
        page.getRealDatas();
    });
});

//Page functions
var page = {
    upload_object: {}, dropdowns: {}, timer: 0, ceChart: false, peChart: false,
    saveTimer: 0,
    getNiftyExpiryDate: function () {
        $.ajax({
            url: '/admin/refresh/get-expiry-date',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                var option = '<option value="">Please select</option>';
                if (data?.expiryDetailsDto?.expiryDates) {
                    $.each(data?.expiryDetailsDto?.expiryDates, function (index, value) {
                        option += '<option value="' + value + '">' + value + '</option>';
                    });
                    $('#expiry_date').html(option);
                }
            }, error: function () {
                alert('Error in form');
            },
            complete: function () {
            }
        });
    },
    getRealDatas: function () {
        var url = $('.nifty_data').attr('data-url');
        var options = $('#options_contracts').val();
        var expiry_date = $('#expiry_date').val();
        if (expiry_date !== '' && options !== '') {
            $.ajax({
                url: '/admin/refresh/get-nifty',
                type: 'POST',
                dataType: 'json',
                data: { expiry_date: expiry_date, options: options },
                success: function (data) {

                }, error: function () {
                    alert('Error in form');
                },
                complete: function () {
                }
            });
        }
    },
    getOptionChain: function () {
        var options = $('#option_options_contracts').val(),
            current_date = $('#option_current_date').val(),
            from_strike_price = $('#from_strike_price').val(),
            to_strike_price = $('#to_strike_price').val(),
            option_options_minute = $('#option_options_minute').val(),
            expiry_date = $('#option_expiry_date').val();
        if (options !== '' && from_strike_price !== '' && to_strike_price !== '' && expiry_date !== '') {
            $.ajax({
                url: '/admin/option-chain/get-data',
                type: 'POST',
                dataType: 'json',
                data: { expiry_date: expiry_date, options: options, to_strike_price: to_strike_price, from_strike_price: from_strike_price, current_date: current_date, min: option_options_minute },
                success: function (data) {
                    if ($('#chart').length) {
                        var rData = [];
                        var rDataPe = [];
                        $.each(data.chart[from_strike_price], function (key, value) {
                            var close_ce_oi = typeof (data.chart[from_strike_price][key + 1]) != "undefined" ? data.chart[from_strike_price][key + 1].ce_oi : value.ce_oi;
                            rData.push({
                                x: value.date_format,
                                y: [value.ce_oi, close_ce_oi, value.ce_oi, close_ce_oi]
                            });

                            var close_pe_oi = typeof (data.chart[from_strike_price][key + 1]) != "undefined" ? data.chart[from_strike_price][key + 1].pe_oi : value.pe_oi;
                            rDataPe.push({
                                x: value.date_format,
                                y: [value.pe_oi, close_pe_oi, value.pe_oi, close_pe_oi]
                            })
                        });
                        page.ceChart.updateSeries([{
                            data: rData
                        }]);
                        page.peChart.updateSeries([{
                            data: rDataPe
                        }])
                    } else {
                        $('.custom_option_headers').html(data.header);
                        $('.custom_option_body').html(data.body);
                    }
                }, error: function () {
                    alert('Error in form');
                },
                complete: function () {
                }
            });
        }
    },
    getCandleStikeChart: function () {
        var options = {
            chart: {
                type: 'candlestick',
                height: 350
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    const o = w.globals.seriesCandleO[seriesIndex][dataPointIndex];
                    const h = w.globals.seriesCandleH[seriesIndex][dataPointIndex];
                    const diff = (h - o);
                    let text = "Open: " + o + "<br>";
                    text += "Close: " + h + "<br>";
                    text += "Difference: " + diff + "<br>";
                    return text;
                }
            },
            series: [],
            title: {
                text: 'CE Changes',
            },
            noData: {
                text: 'Loading...'
            }
        };

        page.ceChart = new ApexCharts(document.querySelector("#chart"), options);
        page.ceChart.render();
        options.title.text = 'PE Changes';
        page.peChart = new ApexCharts(document.querySelector("#chart_pe"), options);
        page.peChart.render();
    }
};
//Sorting plugin
var sort = {
    cache: '', init: function (selector) {
        this.cache = $(selector).html();
        $(selector).each(function () {
            $(this).sortable({
                placeholder: "drop-placeholder",
                revert: true, start: function (e, ui) {
                    ui.placeholder.width(ui.helper.width());
                }
            });
        });
    },
    reset: function (selector) {
        $(selector).html(this.cache);
        this.cache = '';
    },
    destroy: function (selector) {
        $(selector).sortable("destroy");
    },
    save: function (el, selector) {
        serial = $(selector).sortable("serialize", {
            key: "items[]",
            attribute: "data-sort"
        });
        $.ajax({
            url: el.href,
            type: "post", data: serial, success: function () {
                sort.destroy(selector);
                $('html').removeClass('has-sort');
                alertify.success("The order was saved successfully.");
            },
            error: function () {
                sort.destroy(selector);
                alertify.error("We are unable to set the sort order at this time.  Please try again in a few minutes.");
            }
        });
    }
};