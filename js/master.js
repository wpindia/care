$('document').ready(function(){
	
	$('.delete-sample').on('click',function(){
		var sampleId = $(this).attr('data-id');
		var entityId = $(this).attr('data-entity-id');
		$.ajax({
	        url: 'account/deleteSampleDocs',
	        data: {id:sampleId,entity_id:entityId},
	        type: 'POST',
	        dataType: 'json',
	    }).done(function(response){
	    	$('#sample-'+sampleId).remove();
	    });	
	});

	

	 $('select.material_select').material_select();
	 $('#reskilling_city_wrapper').show(); 
	 if($('#reskilling_mode_type_id').is(":checked")){
		$('#reskilling_city_wrapper').hide();
	 }

	$('#reskilling_mode_type_id').on('change', function(){
		if($(this).is(":checked")){
			$('#reskilling_city_wrapper').hide();
		}else{
			$('#reskilling_city_wrapper').show();	
		}		
	})
	
	if( typeof $('.datetimepicker').datetimepicker === "function") {
		$('.datetimepicker').datetimepicker({
			format:'d/M/Y h:i a',
			scrollMonth: false
		});
	}

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

	$('#revenue_type_id').on('change', function(){
		if( $(this).val() == 3 ){
			$('.is_paid').attr("checked", false);	
			$('.is_paid').attr("disabled", true);
		}else{
			$('.is_paid').attr("disabled", false);
		}
		
	})

	
	$('form#frm_vendor_add_edit').validate({
		ignore: [],
		rules: {
			vendor_name:{
				required: true,
				minlength:3
			},
			legal_name:{
				required: true,
				minlength:3
			},
			email_id:{
				required: true,
				email:true,
			},
			website:{
				url: true
			},
			end_date_time:{
				end_date_time:true
			}
		},
		messages: {
			vendor_name:{
				required: "Please enter Vendor SEO Name"
			},
			legal_name:{
				required: "Please enter Vendor Name"
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

	$('form#frm_reskilling_add_edit').validate({
		ignore: [],
		rules: {
			title:{
				required: true,
				minlength:3
			},
			description: {
				required: true
				
			},
			vendor_id:{
				required: true
			},
			revenue_type_id:{
				required: true
			},
			reskilling_level_type_id:{
				required: true
			},
			"cities[]":{
				offline_req_cities:true
			},
			/*price:{
				price: true,
				number: true
			},
			jfh_costing:{
				number:true,
				jfh_costing:true
			},*/
			end_date_time:{
				end_date_time:true
			},
			external_link:{
				external_link:true,
				url:true 
			},
			functional_area:{
				required: true
			}
			
		},
		messages: {
			title:{
				required: "Please enter Title"
			},
			description: {
				required: "Please enter Description"
			},
			terms_and_conditions: {
				required: "Please enter terms and conditions"
			},
			vendor_id:{
				required: "Please select vendor from dropdown"
			},
			functional_area:{
				required: "Please select functional area" 
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

	$.validator.addMethod("end_date_time", function(value, element) {
		var startdatevalue = $('.start_date_time').val();
		if(startdatevalue.length > 0 || value.length > 0 ) {
			return Date.parse(startdatevalue) < Date.parse(value);
		}else{
			return true;
		}
	}, "End Date should be greater than Start Date.");

	$.validator.addMethod("price", function(value, element) {
		var isPaidCourse = $('.is_paid').is(':checked');
		
		if( 1 == isPaidCourse && $('#vendor_price').val() == '' ){
			return false;
		}else{
			return true;
		}

		/*if( 3 == revenueTypeId ) {
			$('#jfh_price').val('0');
			return true;
		}else{
			if( $('#vendor_price').val() == '' ){
				return false;
			}else{
				return true;
			}
		}*/
	}, "Please enter Price.");
	
	$.validator.addMethod("jfh_costing", function(value, element) {
		var vendorPrice 	= $('#vendor_price').val();
		
		if( vendorPrice != '' && ( vendorPrice > value ) ){
			return false;
		}else{
			return true;
		}
		
		/*if(3 == revenueTypeId){
			$('#jfh_price').val('0');
			return true;
		}else if(vendorPrice > value ) {
			return false;
		}else{
			return true;
		}*/
	}, "JFH Costing should be greater than Vendor Price!");

	$.validator.addMethod("external_link", function(value, element) {
		
			var revenueTypeId = $('#revenue_type_id').val();
			if(revenueTypeId == 2 && value.length == 0 ) {
				return false;
			}else{
				return true;
			}
		
	}, "External link is mandatory for CPC revenue type");

	$.validator.addMethod("offline_req_cities", function(value, element) {
		var reskillingMode 	= $('#reskilling_mode_type_id').is(":checked");
		
		if( false == reskillingMode && null == $('#reskilling_city').val() ){
			return false;
		}else{
			return true;
		}
		
	}, "City is mandatory for Offline courses/assessments/services");

    $('#reskilling-save').on('click', function() {
            tinymce.triggerSave();
    }); 
	
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

	$('select.select-selectize').selectize({
	 	plugins: ['remove_button'],
        highlight: false,
        create: false
	 });
});