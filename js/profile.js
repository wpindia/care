$('document').ready(function(){	
	if($('textarea.tinymce-editor').length>0){
		tinymce.init({
			selector: '.tinymce-editor',
			branding:false,
			menubar: false,
			statusbar: true,
			toolbar_items_size: 'small',
			plugins: ["autolink anchor charmap textcolor textpattern visualblocks visualchars colorpicker directionality fullscreen hr link code image imagetools insertdatetime lists media paste searchreplace tabfocus table wordcount"],
			textcolor_cols: "10",
			toolbar1: "undo redo | styleselect formatselect | charmap anchor | insertdatetime searchreplace table | code",
			toolbar2: "cut copy paste | bullist numlist outdent indent | blockquote | undo redo | removeformat subscript superscript | ltr rtl visualblocks visualchars",
			toolbar3: "fontselect fontsizeselect | alignleft aligncenter alignright alignjustify alignnone | bold italic underline strikethrough | forecolor backcolor | link unlink | media image | fullscreen",
			height: 200,
			end_container_on_empty_block: true,
			browser_spellcheck: true,
			keep_styles: false,
			relative_urls: false,
			formats: {
				alignleft: [
					{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"left"}},
					{selector: "img,table", classes: "alignleft"}
				],
				aligncenter: [
					{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"center"}},
					{selector: "img,table", classes: "aligncenter"}
				],
				alignright: [
					{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"right"}},
					{selector: "img,table", classes: "alignright"}
				],
				strikethrough: {inline: "del"}
			},
			content_css: ['/plugin/font/desktop/museo-sans/include-fonts.css','/plugin/css/materialize-v-0.9.min.css','/css/candidate/style.css','/css/candidate/post.css','/css/admin/admin-tinymce.css'],
			body_class:'post-content-section post-body-section',
			paste_data_images: true,
			convert_urls:false,
			font_formats: 'Arial=arial,helvetica,sans-serif;Museo300=museo_sans300;Museo500=museo_sans500',
			fontsize_formats: '10px 12px 14px 15px 16px 18px 20px 24px 28px 32px',
			default_link_target: "_blank",
			resize:true,
			image_caption: true,
			image_advtab: true,
			image_description: true,
			image_title: true,
			file_picker_types: 'image',
			images_upload_url: 'admin/events/uploadImagesFromEditor',
			file_picker_callback: function(cb, value, meta) {
				var input = document.createElement('input');
				input.setAttribute('type', 'file');
				input.setAttribute('accept', 'image/*');
				$('#errorTinymce').remove();
				// Note: In modern browsers input[type="file"] is functional without 
				// even adding it to the DOM, but that might not be the case in some older
				// or quirky browsers like IE, so you might want to add it to the DOM
				// just in case, and visually hide it. And do not forget do remove it
				// once you do not need it anymore.
				input.onchange = function() {
					var file = this.files[0];
					if( file.size <= 1000000) {
						var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
						if ($.inArray(file.type, ValidImageTypes) < 0) {
							$('.mce-window.mce-in .mce-window-head').after('<div id="errorTinymce" class="tinymceError">File is not an image</div>');
						}else {
							var reader = new FileReader();
							reader.readAsDataURL(file);
							reader.onload = function () {
								var id = 'blobid' + (new Date()).getTime();
								var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
								var blobInfo = blobCache.create(id, file, reader.result);
								blobCache.add(blobInfo);
								$('#errorTinymce').remove();
								cb(blobInfo.blobUri(), { title: file.name });
							}
						}
					}else {
						$('.mce-window.mce-in .mce-window-head').after('<div id="errorTinymce" class="tinymceError">File size sholud be less than 1 MB</div>');
					}
				};
				input.click();
			}
		});
	}

	$('form#frm_addEditProfile').validate({
		ignore: [],
		rules: {
			aboutus:{
				required: true,
				minlength: 50
			},
			"vendor-types[]":{
				vendor_types_req:true
			},
			"facebook-id":{
				url: true
			},
			"twitter-id":{
				url: true	
			},
			"linkedin-id":{
				url: true	
			},
			"video-id":{
				url: true
			},
			"pan":{
				minlength: 10,
				maxlength: 10
			}
		},
		errorElement : 'div',
		errorPlacement: function(error, element) {
			var placement = $(element).data('error');
			if (placement) {
				$(placement).parent().prepend(error);
			} else {
				error.insertBefore(element);
				
			}
		}
	});

	$.validator.addMethod("vendor_types_req", function(value, element) {
		var checkedCount = $('.vendor_types:checked').length;
		if( checkedCount <= 0 ){
			return false;
		}else{
			return true;
		}
		
	}, "Select atleast one offerings");	

	$('#save-profile').on('click', function() {
            tinymce.triggerSave();
    });

    if($('.dropify').length>0){    
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
    }
	
});	