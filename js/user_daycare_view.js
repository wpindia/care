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
        items:3,
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