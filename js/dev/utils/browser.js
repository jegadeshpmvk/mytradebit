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
    },
    cashSentimentChat: function () {
        var options = {
            series: [76],
            chart: {
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: "#e7e7e7",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                        dropShadow: {
                            enabled: true,
                            top: 2,
                            left: 0,
                            color: '#999',
                            opacity: 1,
                            blur: 2
                        }
                    },
                    dataLabels: {
                        name: {
                            show: true,
                            offsetY: 45,
                            fontSize: '16px',
                            color: "#000",
                            fontFamily: "Manrope"
                        },
                        value: {
                            offsetY: -2,
                            fontSize: '22px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    shadeIntensity: 0.4,
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 53, 91]
                },
            },
            labels: ['FII Cash Data - BUY'],
        };
        this.fiiCashChart = new ApexCharts(document.querySelector("#fii_cash_chart"), options);
        this.fiiCashChart.render();
        this.fiiCashChart.updateOptions({
            series: [76],
            labels: ['FII Cash Data - BUY'],
        });

        this.diiCashChart = new ApexCharts(document.querySelector("#dii_cash_chart"), options);
        this.diiCashChart.render();
        this.diiCashChart.updateOptions({
            series: [66],
            labels: ['DII Cash Data - BUY'],
        });
    },
    preMarket: function () {
        var options = {
            series: [{
                data: [44, 55, 41, 64, 22, 43, 21]
            }, {
                data: [53, 32, 33, 52, 13, 44, 32]
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
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            tooltip: {
                shared: true,
                intersect: false
            },
            xaxis: {
                categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
            },
        };
        var chart = new ApexCharts(document.querySelector("#pre_market"), options);
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
        var arrMinHei = ['.content-equal-heights'];
        $.each(arrMinHei, function (index, value) {
            if ($(value).length)
                $(value).css('height', 'auto').equalHeights();
        });
    },
};
