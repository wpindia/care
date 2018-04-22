$('document').ready(function(){	
	$("body").on("click", ".status-change", function(event){
		userLoginId = $(this).data('id');
		status = $(this).val(); 
		$.ajax({
	        url: 'account/changeUserStatus',
	        data: {userLoginId:userLoginId, status: status},
	        type: 'POST',
	        dataType: 'json',
	        success: function(response1) {
	        	window.location.reload();
	        }	
	    }).done(function(response){
	    	
	    });
	});

	$('form#frm_manageUsers').validate({
		ignore: [],
		rules: {
			"couser-name":{
				required: true,
				alphanumeric: true
				//minlength: 50
			},
			"couser-mobile":{
				
			},
			"couser-email":{
				email: true,
				required: true
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