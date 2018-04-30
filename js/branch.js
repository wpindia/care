$('document').ready(function(){
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
	});

	$('#city').on('change',function(){
		$cityId = $(this).val();
		$.ajax({
	        url: 'account/getAreaByCityId',
	        type: "POST",
	        dataType: "json",
	        data: {city_id: $cityId},
	        
	        success: function (response) {
	        	
	        }	
		});
	})	