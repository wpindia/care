jQuery('document').ready(function(){
	$('#home-carousel').owlCarousel({
		lazyLoad: true,
		loop:true,
		autoplay: true,
		margin:10,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
				dots: true,
				nav: false,
				autoplayHoverPause: false
			},
			993:{
				items:1,
				dots: true,
				nav: false,
				autoplayHoverPause: true
			}
		}
	});	
});	