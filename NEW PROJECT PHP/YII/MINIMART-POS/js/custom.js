$(document).ready(function(){
//window.onload = function(){

	var url = window.location.href;
	$('#mainMenu li a').filter(function() {
		return this.href == url;
	}).parent().addClass('active');
	
	$('.js-activated').dropdownHover().dropdown();
	
	$('.slick').slick({
			dots: false,
			infinite: false,
			speed: 300,
			slidesToShow: 3,
			touchMove: false,
			slidesToScroll: 1
		});
});
		