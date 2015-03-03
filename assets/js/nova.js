$(document).ready(function() {
	$('.tag').hover(function() {
		$(this).removeClass('tag');
		$(this).mouseleave(function() {
			$(this).addClass('tag');
		});
	});
	$(window).scroll(function() {
		$('.izbor').css('top', $(this).scrollTop() + "px");
	});
	$(".content").hide();
	$(".navigation").delegate(".toggle", "click", function() {
		$(this).next().toggle("fast").siblings(".content").hide("fast");
	});
	$('#odustani').hover(function() {

	});
	$(document).foundation();
	$('a.custom-close-reveal-modal').click(function() {
		$('.zatvori').foundation('reveal', 'close');
	});




});