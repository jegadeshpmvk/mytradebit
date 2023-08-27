// Create cross browser requestAnimationFrame method:
window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame || function (f) {
    setTimeout(f, 1000 / 60)
};

//Page functions
var browser = {
    _csrf: null,
    _width: 0,
    _height: 0,
    _header_height: 0,
    _filter_position: 0,
    _position: 0,
    _odometerElements: [],
    fiiCashChart: false,
    diiCashChart: false,
    fiiDiiChart: false,
    topGainer: false,
    topLosers: false,
    netOIChart: false,
    OIChangeChart: false,
    totalOpenChart: false,
    upload_object: {},
    setup: function (init) {
        this._width = $(window).width();
        this._height = $(window).height();
        this._header_height = $('.viewport .header').outerHeight();

        if (init === 1) {
            //Assign csrf
            this._csrf = $('meta[name="csrf-token"]').attr("content");

            // Redirect page
            common.makeTargets();
            browser.addUrlBody();
            //Load all images
            $('body').MCLoadImages({
                attribute: 'data-src',
                onSuccess: function (source, element) {
                    var imageTag = $(element),
                        bgImage = imageTag.closest('.bsz');
                    if (bgImage.length) {
                        bgImage.find('.bgimage').css('background-image', 'url("' + source + '")');
                        bgImage.removeClass('loading');
                    }
                    element.src = source;
                    imageTag.removeAttr('data-src');
                }
            });

            if ($('#customer-countryid').length) {
                var v = $('#customer-countryid').attr('data-attr');
                $('#customer-countryid').val(v).trigger('change');
            }

            //Contact People Scroll
            browser.scrollPage(window.location.href);

            //init the slider
            browser.initSlider();
            common.adjustMinHeight();
            if ($('#fii_cash_chart').length) {
                browser.cashSentimentChat();
            }

            if ($('#pre_market').length) {
                browser.preMarket();
            }
            if ($('#historical_Data').length) {
                browser.historicalData();
            }

            if ($('.custom_table_data').length) {
                browser.fillDilTable();
            }


            if ($('#top_gaiers').length) {
                browser.topGainer()
            }

            if ($('#top_losers').length) {
                browser.topLosers()
            }

            if ($('#net_OI').length) {
                browser.netOI();
            }

            if ($('#OI_change').length) {
                browser.OIChange();
            }

            if ($('#total_open').length) {
                browser.totalOpenInterest();
            }

            if ($('#gaugeChart').length) {
                browser.gaugeChart();
            }

            if ($(".trade_date_datepicker")) {
                $(".trade_date_datepicker").datepicker({ maxDate: new Date() });
            }

            if ($(".expiry_date_datepicker")) {
                $(".expiry_date_datepicker").datepicker({
                    beforeShowDay: function (date) {
                        var day = date.getDay();
                        return [day == 4, ""];
                    }
                });
            }

            if ($('.options_board').length) {
                browser.getHistoryData();
            }
        }

    },
    scrollEvent: function (init) {
        requestAnimationFrame(function () {
            //Add class for menu bar
            var st = $(window).scrollTop();

            //Show sticky
            if (st > browser._header_height)
                $('html').addClass('has-scrolled');
            else
                $('html').removeClass('has-scrolled');

            //Pause or play Slideshows based on visibility
            browser.playVisibleEvents();

        });
    },
    pauseAllIntensiveEvents: function () {
    },
    playVisibleEvents: function () {
    },
    getParams: function (key, default_, target) {
        if (default_ == null)
            default_ = "";
        key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regex = new RegExp("[\\?&]" + key + "=([^&#]*)");
        var qs = regex.exec(target);
        if (qs == null)
            return default_;
        else
            return qs[1];
    },
    scrollPage: function (target) {
        setTimeout(function () {
            var g = browser.getParams('g', '', target);
            var o = browser.getParams('o', '', target);
            var offHei = $('.sticky').innerHeight();
            console.log(offHei);
            if (offHei === undefined) {
                offHei = 0;
            }
            if (g != "") {
                $('html, body').animate({
                    scrollTop: $("#" + g).offset().top - offHei
                }, 1000);
            }
            if (o != "") {
                $('.tab[data-tab=' + o).click();
            }
        }, 100);
    },
    addUrlBody: function () {
        var url = $('.all_pages').attr('data-url');
        $('body').addClass(url);
    },
    initSlider: function () {
        if ($('.how_works').length) {
            var worksCarousel = new Swiper('.how_works .swiper-container', {
                slidesPerView: 4,
                slidesPerColumn: 1,
                spaceBetween: 30,
                speed: 1000,
                loop: false,
                navigation: {
                    nextEl: '.how_works .nav.right',
                    prevEl: '.how_works .nav.left'
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                }
            });
        }

        if ($('.testmonials').length) {
            var testmonialsCarousel = new Swiper('.testmonials .swiper-container', {
                slidesPerView: 1,
                spaceBetween: 10,
                speed: 1000,
                effect: 'fade',
                loop: false,
                navigation: {
                    nextEl: '.testmonials .testi_btn_next',
                    prevEl: '.testmonials .testi_btn_prev'
                }
            });
        }

        if ($('.fill_dil_slider').length) {
            var fillDillCarousel = new Swiper('.fill_dil_slider .swiper-container', {
                slidesPerView: 5,
                spaceBetween: 15,
                loop: false,
                navigation: {
                    nextEl: '.fill_dil_slider .fill_btn_prev',
                    prevEl: '.fill_dil_slider .fill_btn_next'
                }
            });
        }

    },
    cashSentimentChat: function () {
        var options = {
            series: [{
                data: JSON.parse($('#fii_cash_chart').attr('data-details'))
            }],
            chart: {
                height: 470,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            colors: [function ({ value, seriesIndex, w }) {
                if (value > 0) {
                    return '#4CAB02'
                } else {
                    return '#C90404'
                }
            }, function ({ value, seriesIndex, w }) {
                if (value > 0) {
                    return '#4CAB02'
                } else {
                    return '#C90404'
                }
            }],
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: ['Fii', 'Dii'],

            },
            yaxis: {
                title: {
                    text: '',
                },
                labels: {
                    formatter: function (val, index) {
                        return common.numDifferentiation(val);
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                x: {
                    //show: true
                },
                y: {
                    title: {
                        formatter: function () {
                            return ''
                        }
                    }
                }
            },
        };
        this.fiiCashChart = new ApexCharts(document.querySelector("#fii_cash_chart"), options);
        this.fiiCashChart.render();
        // let fii = $("#fii_cash_chart").attr('data-fii');
        // let dii = $("#dii_cash_chart").attr('data-dii');
        // let amount = $("#fii_cash_chart").attr('data-amount');
        // let f_percenatge = (fii / 100) * amount;
        // let d_percenatge = (dii / 100) * amount;
        // this.fiiCashChart.updateOptions({
        //     series: [f_percenatge],
        //     labels: ['FII Cash Data - BUY'],
        // });

        // this.diiCashChart = new ApexCharts(document.querySelector("#dii_cash_chart"), options);
        // this.diiCashChart.render();
        // this.diiCashChart.updateOptions({
        //     series: [d_percenatge],
        //     labels: ['DII Cash Data - BUY'],
        // });
    },
    preMarket: function () {
        var options = {
            series: [{
                data: JSON.parse($('#pre_market').attr('data-open'))
            }, {
                data: JSON.parse($('#pre_market').attr('data-percentChange'))
            }],
            chart: {
                type: 'bar',
                height: 430,
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            legends: {
                show: false,
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            tooltip: {
                theme: 'dark',
                x: {
                    //show: true
                },
                y: {
                    title: {
                        formatter: function (value) {
                            return '';
                        }
                    }
                }
            },
            xaxis: {
                categories: JSON.parse($('#pre_market').attr('data-cat')),
            },
            yaxis: {

                labels: {
                    minWidth: 90,
                    formatter: (val) => { return val === 'NIFTY FINANCIAL SERVICES' ? 'FINNIFTY' : val },
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#pre_market"), options);
        chart.render();
    },
    historicalData: function () {
        var options = {
            series: [],
            chart: {
                type: 'line',
                height: 350
            },
            stroke: {
                show: false,
            },
            colors: [function ({ value, seriesIndex, w }) {
                if (value > 0) {
                    return '#4CAB02'
                } else {
                    return '#C90404'
                }
            }, function ({ value, seriesIndex, w }) {
                if (value > 0) {
                    return '#4CAB02'
                } else {
                    return '#C90404'
                }
            }],
            dataLabels: {
                enabled: false,
            },
            yaxis: {
                title: {
                    text: '',
                },
                labels: {
                    formatter: function (val, index) {
                        return common.numDifferentiation(val);
                    }
                }
            },
            xaxis: {
                categories: [],
            },
            legend: {
                show: false,
                position: 'top',
                horizontalAlign: 'center'
            },
            noData: {
                text: 'No Data Found'
            }
        };
        this.fiiDiiChart = new ApexCharts(document.querySelector("#historical_Data"), options);
        this.fiiDiiChart.render();
        this.fiiDiiChart.updateOptions({
            series: JSON.parse($('.fill_dil_slider').attr('data-slider')),
            xaxis: { text: 'Stocks', categories: JSON.parse($('.fill_dil_slider').attr('data-cat')) }
        });
    },
    optionsBorad: function () {
        var options = {
            series: [],
            chart: {
                type: 'bar',
                height: 450,
                toolbar: {
                    show: false,
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -35,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            colors: ['#62D168', '#E96767'],
            dataLabels: {
                enabled: false
            },
            title: {
                style: {
                    fontSize: 14,
                    color: "#000",
                    fontWeight: 600,
                    fontFamily: 'Manrope'
                }
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: [],
            },
            yaxis: {
                show: false,
                title: {
                    text: '',
                    style: {
                        fontSize: 14,
                        color: "#000",
                        fontWeight: 600,
                        fontFamily: 'Manrope'
                    }
                },

            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return ""
                    }
                }
            }
        };;
        return options;
    },
    netOI: function () {
        this.netOIChart = new ApexCharts(document.querySelector("#net_OI"), this.optionsBorad());
        this.netOIChart.render();
        this.netOIChart.updateOptions({
            series: [{
                data: [44, 0]
            }, {
                data: [0, 55]
            }],
            title: {
                text: 'Net OI',
            },
            legend: { fontSize: '0px', customLegendItems: ['', ''] },
            xaxis: { text: '', categories: ["Put OI", "Call OI"] }
        });
    },
    OIChange: function () {
        this.netOIChart = new ApexCharts(document.querySelector("#OI_change"), this.optionsBorad());
        this.netOIChart.render();
        this.netOIChart.render();
        console.log(JSON.parse($('#OI_change').attr('data-put')));
        this.netOIChart.updateOptions({
            series: [{
                name: 'Put OI Change',
                data: JSON.parse($('#OI_change').attr('data-put'))
            }, {
                name: 'Call OI Change',
                data: JSON.parse($('#OI_change').attr('data-call'))
            }],
            title: {
                text: 'OI Change - 22 Jun Expiry',
            },
            xaxis: { text: '', categories: JSON.parse($('#OI_change').attr('data-cat')) }
        });
    },
    totalOpenInterest: function () {
        this.totalOpenChart = new ApexCharts(document.querySelector("#total_open"), this.optionsBorad());
        this.totalOpenChart.render();
        this.totalOpenChart.render();
        this.totalOpenChart.updateOptions({
            series: [{
                name: 'Total Put OI',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
                name: 'Total Call OI',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }],
            title: {
                text: 'Total Open Interest - 22 Jun Expiry',
            },
            yaxis: {
                show: true,
                title: {
                    text: 'Call/Put OI',
                    style: {
                        fontSize: 14,
                        color: "#000",
                        fontWeight: 600,
                        fontFamily: 'Manrope'
                    }
                },

            },
            xaxis: { text: '', categories: [1700, 1750, 1800, 1850, 1900, 1950, 2000, 2050, 2100] }
        });
    },
    gaugeChart: function () {
        var ctx = document.getElementById('gaugeChart').getContext('2d');
        new Chart(ctx, {
            type: 'gauge',
            data: {
                labels: ["Normal", "Warning", "Critical"],
                datasets: [
                    {
                        label: "Current Appeal Risk",
                        data: [40, 70, 100],
                        value: 76,
                        minValue: 0,
                        backgroundColor: ["green", "orange", "red"],
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    align: 'start',
                    text: 'Options Sentiment',
                    font: {
                        size: 14,
                        family: 'Manrope',
                        weight: 600,
                        color: "#000",
                    }
                },
                layout: {
                    padding: {
                        bottom: 30
                    }
                },
                needle: {
                    // Needle circle radius as the percentage of the chart area width
                    radiusPercentage: 2,
                    // Needle width as the percentage of the chart area width
                    widthPercentage: 3.2,
                    // Needle length as the percentage of the interval between inner radius (0%) and outer radius (100%) of the arc
                    lengthPercentage: 80,
                    // The color of the needle
                    color: 'rgba(0, 0, 0, 1)'
                },
                valueLabel: {
                    formatter: Math.round
                }
            }
        });
    },
    fillDilTable: function () {
        new DataTable('.custom_table_data', {
            "iDisplayLength": 50,
        });
    },
    topGainer: function () {
        var options = {
            series: [{
                data: JSON.parse($("#top_gaiers").attr('data-prices'))
            }],
            chart: {
                type: 'bar',
                width: "100%",
                height: 390,
                toolbar: {
                    show: false,
                },
                offsetX: -10
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
                '#f48024', '#69d2e7'
            ],
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff']
                },
                formatter: function (val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                },
                offsetX: 0,
                dropShadow: {
                    enabled: false
                }
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: JSON.parse($("#top_gaiers").attr('data-categories')),
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            title: {
                show: false
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: 'dark',
                x: {
                    //show: true
                },
                y: {
                    title: {
                        formatter: function () {
                            return ''
                        }
                    }
                }
            },
            noData: {
                text: 'No Data Found'
            }
        };
        this.topGainer = new ApexCharts(document.querySelector("#top_gaiers"), options);
        this.topGainer.render();
    },
    topLosers: function () {
        var options = {
            series: [{
                data: JSON.parse($("#top_losers").attr('data-prices'))
            }],
            chart: {
                type: 'bar',
                width: "100%",
                height: 390,
                offsetX: 10,
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
                '#f48024', '#69d2e7'
            ],
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff']
                },
                formatter: function (val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                },
                offsetX: 0,
                dropShadow: {
                    enabled: false
                }
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: JSON.parse($("#top_losers").attr('data-categories'))
            },
            yaxis: {
                reversed: true,
                labels: {
                    show: false
                }
            },
            title: {
                show: false
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: 'dark',
                x: {
                    // show: false
                },
                y: {
                    title: {
                        formatter: function () {
                            return ''
                        }
                    }
                }
            },
            noData: {
                text: 'No Data Found'
            }
        };
        this.topLosers = new ApexCharts(document.querySelector("#top_losers"), options);
        this.topLosers.render();
    },
    getHistoryData: function () {
        var stocks_type = $('input[name=stocks_type]').val(),
            start_time = $('input[name=start_time]').val(),
            end_time = $('input[name=end_time]').val(),
            expiry_date = $('input[name=expiry_date]').val(),
            trade_date = $('input[name=trade_date]').val(),
            min = $('input[name=minutes]').val(),
            from_stike_price = $('input[name=from_stike_price]').val(),
            to_stike_price = $('input[name=to_stike_price]').val();

        if (stocks_type !== '' && start_time !== '' && end_time !== '' && expiry_date !== '' && trade_date !== '') {
            $.ajax({
                url: '/options-board-data',
                type: "post",
                dataType: "JSON",
                data: {
                    stocks_type: stocks_type, start_time: start_time, end_time: end_time, expiry_date, expiry_date,
                    trade_date: trade_date, min: min, from_stike_price: from_stike_price, to_stike_price: to_stike_price
                },
                success: function (data) {
                    console.log(data.options_scope);
                    $('.options_scope').html(data.options_scope);
                    $('.net_oi').html(data.net_oi);
                    $('.options_sentiment').html(data.options_sentiment);
                    browser.gaugeChart();
                    browser.netOI();
                    browser.OIChange();
                    //$('.custom_table_data').DataTable().draw();
                }
            });
        }
    }
};


var common = {
    makeTargets: function () {
        $("a[href^=http]").each(function () {
            if (this.href.indexOf(location.hostname) === -1)
                $(this).attr('target', "_blank");
        });
    },
    adjustMinHeight: function () {
        var arrMinHei = ['.content-equal-heights', '.fill_common_title'];
        $.each(arrMinHei, function (index, value) {
            if ($(value).length)
                $(value).css('height', 'auto').equalHeights();
        });
    },
    numDifferentiation: function (value) {
        const val = Math.abs(value)
        if (val >= 10000000) return `${parseFloat(value / 10000000).toFixed(2)} Cr`
        if (val >= 100000) return `${parseFloat(value / 100000).toFixed(2)} L`
        if (val >= 1000) return `${parseFloat(value / 1000).toFixed(2)} K`
        return value;
    }
};
