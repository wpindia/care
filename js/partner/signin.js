$('document').ready(function(){	
	$('form#frmsignin').validate({
		ignore: [],
		rules: {
			email:{
				required: true,
				email:true,
			},
			password:{
				required: true,
			}
		},
		messages: {
			email:{
				required: "Please enter email id",
			},
			password:{
				required: "Please enter password",
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

	 
})
