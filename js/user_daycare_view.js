$('document').ready(function(){
  
  /*$('.dropdown-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: false, // Does not change width of dropdown to that of the activator
        hover: true, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: false, // Displays dropdown below the button
        alignment: 'left', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
      }
  );

  $('.dropdown-button').dropdown('open');*/

  /*navigator.geolocation.getCurrentPosition(
    function( position ){ // success cb
        console.log( position );
    },
    function(){ // fail cb
    }
  );*/

  $('form#frm_enquiry').validate({
    rules: {
      contact_name:{
        required: true,
        letterswithspaces: true 
      },
      
      email:{
        required: true,
        email:true,
      },

      mobile:{
        required:true,
        minlength: 10,
        maxlength: 12
        
      },

      enquiry_text:{
        required: true,
        maxWords: 50,
        minWords: 5
      }
    },
    messages: {
      email:{
        required: "Please enter email id",
      },
      mobile_no:{
        required: "Please enter mobile no",
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
    },

    submitHandler: function(form) {
        $.ajax({
            url: BASE_URL + 'parent-enquiry', 
            type: "POST",             
            data: $('form#frm_enquiry').serialize(),
            cache: false,             
            processData: false,      
            success: function(data) {
                $( "#thankyou-message" ).removeClass('hide');
                $('form#frm_enquiry textarea, form#frm_enquiry input[type="text"], input[type="email"]').val("");

            }
        });
        return false;
    },


    
  });
  
  $('#gallery').owlCarousel({
    lazyLoad: true,
    loop:true,
    autoplay: true,
    margin:10,
    responsiveClass:true,
    responsive:{
      0:{
        items:1,
        dots: true,
        nav: false,
        autoplayHoverPause: false
      },
      993:{
        items:4,
        dots: true,
        nav: false,
        autoplayHoverPause: true
      }
    }
  });

  
  $('#testimonials').owlCarousel({
    lazyLoad: true,
    loop:true,
    autoplay: true,
    margin:10,
    responsiveClass:true,
    responsive:{
      0:{
        items:1,
        dots: true,
        nav: false,
        autoplayHoverPause: false
      },
      993:{
        items:1,
        dots: true,
        nav: false,
        autoplayHoverPause: true
      }
    }
  });

  $('.location').on('click',function(){
    $('html, body').animate({
      scrollTop: $("#contact-us-section").offset().top
    }, 2000);
  });

  $('.gallery').on('click',function(){
    $('html, body').animate({
      scrollTop: $("#gallery-section").offset().top
    }, 2000);
  });

  //$('.contact-us-details').hide();  
  /*$('.daycare-green-round-btn').on('click', function(){
        $('.contact-us-details').show('slow');
  })*/

  $('.features').on('click',function(){
    $('html, body').animate({
      scrollTop: $("#features-section").offset().top
    }, 2000);
  });

  $('.about-us').on('click',function(){
    $('html, body').animate({
      scrollTop: $("#about-us-section").offset().top
    }, 2000);
  });

  $('.reviews').on('click',function(){
    $('html, body').animate({
      scrollTop: $("#testimonials").offset().top
    }, 2000);
  });




})