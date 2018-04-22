$('document').ready(function(){
	
  $('#resend-verification').on('click', function(){
      $.ajax({
          type: 'POST',
          url: "resend-verification-email",
          dataType: 'json', 
          
          success: function (response) {
              window.location.reload(true);   
          }
      });
  });

  $('.modal').modal();
  
  $("#showHide").on('click',function () {
      $password = $("#s_password");
      var attrType = $password.attr('type');
      if( attrType == "password") {
          $password.attr("type", "text");
          $( 'span', this ).text('Hide');
      } else {
          $password.attr("type", "password");
          $( 'span', this ).text('Show');
      }
  });

  $('.button-collapse').sideNav({
      closeOnClick: true
  });

  var DROPDOWN_STATUS = true;

  $('.dropdown-button-menu').on('click', function(){
    $('.button-collapse').sideNav('hide');
    $('.dropdown-button-menu').dropdown();
    if(DROPDOWN_STATUS){
      $('.dropdown-button-menu').dropdown('open');
      DROPDOWN_STATUS = false;
    }
  });

    $('#submit-forgot-password').on('click', function(){
    
        partnerEmail = $('#email-id').val();
        
        if( partnerEmail == "" || partnerEmail.length == 0 ) {
            $('.error').html('Please enter your email id');
            return false;
        } else {
            $('.error').html('');
            $.ajax({
                type: "POST",
                url: "check-email-id-exists",
                data: {email: partnerEmail},
                dataType: 'json',
                success: function (result) {
                    if( result ) {
                        //sendForgotPasswordEmail( mentorEmail );
                    } else {
                        $('.error').html('This account does not exist. Sign up for a new account');
                        return false;
                    }
                }
            });
        }
    });


    if($('#message_alert_box').length>0){
      var alertHtml = $('#message_alert_box');
      $('#message_alert_box').remove();
      if($('body section>.message-header-section').length > 0){
        $('body section>.message-header-section').after(alertHtml)
      }else {
        $('body section div.navbar-fixed').after(alertHtml);
      }
      $('#message_alert_box').show();
      $('#message_alert_box').slideDown('slow');
      setTimeout(function(){ $('#message_alert_box.timeout').slideUp('slow', function(){ $(this).remove(); } ); }, 6000);
    }

    $('#reset_password').on('submit', function(event){
      event.preventDefault();
      var data = $.trim($(this).find('#email_id').val());
      var $this = $(this);
      if (data){
        $.ajax({
          type: "POST",
          url: "account/resetPassword/",
          data: {email_id: data},
          success: function (result, status) {
            if (result == 2) {
              $($($this).find('#email_id').data('error')).html('<div class="error">Your account has been blocked by jfhadmin. Please contact JFH team</div>');
              $($this).find('#email_id').focus();
            }else if (result == 0) {
              $($($this).find('#email_id').data('error')).html('<div class="error">You are not registered with us. Please Sign up first</div>');
              $($this).find('#email_id').focus();
            }else if(result == 1){
              $($($this).find('.reset-hide')).hide();
              $($($this).find('.row.hide.row-reset .sucTxt')).html('<div class="success">A password reset message has been sent to your registered email id, please click the link in that message to set your password.</div>');
              $($($this).find('.row.hide.row-reset')).removeClass('hide');
              $($($this).find('button.modal-close.jfh-reset')).html('OK');
            }
            else{
              $($($this).find('#email_id').data('error')).html('<div class="error">Please try again.</div>');
              $($this).find('#email_id').focus();
            }
          }
        });
      }
    });
    
    $('#reset_password').validate({
      rules: {
        email_id: {
          required: true,
          email: true
        }
      },
      messages: {
        email_id: {
          required: 'Please enter your email id',
          noSpace: 'Please enter your email id',
          email: 'Please enter your correct email id'
        }
      }
    });

    $('form#frmsignin').validate({
      ignore: [],
      rules: {
        email:{
          email: true,
          required: true 
        },
        password:{
          required: true 
        },

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

    jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^\w+$/i.test(value);
    }, "Letters, numbers, and underscores only please");

});