$('document').ready(function(){	
	$('form#frm_addEditTestimonial').validate({
		ignore: [],
		rules: {
			branchId:{
				required: true,
			},
			
			parentName:{
				required: true,
			},

			testimonial:{
				required: true,
				maxWords: 100,
				minWords: 10
				
			}
		},
		messages: {
			

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

	$('#save-testimonial').on('click', function() {
        tinymce.triggerSave();
    });
    

})
