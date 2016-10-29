/**
 * main theme script
 */
var tn_touch = Modernizr.touch; //check touch device
var tn_to_top;
var tn_to_top_mobile;
var site_smooth_scroll;
var site_smooth_display;
var site_smooth_display_style;
var tn_sidebar_sticky_enable;
var tn_sticky_navigation;
var tn_single_image_popup;
var tn_instagram_widget;
var tn_footer_instagram_widget;
var iOS = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);

jQuery(document).ready(function ($) {
    'use strict';

    //Enable Smooth Scroll
    if (site_smooth_scroll == 1) {
        tn_smooth_scroll();
    }

    //Back To Top
    if (1 == tn_to_top) {
        if (1 == tn_to_top_mobile) {
            $().UItoTop({
                containerID: 'tn-back-top', // fading element id
                easingType: 'easeOutQuart',
                text: '<i class="tn-back-top"></i>',
                containerHoverID: 'tn-back-top-inner',
                scrollSpeed: 800
            });
        } else {
            if (tn_touch === false) {
                $().UItoTop({
                    containerID: 'tn-back-top', // fading element id
                    easingType: 'easeOutQuart',
                    text: '<i class="tn-back-top"></i>',
                    containerHoverID: 'tn-back-top-inner',
                    scrollSpeed: 800
                });
            }
        }
    }

    //Masonry Layout
    var col_data = $('.masonry-el').attr('data-cols');
    var col_width = '.col-sm-6';
    var tn_masonry_layout = $('.is-masonry').find('.main-content-inner');

    if ('undefined' != col_data) {
        tn_masonry_layout.isotope({
            itemSelector: '.masonry-el',
            percentPosition: true,
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: col_width
            }
        });
    }

    //Enable site smooth display
    function tn_animated_image() {
        $('.tn-animated-image').each(function () {
            var that = $(this);
            var delay = 150 + (that.offset().left / 4);
            if (($(window).width() < 1024 && true == tn_touch)) {
                that.waypoint({
                        handler: function () {
                            that.addClass('tn-animation');
                        },
                        offset: '90%',
                        triggerOnce: true
                    }
                )
            } else {
                that.waypoint({
                        handler: function () {
                            setTimeout(function () {
                                that.addClass('tn-animation');
                            }, delay);
                        },
                        offset: '80%',
                        triggerOnce: true
                    }
                )
            }

        });
    }

    //Smooth display
    if (site_smooth_display == 1 && false == iOS) {
        $('#main-content-wrap').find('.post-wrap').addClass(function () {
            return 'tn-animated-image' + ' ' + site_smooth_display_style;
        });
    }


    //Smooth Display
    var ruby_smooth_style_flag = false;
    imagesLoaded('#main', function () {
        if (site_smooth_display == 1 && false == iOS) {
            tn_animated_image();
        }
        ruby_smooth_style_flag = true;
    });

    //set timeout for slow load
    setTimeout(function () {
        if (false === ruby_smooth_style_flag) {
            tn_animated_image();
            ruby_smooth_style_flag = true;
        }
    }, 2000);


    //Header Background parrallax
    var header_parallax_class = $('#header-image-parallax');
    var header_parallax_image = $('#background-image-url').attr('src');
    var is_parallax = $('.is-header-parallax');
    if (header_parallax_class.length > 0 && header_parallax_image.length > 0) {

        //background image responsive
        header_parallax_class.backstretch(header_parallax_image, {fade: 1250, centeredY: false});

        //check & enable parallax
        if ((tn_touch === false || $(window).width() > 1024) && is_parallax.length > 0) {
            $(window).scroll(function () {
                tn_header_parralax_background();
            });
        }
    }

    //Header parallax animation function
    var header_animation_frame = false;
    var header_image_class = header_parallax_class.find('img')[0];

    function header_parallax_animation() {
        var tn_scroll_top = $(document).scrollTop();
        if (tn_scroll_top < 820) {
            var parallax_move = Math.round(tn_scroll_top / 3.5);
            //move the bg
            var translate = 'translate3d(0px,' + parallax_move + 'px, 0px)';
            header_image_class.style.transform = translate;
            header_image_class.style['-webkit-transform'] = translate;
            header_image_class.style['-moz-transform'] = translate;
            header_image_class.style['-ms-transform'] = translate;
            header_image_class.style['-o-transform'] = translate;
        }
        header_animation_frame = false;
    }

    function tn_header_parralax_background() {
        if (header_animation_frame === false) {
            window.requestAnimationFrame(header_parallax_animation)
        }
        header_animation_frame = true;
    }


    //slider options
    var prev_arrow = '<div class="tn-slider-prev tn-slider-nav"></div>';
    var next_arrow = '<div class="tn-slider-next tn-slider-nav"></div>';

    //featured carousel slider
    var featured_carousel = $('#carousel-slider');
    featured_carousel.on('init', function () {
        var slider = $(this);
        slider.imagesLoaded(function () {
            slider.prev('.slider-loading').fadeOut(600, function () {
                $(this).remove();
                slider.removeClass('slider-init');
            });
        });
    });

    featured_carousel.slick({
        centerMode: false,
        infinite: true,
        autoplay: true,
        slidesToShow: 3,
        speed: 400,
        centerPadding: '0',
        autoplaySpeed: 5000,
        dots: true,
        arrows: false,
        prevArrow: prev_arrow,
        nextArrow: next_arrow,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    centerMode: true,
                    centerPadding: '30px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 479,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 1
                }
            }
        ]
    });


    //POST GALLERY SLIDER
    $('.gallery-slider').each(function () {
        var tn_gallery = $(this);
        var tn_nav = tn_gallery.next('.gallery-slider-nav');
        var slider_nav_to_show = 3;

        $(this).on('init', function () {
            var slider = $(this);
            slider.prev('.slider-loading').fadeOut(600, function () {
                $(this).remove();
            });
            slider.removeClass('slider-init');
        });

        tn_nav.on('init', function () {
            $(this).removeClass('slider-init');

            //re-layout masonry
            tn_masonry_layout.isotope('layout');
        });

        if (400 > tn_nav.width()) {
            slider_nav_to_show = 2;
        }

        $(this).slick({
            autoplay: true,
            infinite: true,
            speed: 400,
            adaptiveHeight: true,
            autoplaySpeed: 5000,
            fade: true,
            asNavFor: tn_nav,
            prevArrow: prev_arrow,
            nextArrow: next_arrow
        });

        tn_nav.slick({
            slidesToShow: slider_nav_to_show,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            asNavFor: tn_gallery,
            centerMode: true,
            focusOnSelect: true
        });
    });


    //POST GALLERY GIRD
    $('.gallery-grid').each(function () {
        var tn_gallery_grid = $(this);
        tn_gallery_grid.fadeIn(300).justifiedGallery({
            lastRow: 'justify',
            rowHeight: 168,
            maxRowHeight: 300,
            rel: 'gallery',
            waitThumbnailsLoad: true,
            margins: 5,
            captions: false,
            refreshTime: 250,
            imagesAnimationDuration: 300,
            randomize: false,
            sizeRangeSuffixes: {lt100: "", lt240: "", lt320: "", lt500: "", lt640: "", lt1024: ""}
        }).on('jg.complete', function () {
            //remove loading class
            tn_gallery_grid.removeClass('slider-init');
            tn_gallery_grid.prev('.slider-loading').fadeOut(600, function () {
                $(this).remove();

                //re-layout masonry
                tn_masonry_layout.isotope('layout');
            });

            tn_gallery_grid.find('a').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: true,
                zoom: {
                    enabled: true,
                    duration: 500, // duration of the effect, in milliseconds
                    easing: 'ease', // CSS transition easing function
                    opener: function (element) {
                        return element.find('img');
                    }
                },
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                }
            });
        });
    });


    //STICKY SIDEBAR
    imagesLoaded('body', function () {

        //Layout Isotope after each image loads
        tn_masonry_layout.isotope('layout');

        //ENABLE STICKY SIDEBAR
        if (tn_touch === false || $(window).width() > 768) {
            $('.tn-sidebar-sticky').each(function () {
                var sidebar = jQuery(this);
                tn_sticky_sidebar.sticky_sidebar(sidebar);
            });
        }

        //SINGLE GALLERY POPUP
        $('.single-gallery').find('a').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: true,
            // Delay in milliseconds before popup is removed
            removalDelay: 500,
            // Class that is added to popup wrapper and background
            // make it unique to apply your CSS animations just to this exact popup
            mainClass: 'mfp-fade',
            zoom: {
                enabled: true,
                duration: 500, // duration of the effect, in milliseconds
                easing: 'ease', // CSS transition easing function
                opener: function (element) {
                    return element.find('img');
                }
            },
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1]
            }
        });


        //SINGLE POPUP
        if (1 == tn_single_image_popup && tn_touch === false) {
            var content_wrap = $('.entry');
            if (content_wrap.length > 0) {
                content_wrap.find('a img').each(function () {
                    var image_wrap = $(this).parent();
                    var image_link = image_wrap.attr('href');
                    if (image_link.indexOf('wp-content/uploads') > 0) {
                        image_wrap.addClass('single-popup');
                    }
                })
            }

            content_wrap.magnificPopup({
                type: 'image',
                // Delay in milliseconds before popup is removed
                removalDelay: 500,
                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                mainClass: 'mfp-fade tn-single-popup-image',
                delegate: '.single-popup',
                closeOnContentClick: true,
                closeBtnInside: true,
                zoom: {
                    enabled: true,
                    duration: 500, // duration of the effect, in milliseconds
                    easing: 'ease' // CSS transition easing function
                }
            });

            return false;
        }

    });


    //STICKY MENU
    var menu_wrap = $('#navigation.is-sticky-nav');
    var menu_sticky = menu_wrap.find('.nav-wrap');

    if (1 == tn_sticky_navigation) {

        menu_sticky.css('width', '100%');
        menu_wrap.css('min-height', menu_sticky.height());
        menu_sticky.sticky({
            className: 'is-sticky'
        });
    }


    //RESPONSIVE MENU
    var menu_mobile_button = $('#tn-button-mobile-menu-open');
    var mobile_menu = $('.mobile-nav-wrap');
    var sub_mobile_menu = mobile_menu.find('li.menu-item-has-children');
    var sub_mobile_a = mobile_menu.find('li.menu-item-has-children >a');

    sub_mobile_a.after('<span class="explain-menu"><i class="fa fa-caret-right"></i></span>');

    $('html').click(function () {
        $('body').removeClass('open-menu-mobile');
    });

    menu_mobile_button.click(function () {
        $('body').toggleClass('open-menu-mobile');
        return false;
    });


    sub_mobile_menu.click(function () {
        $(this).toggleClass('show-sub-menu');
        return false;
    });

    sub_mobile_menu.find('a').click(function (event) {
        event.stopPropagation()
    });

    mobile_menu.click(function (event) {
        event.stopPropagation();
    });


    //Instagram widget
    if (1 == tn_instagram_widget) {
        $('.instagram-link').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom',
            image: {
                verticalFit: true
            },
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 600, // duration of the effect, in milliseconds
                easing: 'ease', // CSS transition easing function
                opener: function (element) {
                    return element.find('img');
                }
            }
        });
    }

    //footer instagram widget
    if (1 == tn_footer_instagram_widget) {
        $('.footer-instagram-link').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom',
            image: {
                verticalFit: true
            },
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 600, // duration of the effect, in milliseconds
                easing: 'ease', // CSS transition easing function
                opener: function (element) {
                    return element.find('img');
                }
            }
        });
    }

    //sticky navigation
    if (typeof tn_sidebar_sticky_enable != 'undefined' && true == tn_sidebar_sticky_enable) {
        tn_sticky_sidebar.sticky_sidebar($('.tn-sidebar-sticky'));
    }

});