		jQuery('document').ready(function(){	
			$('select').material_select();

			if(typeof $('input#preferred-area').autocomplete === "function"){
				$('input#location').autocomplete({
					_resizeMenu: function () {
						var ul = this.menu.element;
					},
				    source: function (request, response) {
						$.ajax({
							url: '/suggestArea',
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
						window.location.href 	= "/" + city + "/" + areaName;
					},

					minLength: 3,
					
				});
			}
		});	