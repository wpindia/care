jQuery('document').ready(function(){
	$('select').material_select();

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

	
	$('#location').autocomplete({
		data: {
	        "Apple": null,
	        "Microsoft": null,
	        "Google": 'https://placehold.it/250x250'
	      },
		/*source: function (request, response) {
			$.ajax({
				url: 'candidate/account/suggestItem',
				type: "GET",
				cache: false,
				dataType: "json",
				data: {type: $(this.element).data('type'), searchItm: encodeURI(request.term)},
				success: function (data) {
					if(data && data.resource){
						response(data.resource);
					}
				}
			});
		}*/
		
	});
		
});	