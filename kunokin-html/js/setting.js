jQuery(document).ready(function ($) {
    // Smooth scroll anchor link
    $('a.smooth-anchor[href^="#"]').on('click', function (e) {
        e.preventDefault();
        var headerHeight = 55;
        var speed = 400;
        var href = jQuery(this).attr("href");
        var target = jQuery(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top - headerHeight;
        $('body,html').animate({scrollTop: position}, speed, 'swing');
        return false;
    });
    // Fixed top menu bar
    $(window).on('load scroll resize', function () {
        var topMenubarHeight = $("#main-header .top-header").outerHeight();
        var menubarHeight = 55;
        var bodyWidth = $('body').innerWidth();
        if ($(window).scrollTop() >= topMenubarHeight && bodyWidth > 768) {
            $("#main-header .bottom-header").addClass('is-fixed');
            $('main').css({
                "margin-top": menubarHeight
            });
        } else {
            $("#main-header .bottom-header").removeClass('is-fixed');
            $('main').css({
                "margin-top": 0
            });
        }
    });
    // Mobile menu
    $("#menu-sp-btn").on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('is-clicked');
        if (!$(".bottom-header").hasClass('is-open')) {
            $(".bottom-header").slideDown(250).addClass('is-open')
        } else {
            $(".bottom-header").slideUp(250).removeClass('is-open')
        }
    });
    // From contact
    $(document).ready(function () {
        $('.btn-images').hover(function () {
            $(this).attr('src', function (i, src) {
                return src.replace("_off.", "_on.")
            })
        }, function () {
            $(this).attr('src', function (i, src) {
                return src.replace("_on.", "_off.")
            })
        })
    });
    // Fancybox
    $('[data-fancybox]').fancybox({
        protect: true,
        toolbar: false,
        smallBtn: true,
        scrolling: 'visible',
        openEffect: "none",
        closeEffect: "none",

    });
    //Clsoe
    $(".clock").each(function() {
        var clock_hour = $(this).attr('data-hour')*30;
        var clock_minute = $(this).attr('data-minute')*6;
        console.log(clock_hour);
        console.log(clock_minute);
        $(this).find('.clock-hour').css('transform', 'rotateZ('+clock_hour+'deg)');
        $(this).find('.clock-minute').css('transform', 'rotateZ('+clock_minute+'deg)');
    });

    // Match height
    $('.gallery-list .item').matchHeight();

    // Accordion
    $('.accordion-label').on('click', function () {
        $(this).next().slideToggle(250);
        $(this).toggleClass('is-clicked');
    });
    // Hash link location
    $(window).bind('load', function () {
        $('html').imagesLoaded(function () {
            $('a.smooth-scroll[href^="#"]').on('click', function (e) {
                e.preventDefault();
                var headerHeight = $('#main-header').outerHeight();
                var speed = 1000;
                var href = jQuery(this).attr("href");
                var target = jQuery(href == "#" || href == "" ? 'html' : href);
                var position = target.offset().top - headerHeight - 30;
                $('html,body').animate({scrollTop: position}, speed, 'swing');

                return false;
            });
            var location = window.location;
            var origin = location.origin;
            var currentPath = location.pathname;
            var currentHash = location.hash;
            var currentUrl = origin + currentPath;
            $('html').imagesLoaded(function () {
                var dataId = window.location.hash.replace('#', '');
                var scrollTarget = $('*[data-id="' + dataId + '"]');
                if (scrollTarget.length) {
                    var off = scrollTarget.offset().top - $('#main-header').outerHeight();
                    //$('html, body').animate({scrollTop: off}, 1000);
                }
            });
            //Nếu href là cùng 1 trang thì chạy vào function này
            $('a.smooth-anchor').on('click', function (e) {
                    e.preventDefault();
                    width = $(window).width();
                    console.log(width);
                    if(width <= 768) {
                        dataArchor = $(this).attr('data-archor');
                        $('#' + dataArchor).next().slideToggle(250);
                        $('#' + dataArchor).toggleClass('is-clicked');
                    }
                    var hrefPathArray = $(this).attr('href').split('/');
                    var hrefPath = '';
                    hrefPathArray.forEach(function (item, index) {
                        if (item !== '..') {
                            hrefPath += '/' + item;
                        }
                    });
                    var hashFromURL = getHashTag(hrefPath);
                    var hrefPathtoCompare = origin + hrefPath.replace('#' + hashFromURL, '');
                    if (hrefPathtoCompare === currentUrl) {
                        //if detect same url => execute
                        var currentHash2 = currentHash.replace('#', '');
                        var target = $('*[data-id="' + currentHash2 + '"]');
                        var off = target.offset().top - $('#main-header').outerHeight() + 90;
                        $('html').imagesLoaded(function () {
                            $('html, body').animate({scrollTop: off}, 1000);
                        });

                        if(width <= 768) {
                            $('#main-header #menu-sp-btn').trigger('click');
                        }
                    } else {
                        window.location.href = $(this).attr('href');
                    }

                }
            );
        });
        var getHashTag = function (tagString) {
            var tagListArray = [];
            var regexp = new RegExp('#([^\\s]*)', 'g');
            var tmplist = tagString.match(regexp);
            for (var w in tmplist) {
                var hashSub = tmplist[w].split('#');
                for (var x in hashSub) {
                    if (hashSub[x] != "") {
                        if (hashSub[x].substr(hashSub[x].length - 1) == ":") {
                            hashSub[x] = hashSub[x].slice(0, -1);
                        }
                        if (hashSub[x] != "") {
                            tagListArray.push(hashSub[x]);
                        }
                    }
                }
            }
            return tagListArray;
        }
        var hashtag = getHashTag(window.location.href);
        if (hashtag != '') {
            $('#'+hashtag).find('div.accordion-content').css( "display", "block" )
        }
    });
});