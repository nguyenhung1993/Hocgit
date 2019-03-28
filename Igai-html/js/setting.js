jQuery(document).ready(function ($) {
	$(".back-to-top").hide();
	$(window).on("scroll", function () {
		if ($(this).scrollTop() > 100) {
			$(".back-to-top").fadeIn("fast");
		} else {
			$(".back-to-top").fadeOut("fast");
		}
		scrollHeight = $(document).height();
		scrollPosition = $(window).height() + $(window).scrollTop();
		footHeight = $("#main-footer").innerHeight();
		if (scrollHeight - scrollPosition <= footHeight) {
			$(".back-to-top").css({
				"position": "fixed",
				"bottom": footHeight + 30
			});
		} else {
			$(".back-to-top").css({
				"position": "fixed",
				"bottom": 30
			});
		}
	});
	$(".back-to-top").click(function() {
		$('html, body').animate({
			scrollTop: 0
		}, 800);
		return false;
	}); // click() scroll top EMD

	$(window).on('resize load', function () {
		Height = $(window).innerHeight();
		Width = $(window).innerWidth();

		if(Height <= 600 && Width < 1400) {
			$('body').addClass('maxwidth-mac')
		}
		if(Height <= 700) {
			$('body').addClass('maxwidth-1400');
		}
		else {
			$('body').removeClass('maxwidth-1400');
			$('body').removeClass('maxwidth-mac')
		}
	});
});