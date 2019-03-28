// Back to top button - Set display on scroll amount
var scrollWindows = 200;
$(window).on("scroll", function () {
	if ($(this).scrollTop() > scrollWindows) {
		$("#back-to-top").addClass('display');
	}
	else {
		$("#back-to-top").removeClass('display');
	}
});