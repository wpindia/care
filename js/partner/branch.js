$('document').ready(function(){
	$('#save-branch').on('click', function() {
            tinymce.triggerSave();
    });
    
	$('form#frm_addEditProfile').validate({
		ignore: [],
		rules: {
			branch_name:{
				required: true,
			},

			aboutus:{
				required: true,
				//minlength: 50
			},
			address:{
				required: true,
				//email:true,
			},
			contact_name:{
				required: true,
				//minlength:5

			},
			email:{
				required:true,
				email: true
			},
			mobile:{
				required:true,
				minlength: 10,
				maxlength: 12
			},
			city:{
				required: true
			},
			area:{
				required: true
			},
			video_url:{
				url: true
			},
			facebook_id:{
				url: true
			},
			twitter_id:{
				url: true
			},
			instagram_id:{
				url: true
			},
			zip:{
				minlength: 6,
				maxlength: 6
			}
		},
		messages: {
			email:{
				required: "Please enter email id",
			},
			mobile:{
				required: "Please enter mobile no",
			},
			contact_name:{
				required: "Please enter contact name",
			},
			city:{
				required: "Please enter city",	
			},
			video_url:{
				url: "Please enter valid url. Url should start with http",
			},
			facebook_id:{
				url: "Please enter valid url. Url should start with http",
			},
			twitter_id:{
				url: "Please enter valid url. Url should start with http",
			},
			instagram_id:{
				url: "Please enter valid url. Url should start with http",
			}


		},
		errorElement : 'div',
		
		errorPlacement: function(error, element) {
        
            var placement = $(element).data('error');
            if (placement) {
                $(placement).parent().prepend(error);
            } else {
                error.insertAfter(element);
                
            }
        }
	});

	$('select').material_select();

	var drEvent = $('.dropify').dropify({
		error: {
			'fileSize': 'The file size is too big ({{ value }} max).',
			'minWidth': 'The image width is too small ({{ value }}}px min).',
			'maxWidth': 'The image width is too big ({{ value }}}px max).',
			'minHeight': 'The image height is too small ({{ value }}}px min).',
			'maxHeight': 'The image height is too big ({{ value }}px max).',
			'imageFormat': 'The image format is not allowed ({{ value }} only).'
		}
	});
	
	drEvent.on('dropify.beforeClear', function(event, element){
		return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
	});

	drEvent.on('dropify.errors', function(event, element){
		$('#post_image').val('');
	});
	
	drEvent.on('change', function(event, element){
		$('#post_image').val($.trim($(this).val()));
	});

	$('#branch-save').on('click', function() {
            tinymce.triggerSave();
    }); 
	
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
	

	$('#city').on('change',function(){
		$cityId = $(this).val();
		$.ajax({
	        url: 'fetchLocations',
	        type: "POST",
	        dataType: "json",
	        data: {city_id: $cityId},
	        
	        success: function (response) {
	        	console.log(response);
	        }	
		});
	});
});
	