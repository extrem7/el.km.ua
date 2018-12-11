"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function GET(url) {
    var query = url.split('?')[1];
    var result = {};
    query.split("&").forEach(function (part) {
        var item = part.split("=");
        result[item[0]] = decodeURIComponent(item[1]);
    });
    return result;
}

jQuery(function ($) {
    'use strict';
    //pre loader on the site

    $(window).on('load', function () {
        setTimeout(function () {
            $('.preloader').fadeOut('slow', function () {});
        }, 2000);
    });
    'use strict';
    // object mobile menu
    var MobileMenu = {
        toggleMenuMobile: function toggleMenuMobile() {
            $('.mobile-btn').toggleClass('open');
            $('.header-nav-bar, body').toggleClass('open-menu');
        },
        controller: function controller() {
            var _this = this;
            $("#mobile-menu").click(function () {
                _this.toggleMenuMobile();
            });
        }
    };
    var MobileFilter = {
        toggleFilterMobile: function toggleFilterMobile() {
            $('.aside-content, body').toggleClass('open-filter');
            $('.aside-content').fadeToggle('slow');
        },
        controller: function controller() {
            var _this2 = this;
            $("#showFilter,#close-filter").click(function () {
                _this2.toggleFilterMobile();
            });
        }
    };

    var StihlAjax = function () {
        function StihlAjax() {
            var _this3 = this;

            _classCallCheck(this, StihlAjax);

            this.ajaxUrl = StihlAjaxUrl;
            $('.btn-ajax').click(function (e) {
                return _this3.addToCart(e);
            });
            $('.product-compare input').change(function (e) {
                var $this = $(e.currentTarget);
                _this3.toggleCompare($this);
                $this.prop('checked', false);
            });
        }

        _createClass(StihlAjax, [{
            key: "addToCart",
            value: function addToCart(e) {
                var _this4 = this;

                e.preventDefault();
                var btn = $(e.currentTarget),
                    id = GET(btn.attr('href'))['add-to-cart'],
                    data = {
                        action: 'ajax_add_to_cart',
                        product_id: id
                    };

                $(btn).addClass('ajaxLoad').text('');
                $.post(this.ajaxUrl, data, function (res) {
                    $('.notices-area').fadeOut(function () {
                        $(this).empty();
                        $(this).append(res);
                        $(this).fadeIn();
                    });
                }).done(function () {
                    setTimeout(function () {
                        $(btn).removeClass('ajaxLoad').addClass('active').text('В резерві');
                        _this4.scroll();
                    }, 600);
                });
            }
        }, {
            key: "toggleCompare",
            value: function toggleCompare($this) {
                var _this5 = this;

                var data = {
                    action: 'compare_add',
                    id: $this.attr('name')
                };
                $.post(this.ajaxUrl, data, function (res) {
                    $('.notices-area').fadeOut(function () {
                        $(this).empty();
                        var json = JSON.parse(res);
                        $(this).append(json.html);
                        if (json.status === 'success') {
                            $this.prop('checked', true);
                        }
                        $(this).fadeIn();
                    });
                }).done(function () {
                    setTimeout(function () {
                        _this5.scroll();
                        setTimeout(function () {
                            if ($this.hasClass('reloadAfter')) {
                                location.reload();
                            }
                        }, 2000);
                    }, 600);
                });
            }
        }, {
            key: "scroll",
            value: function scroll() {
                var target = $('.notices-area'),
                    top = $(target).offset().top - 150;
                $('body,html').animate({ scrollTop: top }, Math.abs(top - $(document).scrollTop()) * 2);
            }
        }]);

        return StihlAjax;
    }();

    $(document).ready(function () {
        var carouselNavText = ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'];
        //certificate carousel
        $('#certificate-carousel').owlCarousel({
            loop: false,
            margin: 20,
            nav: true,
            autoplay: true,
            dots: true,
            navText: carouselNavText,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 4
                }
            }
        });
        //banner
        $('#banner-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            slideBy: 1,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 2
                }
            }
        });
        //contact page gallery
        $('.contact-page .owl-carousel').owlCarousel({
            loop: false,
            nav: true,
            dots: false,
            items: 1,
            navText: carouselNavText
        });
        //same category carousel
        $('#category-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            margin: 15,
            nav: false,
            dots: true,
            slideBy: 1,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
        // product carousel
        $('#product-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            slideBy: 1,
            items: 2
        });
        //header change shop info
        $('.btn-mail, .btn-phone').click(function () {
            var headerContainer = '.header-contact';
            if (!$(this).hasClass('active')) {
                $('.btn-group-choice .active').removeClass('active');
                $(this).addClass('active');
                $(headerContainer).find('.header-phone').toggleClass('active');
                $(headerContainer).find('.header-email').toggleClass('active');
            }
        });
        //catalog filter aside menu
        $('#catalog, #filter').click(function () {
            if (!$(this).hasClass('active')) {
                $('.btn-group-catalog .active').removeClass('active');
                $(this).toggleClass('active');
                var id = $(this).attr('id');
                var select = '';
                if (id === 'catalog') {
                    select = '.catalog-menu';
                    $('.left-aside .catalog-filter').fadeOut(200, function () {
                        $(select).fadeIn(200);
                    });
                } else {
                    select = '.catalog-filter';
                    $('.left-aside .catalog-menu').fadeOut(200, function () {
                        $(select).fadeIn(200);
                    });
                }
            }
        });
        // readmore button
        $('#readMore').click(function (e) {
            var readMore = $('.full-text');
            $(this).toggleClass('open');
            $(readMore).slideToggle();
        });
        //swipe carousel main
        if ($('.slide').length) {
            $(".slide").swipe({
                swipe: function swipe(event, direction, distance, duration, fingerCount, fingerData) {
                    if (direction == 'left') $(this).carousel('next');
                    if (direction == 'right') $(this).carousel('prev');
                },
                allowPageScroll: "vertical"
            });
        }
        // product gallery
        $('.previews .thumbs').click(function () {
            var largeImage = $(this).attr('data-full');
            $('.previews .thumbs .activate').removeClass('.activate');
            $(this).addClass('activate');
            $('.full img').fadeOut(200, function () {
                $('.product-gallery .gallery-fancybox').attr('href', largeImage);
                $(this).attr('src', largeImage).fadeIn(200);
            });
        });
        var serviceCollapse = '.service-page .collapse';
        $(serviceCollapse).on('show.bs.collapse', function () {
            $(this).prev('.btn-service-toggle').addClass('active');
        });
        $(serviceCollapse).on('hide.bs.collapse', function () {
            $(this).prev('.btn-service-toggle').removeClass('active');
        });
        //mobile menu start
        MobileMenu.controller();
        MobileFilter.controller();
        new StihlAjax();
    });
});