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

	$('form#frmforgotpassword').validate({
		ignore: [],
		rules: {
			email:{
				required: true,
				email:true,
			},
			
		},
		messages: {
			email:{
				required: "Please enter email id",
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
        },

        submitHandler: function(form) {
	        $.ajax({
	            url: BASE_URL + 'partner/send-reset-password', 
	            type: "POST",             
	            data: $('form#frmforgotpassword').serialize(),
	            cache: false,             
	            processData: false,
	            dataType: 'json',      
	            success: function(data) {
	            	console.log(data.response);
	            	if(data.response){
		                $( ".wrapper" ).addClass('hide');
		                $(".notification-message").html("We have sent a reset password link to your email account.<br/><div class='row margin20'><div class='col s12 m12 l12 center'><a id='signin-link'>Signin</a></div></div>").removeClass('hide');
		            } else{
		            	$(".notification-message").html('Email Id not registered with us!').removeClass('hide');
		            }    
	            }
	        });
	        return false;
	    },
		
	});

	

	$('#forgot-password').on('click',function(){
		$('#signin-content').addClass('hide');
		$('#forgot-password-content').removeClass('hide');
	})

	$('body').on('click', '#signin-link',function(){
		$('#signin-content').removeClass('hide');
		$('#forgot-password-content').addClass('hide');
	})
})
