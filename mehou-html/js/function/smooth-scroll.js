// Smooth scroll - Add class = "scroll" to <a>
jQuery(function ($) {
	$('a.scroll[href^="#"]').click(function (e) {
		e.preventDefault();
		var headerHeight = 0;
		var win = $(window).width();
		if (win < 980) {
			headerHeight = 60;
		}
		var speed = 400;
		var href = jQuery(this).attr("href");
		var target = jQuery(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top - headerHeight;
		$('body,html').animate({scrollTop: position}, speed, 'swing');
		return false;
	});
});
