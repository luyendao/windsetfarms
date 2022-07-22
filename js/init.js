jQuery( document ).ready( function ($) {

  $('.modal-trigger').leanModal();
  $(".button-collapse").sideNav();
  //$('ul.weights').tabs();
  $('.select').material_select();
  $('.scrollspy').scrollSpy();

  $('.carousel.carousel-slider').carousel({
    time_constant: 180,
    full_width: true,
    indicators: false,
  });

  //$('select').material_select();
  //$('.parallax').parallax();

  if ( $('.section-stores') ) {

    show_states_per_country_select();
    show_stores_per_province_filter();

  }


  function show_states_per_country_select() {

    $('.select-country').change( function() {

      var c_id = $(this).find( 'option:selected').val();

      $('.select-states').addClass('hide').removeClass('active');
      $('.select-states.country-' + c_id ).removeClass('hide').addClass('active');

    });

  }

  function show_stores_per_province_filter() {

    $('.select').change( function() {

      var select_states = $('.select-states.active');
      var selected = select_states.find( 'option:selected').text();
      var results = 0;
      $('.no-match').addClass('hide');

      $('.store').each( function() {

        var store_states = $(this).data('states');

        if ( store_states.indexOf( selected ) < 0 ) {

          $(this).addClass('hide');

        } else {

          $(this).removeClass('hide');
          results++;
        }

      }).promise().done( function() {

          if ( results <= 0 ) {
            $('.no-match').removeClass('hide');
          }
      });

    });
  }


  $('.fade').slick({
    dots: true,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    prevArrow: '<div class="slick-prev slick-arrow"><i class="fa fa-chevron-left"></i></div>',
    nextArrow: '<div class="slick-next slick-arrow"><i class="fa fa-chevron-right"></i></div>',
  });

  if ( $('.btn-year') ) {

    show_news_by_year();
  }

  var player = null;

  if ( $('.btn-play').length > 0 ) {

    play_video();
    stop_video_on_close();
  }

  function show_news_by_year() {

    $('.btn-year').click( function(e) {
      e.preventDefault();
      var year = $(this).data('year');

      $('.news .news-block').addClass('hide');
      $('.news-' + year ).removeClass('hide');

      $('.years a').removeClass('active');
      $(this).addClass('active');

    });
  }



  function play_video() {

    var video_div = $('.video, .ytplayer-player-inline');
    var hideHeader = false;

    if ( $('.bg-video').length  > 0  ) {

      hideHeader = true;
    }


    $('.btn-play').click( function(e) {

      var video_id = $('.video').data('id');

      if ( $('.bg-video').length  > 0  ) {

        hideHeader = true;

      }

      if ( video_div.hasClass('loaded') ) {

        var player = $('.video').data('ytPlayer').player;

        player.playVideo();

        // player.addEventListener('onStateChange', function(data){
        //   console.log("Player State Change", data);
        // });

      } else {

        if ( $('.bg-video').length  > 0  ) {
          $("html, body").animate({ scrollTop: 0 }, "slow");
        }

        video_div.YTPlayer({
            fitToBackground: false,
            videoId: video_id,
            mute: false,
            pauseOnScroll: false,
            repeat: true,
            playerVars: {
              modestbranding: 0,
              autoplay: 0,
              controls: 1,
              showinfo: 0,
              branding: 0,
              rel: 0,
              autohide: 0,
              start: 0,
            }
        });

      }

      if ( hideHeader ) {
        $('.bg-video').removeClass('hide');
        $('.header, .title-container') .addClass('hide');
      }

    });
  }

  function stop_video_on_close() {

    $('.btn-video-close').click( function(){

      var player = $('.video').data('ytPlayer').player;

      player.pauseVideo();

      // player.addEventListener('onStateChange', function(data){
      //   console.log("Player State Change", data);
      // });

      if ( $('.header').hasClass('hide') ) {
        $('.header, .title-container') .removeClass('hide');
        $('.bg-video').addClass('hide');
      }

    });
  }

  $('.modal-play-trigger').leanModal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: '.5', // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
      starting_top: '4%', // Starting top style attribute
      ending_top: '10%', // Ending top style attribute
      ready: function() { }, // Callback for Modal open
      complete: function() {
        console.log( 'model closed');
        var player = $('.video').data('ytPlayer').player;
        player.pauseVideo();

      } // Callback for Modal close
    }
  );


  var stickyNavTop = $('.header').offset().top;

  var stickyNav = function(){
    var scrollTop = $(window).scrollTop();

    if (scrollTop > stickyNavTop) {
        $('.header').addClass('sticky');
        $('.back-to-top').removeClass('hide');
    } else {
        $('.header').removeClass('sticky');
        $('.back-to-top').addClass('hide');
    }
  };

  stickyNav();

  $(window).scroll(function() {
    stickyNav();
  });

  $('.back-to-top').click( function() {

    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;

  });

  $('.side-nav a').click( function(e) {

    e.preventDefault();
    var x = e.pageX;
    var target= $(this).attr('href');
    var parent_li = $(this).parent();

    console.log ( target );

    if ( parent_li.hasClass('menu-item-has-children') ) {

      if ( parent_li.hasClass('opened') ) {

        parent_li.removeClass('opened');

      } else {

        parent_li.siblings().removeClass('opened');

        if ( parent_li.hasClass('menu-item-has-children') ) {
          parent_li.addClass('opened');
        }

      }

      if ( x <= 200 && target )
        window.location = target;

    } else {

      if ( x <= 200 && target  )
        window.location = target;

    }


  });

  $('.header .button-search i').click( function() {

    var button_div = $('.header .button-search');


    if ( button_div.hasClass('active') ) {

      button_div.removeClass('active');

    } else {

      button_div.addClass('active');
      $('.header .field-left').focus();
    }

  });

  $('.header li').not('.button-search').hover( function() {
    var button_div = $('.header .button-search');
    button_div.removeClass('active');
  });

  $('select[name=location]').change( function() {

    var location_email = $(this).find('option:selected').data('email');
    $('input[name="location-email2"]').val( '' );

    if ( location_email.indexOf(',') >= 0 ) {

        //remove space and split to array
        var emails = location_email.replace(' ', '').split(',');

        if ( emails['0'] )
          $('input[name="location-email"]').val( emails['0']  );

        if ( emails['1'] )
          $('input[name="location-email2"]').val( emails['1']  );

    } else {

      $('input[name="location-email"]').val( location_email );
      $('input[name="location-email2"]').val( location_email );

    }

  });


  $('.weights .tab').click( function(e) {

    var a_index = $(this).siblings('.active').index();
    var t_index = $(this).index();
    var is_next = true;
    var p_id = $(this).parents('.product').data('id');

    if ( t_index <  a_index ) {
      is_next = false;
    }

    $('.carousel-' + p_id ).carousel( 'set', t_index );

    //remove all exit classes
    $(this).removeClass('exit-left').removeClass('exit-right');
    $(this).siblings().removeClass('exit-left').removeClass('exit-right');

    //adds active class
    $(this).addClass('active');

    //adds exit class
    if ( is_next ) {
      $(this).siblings('.active').addClass('exit-right');
    } else {
      $(this).siblings('.active').addClass('exit-left');
    }

    //remove active on all active siblings
    $(this).siblings('.active').removeClass('active');

    clearTimeout();

    //clear classes after animation is done
    setTimeout( function(){
      $(this).siblings().removeClass('exit-right').removeClass('exit-left');
    }, 300);


  });

  $('.carousel-item .responsive-img').on( 'hover', function(e){

    change_weight_per_image_slide( $(this) );

  }, function() {

    change_weight_per_image_slide( $(this) );

  });

  $('.carousel-item .responsive-img').on( 'touchend', function(e){

    setTimeout( change_weight_per_image_slide( $(this) ), 300 );

  });

  function change_weight_per_image_slide( target ) {

    var p_id = target.parents('.product').data('id');
    var new_index = target.parents('.carousel').find('.indicator-item.active').index();

    $('.product-' + p_id ).find( '.weights .tab:eq(' + new_index + ')').click();

  }

  var options = [
    {selector: '#icon-0', offset: 150, callback: function() {
        $('#icon-0').attr("src", $('#icon-0').data("src"));
        $('#icon-0').addClass("lazy-animate");
        $('#icon-0').removeAttr("data-src");
    }},
    {selector: '#icon-1', offset: 150, callback: function() {
        var secondIconDelay = 0;
        if (window.innerWidth > 601) {
            secondIconDelay = 500;
        }

        setTimeout(function() {
            $('#icon-1').attr("src", $('#icon-1').data("src"));
            $('#icon-1').addClass("lazy-animate");
            $(this).removeAttr("data-src");    
        }, secondIconDelay);
    }},
    {selector: '#icon-2', offset: 150, callback: function() {
        var thirdIconDelay = 0;
        if (window.innerWidth > 601) {
            thirdIconDelay = 800;
        }
                                                       
        setTimeout(function() {
            $('#icon-2').attr("src", $('#icon-2').data("src"));
            $('#icon-2').addClass("lazy-animate");
            $('#icon-2').removeAttr("data-src");
        }, thirdIconDelay);
    }}
  ];
  Materialize.scrollFire(options);

});
