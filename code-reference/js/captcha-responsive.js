function resizeReCaptcha() {
	var width = $( ".g-recaptcha" ).parent().width();
	console.log(width)
	if (width < 302) {
		var scale = width / 302;
	} else {
		var scale = 1;
	}
	$( ".g-recaptcha" ).css('transform', 'scale(' + scale + ')');
	$( ".g-recaptcha" ).css('-webkit-transform', 'scale(' + scale + ')');
	$( ".g-recaptcha" ).css('transform-origin', '0 0');
	$( ".g-recaptcha" ).css('-webkit-transform-origin', '0 0');
};
jQuery( document ).ready(function($) {
	$( window ).on('resize', function() {
		resizeReCaptcha();
	});
	resizeReCaptcha();
});