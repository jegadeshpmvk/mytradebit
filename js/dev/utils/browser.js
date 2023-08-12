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
                height: 430
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
                offsetX: -6,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            legends:{
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
                        formatter: function () {
                            return ''
                        }
                    }
                }
            },
            xaxis: {
                categories: JSON.parse($('#pre_market').attr('data-cat')),
            },
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
    fillDilTable: function () {
        new DataTable('.custom_table_data', {
            // "ordering": false,
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
