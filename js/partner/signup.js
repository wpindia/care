$('document').ready(function(){	
	$('select').material_select();

	jQuery.validator.addMethod("lettersonly", function(value, element){
		return this.optional(element) || /^[a-z ]+$/i.test(value);
	}, "Letters and spaces only please");

	$('form#frm_signup').validate({
		ignore: [],
		rules: {
			vendor_name:{
				required: true,
				minlength: 3,
				alphanumeric: true
								
			},
			email:{
				required: true,
				email:true,
			},
			password:{
				required: true,
				minlength:5

			},
			mobile_no:{
				required:true,
				minlength: 10,
				maxlength: 12
			},
			contact_name:{
				required:true,
				letterswithspaces: true 
			},
			city:{
				required: true
			}
		},
		messages: {
			vendor_name:{
				required: "Please enter your daycare name"
			},
			email:{
				required: "Please enter email id",
			},
			password:{
				required: "Please enter password",
			},
			mobile_no:{
				required: "Please enter mobile no",
			},
			contact_name:{
				required: "Please enter contact name",
			},
			city:{
				required: "Please enter city",	
			}

		},
		errorElement : 'div',
		/*
		errorPlacement: function(error, element) {
        
            var placement = $(element).data('error');
            if (placement) {
                $(placement).parent().prepend(error);
            } else {
                error.insertAfter(element);
                
            }
        }*/
		
	});

	 
})
