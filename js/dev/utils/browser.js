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
    topGainerChart: false,
    topLosersChart: false,
    netOIChart: false,
    OIChangeChart: false,
    totalOpenChart: false,
    futureBoardChart: false,
    upload_object: {},
    dates: {},
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

            if ($('.fill_table_data').length) {
                browser.fillDilTable();
            }

            if ($('.custom_table_data').length) {
                browser.customTableData();
            }
            
            if($('#heatMap').length) {
                browser.customHeatMap();
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
                $(".trade_date_datepicker").datepicker({ dateFormat: 'yy-mm-dd', maxDate: new Date() });
            }

            if ($('.futures_board').length) {
                browser.getFuturesData();
            }

            if ($('.expiry_date_datepicker').length) {
                browser.dates = JSON.parse($('.expiry_date_datepicker').attr('data-expirydate'));
                $(".expiry_date_datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    beforeShowDay: function (date) {

                        return browser.availableDates(date);
                    }
                });
            }

            if ($('#slider-range').length) {
                browser.timeRangeSlider();
            }

            if ($('.options_board').length) {
                var strike_price = $('input[name=stocks_type]:checked').attr('data-value');
                $('input[name=to_strike_price]').val(parseFloat(strike_price) + parseFloat(500));
                $('input[name=from_strike_price]').val(parseFloat(strike_price) - parseFloat(500));
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
    availableDates: function (date) {
        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
        console.log(browser.dates);
        console.log(dmy);
        if ($.inArray(dmy, browser.dates) != -1) {
            return [true, "", "Available"];
        } else {
            return [false, "", "unAvailable"];
        }
    },
    pauseAllIntensiveEvents: function () {
    },
    playVisibleEvents: function () {
    },
    getParams: function (key, default_, target) {
        if (default_ === null)
            default_ = "";
        key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regex = new RegExp("[\\?&]" + key + "=([^&#]*)");
        var qs = regex.exec(target);
        if (qs === null)
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
                height: 450,
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
                categories: ['FII', 'DII'],
crosshairs: {
                  show: false
                }
            },
            yaxis: {
                title: {
                    text: '',
                },
                labels: {
                    formatter: function (val, index) {
                        return common.numDifferentiation(val);
                    }
                },
                crosshairs: {
                  show: false
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
                name: "Pre Market",
                data: JSON.parse($('#pre_market').attr('data-open'))
            }, {
                name: "Live Market",
                data: JSON.parse($('#pre_market').attr('data-percentChange'))
            }],
            chart: {
                type: 'bar',
                height: 470,
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
                },
                background: {
                    padding: 4,
                }
            },
            legend: {
                show: true,
                horizontalAlign: 'right',
                offsetX: "-500px",
                itemMargin: {
                    horizontal: 15,
                    vertical: 0
                },
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
                labels: {
                    rotate: -45,
                    rotateAlways: true,
                },
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
            noData: {
                text: 'No data found',
                align: 'center',
                verticalAlign: 'middle',
                offsetX: 0,
                offsetY: 0,
                style: {
                    color: undefined,
                    fontSize: '14px',
                    fontFamily: undefined
                }
            },
            tooltip: {
                enabled: true,
                custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                    return '<div class="arrow_box">' +
                        '<div class="arrow_box_header">' + w.globals.labels[dataPointIndex] + '</div>' +
                        '<div class="arrow_box_body"><div class="arrow_box_body_text"><span>Call</span><span>' + series[1][dataPointIndex] + '</span></div><div class="arrow_box_body_text"><span>Put</span><span>' + series[0][dataPointIndex] + '</span></div>' +
                        '</div>';
                }
            }
        };
        return options;
    },
    netOI: function () {
        this.netOIChart = new ApexCharts(document.querySelector("#net_OI"), this.optionsBorad());
        this.netOIChart.render();
        this.netOIChart.updateOptions({
            series: [{
                data: [$('#net_OI').attr('data-put'), 0]
            }, {
                data: [0, $('#net_OI').attr('data-call')]
            }],
            title: {
                text: 'Net OI',
            },
            tooltip: {
                enabled: true,
                custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                    console.log(dataPointIndex);
                    return '<div class="arrow_box">' +
                        '<div class="arrow_box_header">' + w.globals.labels[dataPointIndex] + '</div>' +
                        '<div class="arrow_box_body"><div class="arrow_box_body_text"><span>' + (dataPointIndex === 1 ? 'Call' : 'Put') + '</span><span>' + (dataPointIndex === 1 ? series[1][dataPointIndex] : series[0][dataPointIndex]) + '</span></div>' +
                        '</div>';
                }
            },
            legend: { fontSize: '0px', customLegendItems: ['', ''] },
            xaxis: { text: '', categories: ["Put OI", "Call OI"] }
        });
    },
    OIChange: function () {
        this.netOIChart = new ApexCharts(document.querySelector("#OI_change"), this.optionsBorad());
        this.netOIChart.render();
        this.netOIChart.render();
        this.netOIChart.updateOptions({
            series: [{
                name: 'Put OI Change',
                data: JSON.parse($('#OI_change').attr('data-put'))
            }, {
                name: 'Call OI Change',
                data: JSON.parse($('#OI_change').attr('data-call'))
            }],
            title: {
                text: 'OI Change - ' + $('#OI_change').attr('data-date'),
            },
            yaxis: {
                show: true,
            },
            tooltip: {
                enabled: true,
                custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                    return '<div class="arrow_box">' +
                        '<div class="arrow_box_header">' + w.globals.labels[dataPointIndex] + '</div>' +
                        '<div class="arrow_box_body"><div class="arrow_box_body_text"><span>Call</span><span>' + series[1][dataPointIndex] + '</span></div><div class="arrow_box_body_text"><span>Put</span><span>' + series[0][dataPointIndex] + '</span></div>' +
                        '</div>';
                }
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
                data: JSON.parse($('#total_open').attr('data-put'))
            }, {
                name: 'Total Call OI',
                data: JSON.parse($('#total_open').attr('data-call'))
            }],
            title: {
                text: 'Total Open Interest - ' + $('#total_open').attr('data-date'),
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
            tooltip: {
                enabled: true,
                custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                    return '<div class="arrow_box">' +
                        '<div class="arrow_box_header">' + w.globals.labels[dataPointIndex] + '</div>' +
                        '<div class="arrow_box_body"><div class="arrow_box_body_text"><span>Call</span><span>' + series[1][dataPointIndex] + '</span></div><div class="arrow_box_body_text"><span>Put</span><span>' + series[0][dataPointIndex] + '</span></div>' +
                        '</div>';
                }
            },
            xaxis: { text: '', categories: JSON.parse($('#total_open').attr('data-cat')) }
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
                        data: [0, 1, 2],
                        value: Math.floor($("#gaugeChart").attr('data-chart')),
                        minValue: -1,
                        backgroundColor: ["red", "orange", "green"],
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
        new DataTable('.fill_table_data', {
            fixedHeader: true,
            order: [[0, "desc"]], //or asc 
            language: { search: '', searchPlaceholder: "Search..." },
        });
    },
    customTableData: function () {
        new DataTable('.custom_table_data', {
            order: [[0, "asc"]], //or asc 
            language: { search: '', searchPlaceholder: "Search..." },
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
        this.topGainerChart = new ApexCharts(document.querySelector("#top_gaiers"), options);
        this.topGainerChart.render();
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
        this.topLosersChart = new ApexCharts(document.querySelector("#top_losers"), options);
        this.topLosersChart.render();
    },
    getHistoryData: function () {
        var stocks_type = $('input[name=stocks_type]:checked').val(),
            start_time = $('input[name=start_time]').val(),
            end_time = $('input[name=end_time]').val(),
            expiry_date = $('input[name=expiry_date]').val(),
            trade_date = $('input[name=trade_date]').val(),
            min = $('input[name=minutes]').val(),
            from_strike_price = $('input[name=from_strike_price]').val(),
            to_strike_price = $('input[name=to_strike_price]').val();
        $('.options_board').addClass('loading');
        $('.options_sentiment').css('display', 'none');
        if (stocks_type !== '' && start_time !== '' && end_time !== '' && expiry_date !== '' && trade_date !== '') {
            $.ajax({
                url: '/options-board-data',
                type: "post",
                dataType: "JSON",
                data: {
                    stocks_type: stocks_type, start_time: start_time, end_time: end_time, expiry_date: expiry_date,
                    trade_date: trade_date, min: min, from_strike_price: from_strike_price, to_strike_price: to_strike_price
                },
                success: function (data) {
                    $('.custom_table_data').DataTable().destroy();
                    $('.options_sentiment').css('display', 'block');
                    $('.net_oi').html(data.net_oi);
                    $('.options_sentiment').html(data.options_sentiment);
                    $('.total_open').html(data.total_open);
                    $('.options_scope').html(data.options_scope);
                    browser.gaugeChart();
                    browser.netOI();
                    browser.OIChange();
                    browser.totalOpenInterest();
                    $('.custom_table_data').DataTable().draw();
                    $('.options_board').removeClass('loading');
                }
            });
        }
    },
    futureBoard: function () {
        var options = {
            series: [{
                name: 'Volume',
                type: 'column',
                data: $('#futures_board').attr('data-volume') !== '' ? JSON.parse($('#futures_board').attr('data-volume')) : []
            }, {
                name: 'Open Interest',
                type: 'column',
                data: $('#futures_board').attr('data-open_interest') !== '' ? JSON.parse($('#futures_board').attr('data-open_interest')) : []
            }, {
                name: 'LTP',
                type: 'line',
                data: $('#futures_board').attr('data-ltp') !== '' ? JSON.parse($('#futures_board').attr('data-ltp')) : []
            }],
            chart: {
                height: 450,
                type: 'line',
                stacked: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [1, 1, 4]
            },
            title: {
                text: '',
                align: 'left',
                offsetX: 110
            },
            xaxis: {
                categories: $('#futures_board').attr('data-dates') !== '' ? JSON.parse($('#futures_board').attr('data-dates')) : []
            },
            yaxis: [
                {
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#008FFB'
                    },
                    labels: {
                        style: {
                            colors: '#008FFB',
                        }
                    },
                    title: {
                        //   text: "Income (thousand crores)",
                        text: "Volume",
                        style: {
                            color: '#008FFB',
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                {
                    seriesName: 'Income',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#00E396'
                    },
                    labels: {
                        style: {
                            colors: '#00E396',
                        }
                    },
                    title: {
                        //  text: "Operating Cashflow (thousand crores)",
                        text: "Open Interest",
                        style: {
                            color: '#00E396',
                        }
                    },
                    labels: {
                        formatter: function (value) {
                            return common.numDifferentiation(value);
                        }
                    },
                },
                {
                    seriesName: 'Revenue',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#FEB019'
                    },
                    labels: {
                        style: {
                            colors: '#FEB019',
                        },
                    },
                    title: {
                        //  text: "Revenue (thousand crores)",
                        text: "LTP",
                        style: {
                            color: '#FEB019',
                        }
                    }
                },
            ],
            tooltip: {
                fixed: {
                    enabled: true,
                    position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                    offsetY: 30,
                    offsetX: 60
                },
            },
            legend: {
                horizontalAlign: 'left',
                offsetX: 40
            },
            noData: {
                text: 'No data found',
                align: 'center',
                verticalAlign: 'middle',
                offsetX: 0,
                offsetY: 0,
                style: {
                    color: undefined,
                    fontSize: '14px',
                    fontFamily: undefined
                }
            }
        };
        this.futureBoardChart = new ApexCharts(document.querySelector("#futures_board"), options);
        this.futureBoardChart.render();
    },
    getFuturesData: function () {
        var stocks_type = $('input[name=future_stocks_type]:checked').val(),
            expiry_date = $('input[name=future_expiry_date]').val(),
            trade_date = $('input[name=future_trade_date]').val(),
            min = $('select[name=future_minutes]').val();

        if (expiry_date !== '' && trade_date !== '' && min !== '') {
            $.ajax({
                url: '/futures-board-data',
                type: "post",
                dataType: "JSON",
                data: {
                    stocks_type: stocks_type, expiry_date: expiry_date,
                    trade_date: trade_date, min: min
                },
                success: function (data) {
                    $('.futures_board_data').html(data.futures_board);
                    setTimeout(function () {
                        browser.futureBoard();
                    }, 100);
                }
            });
        }
    },
    subtractMinutes: function (date, minutes) {

        date.setMinutes(date.getMinutes() - minutes);
        console.log(date);
        return date;
    },
    subtractHours: function (date, hours) {
        date.setHours(date.getHours() - hours);
        return date;
    },
    timeRangeSlider: function () {
        $("#slider-range").slider({
            range: true,
            min: 555,
            max: 940,
            step: 5,
            values: [540, 1020],
            slide: function (e, ui) {
                var delay = function () {
                    var label = ui.handleIndex == 0 ? '#min' : '#max';
                    var val = browser.hoursMinutes(ui.values[ui.handleIndex]);
                    $(label).html(val).position({
                        my: 'center top',
                        at: 'center bottom',
                        of: ui.handle
                    });
                };
                // wait for the ui.handle to set its position
                setTimeout(delay, 5);
            },
            stop: function (event, ui) {
                $('input[name=start_time]').val(browser.hoursMinutes(ui.values[0]));
                $('input[name=end_time]').val(browser.hoursMinutes(ui.values[1]));
                browser.getHistoryData();
            }
        });

        var n = (940 - 555) / 15;

        var percent = 100 / n;
        console.log(percent);
        for (var x = 1; x < n; x++) {
            $(".ui-slider").append("<span class='dots' style='left:" + x * percent + "%'></span>");
        }

        $('#min').html(browser.hoursMinutes($('#slider-range').slider('values', 0))).position({
            my: 'center top',
            at: 'center bottom',
            of: $('#slider-range span:eq(0)'),
            offset: "0, 10"
        });

        $('#max').html(browser.hoursMinutes($('#slider-range').slider('values', 1))).position({
            my: 'center top',
            at: 'center bottom',
            of: $('#slider-range span:eq(1)'),
            offset: "0, 0"
        });
    },
    hoursMinutes: function (hours) {
        var hours2 = Math.floor(hours / 60);
        var minutes2 = hours - (hours2 * 60);
        return (hours2 < 10 ? '0' : '') + "" + hours2 + ':' + (minutes2 < 10 ? '0' : '') + "" + minutes2;
    },
    minutesHours: function (hours) {
        var s = hours.split(":");
        console.log(s);
        var hours = Math.floor(s[0] * 60);
        var minutes2 = parseInt(hours) + parseInt(s[1]);
        return minutes2;
    },
    customHeatMap: function () {
        var data = [];
        var options = {
            series: [{
              name: 'W1',
              data: [95,20,25,30,35,36,35,78]
            },
            {
              name: 'W2',
               data: [15,20,25,30,35,36,35,78]
            },
            {
              name: 'W3',
             data: [15,20,25,30,35,36,35,78]
            },
            {
              name: 'W4',
              data: [15,20,25,30,35,36,35,78]
            },],
            chart: {
                height: 450,
                type: 'heatmap',
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#F3B415", "#F27036", "#663F59", "#6A6E94", "#4E88B4", "#00A7C6", "#18D8D8", '#A9D794','#46AF78', '#A93F55', '#8C5E58', '#2176FF', '#33A1FD', '#7A918D', '#BAFF29'],
            xaxis: {
                type: 'category',
                categories: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '01:00', '01:30']
            },
            title: {
                text: 'HeatMap Chart (Different color shades for each series)'
            },
            grid: {
                padding: {
                    right: 20
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#heatMap"), options);
        chart.render();
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
        if (val >= 10000000) return `${parseFloat(value / 10000000).toFixed(1)} Cr`
        if (val >= 100000) return `${parseFloat(value / 100000).toFixed(1)} L`
        if (val >= 1000) return `${parseFloat(value / 1000).toFixed(1)} K`
        return value;
    }
};
