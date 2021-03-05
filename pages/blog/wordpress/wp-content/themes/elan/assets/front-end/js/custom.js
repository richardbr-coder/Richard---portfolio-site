/* File skip-link-focus-fix */
( function() {
    var isIe = /(trident|msie)/i.test( navigator.userAgent );

    if ( isIe && document.getElementById && window.addEventListener ) {
        window.addEventListener( 'hashchange', function() {
            var id = location.hash.substring( 1 ),
                element;

            if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
                return;
            }

            element = document.getElementById( id );

            if ( element ) {
                if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
                    element.tabIndex = -1;
                }

                element.focus();
            }
        }, false );
    }
} )();

(function($) {
   'use strict';

    // Stop Scrolling
    $.fn.stopScrolling = function() {
        $('html').on('wheel.modal mousewheel.modal', function () {return false;});
        return this;
    };

    // Restore Scrolling
    $.fn.restoreScrolling = function() {
        $('html').off('wheel.modal mousewheel.modal');
        return this;
    };

    // Nav Bar BG color
    var navBar = $('.hero-is-activated');
    var siteHeaderHeight = $('.site-header').outerHeight();

    $(window).on('scroll', function () {
        if ( $(window).scrollTop() > siteHeaderHeight + 120 ) {
            navBar.addClass('bg-white nav-bar-setting');
            navBar.removeClass('hero-is-activated');
        } else {
            navBar.addClass('hero-is-activated');
            navBar.removeClass('bg-white nav-bar-setting');
        }
    });

    // Toggle Menu
    var bodyOverlay = $('.body-overlay');

    $( '.hamburger-menu' ).on( 'click', function(e) {
        e.preventDefault();
        bodyOverlay.addClass('is-active');
        $('.main-navigation').toggleClass('is-active');
        $(this).toggleClass('cross');
    });

    // Header Search
    $('.header-search').on('click', function() {
        $('.search-popup').addClass('show');

        setTimeout(function(){
            $('.search-popup').find('.search-field').focus();
        }, 50);

        $.fn.stopScrolling();
    });

    $('.search-close, .slide-in-box-close').on('click', function() {
        $('.search-popup').removeClass('show');
        $('.slide-in-box').removeClass('show');
        bodyOverlay.removeClass('is-active');
    });

    // Keyboard Esc
    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            $('.search-popup').removeClass('show');
            $('.slide-in-box').removeClass('show');
            $('.hamburger-menu').removeClass('cross');
            bodyOverlay.removeClass('is-active');
            $('.main-navigation').removeClass('is-active');
            $('.header-social .social-profiles-section').removeClass('is-active');
            $.fn.restoreScrolling();
        }
    });

    // Restore onClick closest
    $(document).on( 'click', function (e) {
        if ( $( e.target).closest( '.slide-in-icon, .slide-in-box, .hamburger-menu,.main-navigation, .header-search .icon-search' ).length === 0 ) {
            $('.slide-in-box').removeClass('show');
            bodyOverlay.removeClass('is-active');
            $('.main-navigation').removeClass('is-active');
            $('.hamburger-menu').removeClass('cross');
            $.fn.restoreScrolling();
        }
    });

    // Close hamburg menu
    $( '.hamburger-menu.cross, .close-navigation' ).on( 'click', function(e) {
        e.preventDefault();
        $('.hamburger-menu').removeClass('cross');
        bodyOverlay.removeClass('is-active');
        $('.main-navigation').removeClass('is-active');
        $.fn.restoreScrolling();
    });

    // Posts Loading Effects
    AOS.init({
        offset: 200,
        duration: 1000,
        disable: function () {
            var maxWidth = 767;
            return window.innerWidth < maxWidth;
        }
    });
    
    // Image Gallery
    $('.wp-block-gallery').each(function() { // the containers for all your galleries
        $(this).find('.blocks-gallery-item').magnificPopup({
            delegate: 'a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            image: {
                verticalFit: true,
                tError: 'The image can not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title');
                }
            },
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 300, // don't forget to change the duration also in CSS
                opener: function(element) {
                    return element.find('img');
                }
            },
        });
    });

    // Back to Top
    if ($('.back-to-top').length) {
        var scrollTrigger = 500, // px
            backToTop = function () {
                var scrollTop = $( window ).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('.back-to-top').addClass('show');
                } else {
                    $('.back-to-top').removeClass('show');
                }
            };
        backToTop();

        $(window).on('scroll', function() {
            backToTop();
        });

        $('.back-to-top').on('click', function(e) {
            e.preventDefault();
            $('html,body').animate( {
                scrollTop: 0
            }, 800);
        });
    }

})(jQuery);

(function($) {

    // Hide Header on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;

    var navbarHeight = $('.site-header.fixed-top').outerHeight();

    var heroIsActive = $(".nav-bar").data('hero');

    $(window).scroll(function(){
        didScroll = true;
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 200);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if(Math.abs(lastScrollTop - st) <= delta) {
            return;
        }

        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {

            // Scroll Down
            $('.site-header.fixed-top').removeClass('show').css("top",-navbarHeight-50 );
        } else {
            // Scroll Up
            if(st + $(window).height() < $(document).height()) {
                $('.site-header.fixed-top').addClass('show').css("top", "0" );
            }
        }

        lastScrollTop = st;
    }

    // Site Header Separator
    if ( heroIsActive !== 'hero-is-activated' ) {
        $(".site-header-separator").css("height", navbarHeight);
    }

    $(window).on('resize', function() {
        if ( heroIsActive !== 'hero-is-activated' ) {
            $(".site-header-separator").css("height", $('.site-header.fixed-top').outerHeight());
        }
    });

})(jQuery);
