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
			$('input#location').autocomplete({
				_resizeMenu: function () {
					var ul = this.menu.element;
				},
			    source: function (request, response) {
					$.ajax({
						url: 'suggestArea',
						type: "GET",
						cache: false,
						dataType: "json",
						data: {city_id: $('#preferred-city').val(), area_name: encodeURI(request.term)},
						success: function (data) {
							if(data && data){
								response(data);
							}
						}
					});
				},
				open: function(event, ui) { 
					var max_width = $(this).outerWidth();
					$(this).autocomplete("widget").width(max_width);
				},

				select: function( event, ui ) {
					var areaName 			= encodeURI(ui.item.value.toLowerCase());
					var city 				= encodeURI($('#preferred-city option:selected').text().toLowerCase());
					window.location.href 	= city + "/" + areaName;
				},

				minLength: 3,
				
			});
		//});
		
});	