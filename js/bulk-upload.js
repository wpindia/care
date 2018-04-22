$('document').ready(function(){
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

	

	$('form#frm_reskilling_bulk_upload').validate({
		ignore: [],
		rules: {
			"bulk-upload":{
				required: true
			}		
		},
		errorElement : 'div',
		errorPlacement: function(error, element) {
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			} else {
				error.insertAfter(element);
				
			}
		}
	});
});