		jQuery('document').ready(function(){	
			
			if($('textarea.tinymce-editor').length>0){
				tinymce.init({
					selector: '.tinymce-editor',
					branding:false,
					menubar: false,
					statusbar: true,
					toolbar_items_size: 'small',
					height: 200,
					
				});
			}
			
						
			if($('#message_alert_box').length>0){
		      var alertHtml = $('#message_alert_box');
		      $('#message_alert_box').remove();
		      if($('body section>.message-header-section').length > 0){
		        $('body section>.message-header-section').after(alertHtml)
		      }else {
		        $('body section div.navbar-fixed').after(alertHtml);
		      }
		      $('#message_alert_box').show();
		      $('#message_alert_box').slideDown('slow');
		      setTimeout(function(){ $('#message_alert_box.timeout').slideUp('slow', function(){ $(this).remove(); } ); }, 10000);
		    }

			$('select').material_select();

			if(typeof $('input#preferred-area').autocomplete === "function"){
				$('input#preferred-area').autocomplete({
					_resizeMenu: function () {
						var ul = this.menu.element;
					},
				    source: function (request, response) {
						$.ajax({
							url: BASE_URL + 'suggestArea',
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
						//var areaName 			= encodeURI(ui.item.value.toLowerCase());
						//var city 				= encodeURI($('#preferred-city option:selected').text().toLowerCase());
						//window.location.href 	= "/" + city + "/" + areaName;
					},

					minLength: 3,
					
				});
			}
		});	