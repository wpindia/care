$('document').ready(function(){	
	$('form#frmresetpassword').validate({
		ignore: [],
		rules: {
		    password: "required",
		    re_password: {
		      equalTo: "#password"
		    }
		},
		messages:{
			re_password:{
				equalTo: "Both fields should match!"
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
});


