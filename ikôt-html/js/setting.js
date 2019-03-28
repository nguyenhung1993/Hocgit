jQuery(document).ready(function ($) {
    $('.main-visual .slideshow-lg').slick({
        arrows: false,
        dots: false,
        autoplay: true,
        autoplaySpeed: 5000,
        infinite: true,
        speed: 1500,
        fade: true,
        cssEase: 'linear',
        pauseOnHover: false
    });
    $('.menu-img-slideshow').slick({
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 4000,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        pauseOnHover: false
    });
});

jQuery(document).ready(function ($) {
    $(window).on('load resize', function () {
        $('.slideshow-lg .slick-slide').css({
            'height': "100vh"
        });
        // $('#section-about').css({
        //     'margin-top': "100vh"
        // });
        $('.jarallax').jarallax({
            speed: 0.2
        });
    })
});

jQuery(document).ready(function ($) {
    $('.main-menu-btn').on('click', function () {
        $(this).toggleClass('active');
        $('.main-menu-content').toggleClass('active');
    });
    $('.main-menu-content ul li a').on('click', function () {
        setTimeout(function () {
            $('.main-menu-btn').trigger('click');
        }, 700)
    });
    $('.btn.btn-rounded').hover(function () {
        $(this).toggleClass('active');
    });
});

jQuery(function ($) {
    $('a.smooth-anchor[href^="#"]').click(function (e) {
        e.preventDefault();
        var speed = 400;
        var href = jQuery(this).attr("href");
        var target = jQuery(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $('body,html').animate({scrollTop: position}, speed, 'swing');
        return false;
    });
});

jQuery(document).ready(function ($) {
    $('.form-content.error input, .form-content.error select, .form-content.error textarea').blur(function () {
        if ($(this).val()) {
            $(this).closest('.form-row').find('.form-content, .form-notice').removeClass('error').addClass('valid');
        } else {
            $(this).closest('.form-row').find('.form-content, .form-notice').removeClass('valid').addClass('error');
        }
    });
});

jQuery(document).ready(function ($) {
    var slideCounter = $('.main-visual .slideshow-lg .slick-slide').length;
    $(window).on('scroll', function () {
        if ($(window).scrollTop() == 0) {
            var slideTo = Math.round(Math.random() * (slideCounter - 1) + 1);
            $('.main-visual .slideshow-lg').slick('slickGoTo', slideTo);
        }
    })
});