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

	
	/*$('#location').autocomplete({
		source: function (request, response) {
			alert('123');
			$.ajax({
				url: '/account/getLocationByCityId',
				type: "GET",
				cache: false,
				dataType: "json",
				data: {searchItem: encodeURI(request.term)},
				success: function (data) {
					if(data && data.resource){
						response(data.resource);
					}
				}
			});
		}
		
	});
	*/

		//$('body').on('focus', '#location', function () { 
			
		//});
		
});	