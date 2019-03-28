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
function sliderStart() {
    var slideItem = document.querySelectorAll('.main-slideshow .item');
    var totalNum = slideItem.length - 1;
    var FadeTime = 2000;
    var IntervalTime = 5000;
    var actNum = 0;
    var nowSlide;
    var NextSlide;
    slideItem[0].classList.add('show_', 'zoom_');
    setInterval(function () {
        if (actNum < totalNum) {
            nowSlide = slideItem[actNum];
            NextSlide = slideItem[++actNum];
            nowSlide.classList.remove('show_');
            NextSlide.classList.add('show_', 'zoom_');
            setTimeout(function () {
                nowSlide.classList.remove('zoom_');
            }, FadeTime);
        } else {
            nowSlide = slideItem[actNum];
            NextSlide = slideItem[actNum = 0];
            nowSlide.classList.remove('show_');
            NextSlide.classList.add('show_', 'zoom_');
            setTimeout(function () {
                nowSlide.classList.remove('zoom_');
            }, FadeTime);
        }
    }, IntervalTime);
}
jQuery(function ($) {
    var flgopen = getCookie('open_flg');
    if (flgopen == 'true') {
        $('.first-view').addClass('is-on');
        $('.first-view').hide(); // Fade out first view
        $('.page-content').removeClass('scroll-fixed'); // Remove fixed height on index page
        sliderStart(); // Start slider after close first view
        new Vivus('heartline', {
            duration: 200,
            type: "oneByOne"
        }); // Play animation SVG after close first view
        $("#index-intro-blocks .block").scrollClass({
            delay: 10, //set class after 10 milliseconds delay
            threshold: 30, //set class when 50% of element enters the viewport
            offsetTop: 90, //height in pixels of a fixed top navbar
            callback: function () {
                //fire a callback
                console.log("Callback fired!");
            }
        }); // Play block images slider
    }
    $('.first-view .toggle-btn .toggle').on('click', function () {
        $('.first-view').addClass('is-on');
        setTimeout(function () {
            $('.first-view').fadeOut(200); // Fade out first view
            $('.page-content').removeClass('scroll-fixed'); // Remove fixed height on index page
            sliderStart(); // Start slider after close first view
            new Vivus('heartline', {
                duration: 200,
                type: "oneByOne"
            }); // Play animation SVG after close first view
            $("#index-intro-blocks .block").scrollClass({
                delay: 10, //set class after 10 milliseconds delay
                threshold: 30, //set class when 50% of element enters the viewport
                offsetTop: 90, //height in pixels of a fixed top navbar
                callback: function () {
                    //fire a callback
                    console.log("Callback fired!");
                }
            }); // Play block images slider
        }, 1000);
        setCookie('open_flg','true',7);
        console.log(getCookie('open_flg'));
    });
});

