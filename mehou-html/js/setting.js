!(function (o, l, t, n) {
    "use strict";
    (o.scrollClass = function (n, s) {
        var i = this;
        (i.$el = o(n)), (i.el = n), (i.$win = o(l)), (i.$doc = o(t));
        var e,
            a = !1;
        (i.init = function () {
            i.options = o.extend({}, o.scrollClass.defaultOptions, s);
        }),
            (i.scrollHandler = function () {
                a || i.onScroll();
            }),
            (i.onScroll = function () {
                if (i.inViewport())
                    return (
                        0 !== i.options.delay
                            ? (l.clearTimeout(e),
                                (e = l.setTimeout(i.addScrollClass, i.options.delay)))
                            : i.addScrollClass(),
                        "function" == typeof i.options.callback &&
                        i.options.callback.call(n),
                            void (a = !0)
                    );
            }),
            (i.addScrollClass = function () {
                var o = i.$el.data("scrollClass");
                i.$el.addClass(o);
            }),
            (i.inViewport = function () {
                var o = i.el.getBoundingClientRect(),
                    l = i.$win.height(),
                    t = i.options.threshold;
                l < o.height && (t = 50);
                var n = t / 100 * o.height;
                return o.top + n <= l && o.bottom - n >= 0 + i.options.offsetTop;
            }),
            i.init(),
            i.$win.on("scroll load", i.scrollHandler);
    }),
        (o.scrollClass.defaultOptions = {delay: 10, threshold: 50, offsetTop: 0}),
        (o.fn.scrollClass = function (l) {
            return this.each(function () {
                new o.scrollClass(this, l);
            });
        });
})(jQuery, window, document);

jQuery(document).ready(function ($) {

    $(window).on('load scroll resize', function () {
        var headerHeight = $('#main-header').outerHeight();
        $('.main-content').css({
            "margin-top": headerHeight
        });
    });

    $('.menu-sp-btn').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('is-clicked');
        if (!$('.main-menu').hasClass('is-displayed')) {
            $('.main-menu').addClass('is-displayed').slideDown(250);
        } else {
            $('.main-menu').removeClass('is-displayed').slideUp(250);
        }
    });

    $(".custom-select select").each(function () {
        var $this = $(this),
            numberOfOptions = $(this).children("option").length;
        var $valSelect = $(this).val();
        var $txtSelect = '';
        if ($valSelect != '') {
            $txtSelect = $valSelect;
        }
        $this.addClass("s-hidden");
        $this.wrap('<div class="select"></div>');
        $this.after('<div class="styledSelect"></div>');
        var $styledSelect = $this.next("div.styledSelect");
        var $boxSelect = $("select#fContentOfInquiry");
        $styledSelect.text(
            $this
                .children("option")
                .eq(0)
                .text()
        );
        var $list = $("<ul />", {
            class: "options"
        }).insertAfter($styledSelect);
        for (var i = 0; i < numberOfOptions; i++) {
            $("<li />", {
                text: $this
                    .children("option")
                    .eq(i)
                    .text(),
                rel: $this
                    .children("option")
                    .eq(i)
                    .val()
            }).appendTo($list);
        }
        var $listItems = $list.children("li");
        if ($txtSelect != '') {
            $styledSelect.empty().html($txtSelect);
        }
        $styledSelect.click(function (e) {
            e.stopPropagation();
            $("div.styledSelect.active").each(function () {
                $(this)
                    .removeClass("active")
                    .next("ul.options")
                    .hide();
            });
            $(this)
                .addClass("active")
                .next("ul.options")
                .toggle();
        });
        $listItems.click(function (e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass("active");
            $this.val($(this).attr("rel"));
            $boxSelect.val(($(this).attr("rel")));
            if ($boxSelect.hasClass("not_valid")) {
                if ($(this).attr("rel") != "") {
                    $boxSelect.removeClass("not_valid");
                    $boxSelect.closest('.form_validate').find('.error-message .fContentOfInquiry').fadeOut(350);
                }
            }
            $list.hide();
        });
        $(document).click(function () {
            $styledSelect.removeClass("active");
            $list.hide();
        });
    });

    $('.section-contact-form .custom-select .options li').on('click', function () {
        if ($(".styledSelect").text() === "選択してください") {
            $(".styledSelect").css({
                "color": "#BABABA"
            })
        } else {
            $(".styledSelect").css({
                "color": "#000000"
            })
        }
    });

    /*$('html').imagesLoaded(function () {
        $('.images-grid').masonry({
            itemSelector: '.images-grid-item'
        });

    });*/

    var $grid = $('.images-grid').imagesLoaded(function () {
        $grid.masonry({
            itemSelector: '.images-grid-item',
            percentPosition: true,
            columnWidth: 1
        });
    });
});



jQuery(function ($) {
    $('a.smooth-anchor[href^="#"]').click(function (e) {
        e.preventDefault();
        var headerHeight = $('#main-header').outerHeight();
        var speed = 400;
        var href = jQuery(this).attr("href");
        var target = jQuery(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top - headerHeight;
        $('body,html').animate({scrollTop: position}, speed, 'swing');
        return false;
    });
    var flgopen = getCookie('open_flg');
    if (flgopen == 'true') {
    } else {
        setCookie('open_flg','true',7);
    }
});

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}