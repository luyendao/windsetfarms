jQuery( document ).ready( function($){


  auto_load_sizes_from_storage();

  //do_action_when_quantity_or_unit_price_input();

  //update_sales_total_per_adjustments();

  //recalculate_on_row_removal();

  generate_share_link();

  generate_share_link_on_click();

  $('.acf-field[data-name="products"]').on( 'click', '.choices .acf-rel-item', function() {

    get_prod_info_on_click( $(this) );

  });

  function generate_share_link( force_update ) {
    
    var field_link = $('.acf-field[data-name="share_link"] input');
    var permalink = $('#wp-admin-bar-view a').attr('href');
    var randomString = makeid();
    var share_link;

    if ( force_update || ! field_link.val() ) {

      if ( permalink.indexOf('?') >= 0 ) {
        share_link = permalink + '&access=' + randomString;
      } else { 
        share_link = permalink + '?access=' + randomString;
      }
    
      field_link.val( share_link );  
    }

    if ( ! force_update ) {
      field_link.after('<br/><br/><a class="generate-new-link button">Generate new share link</a>');
    }
    
  }

  function generate_share_link_on_click() {

    $('.acf-field[data-name="share_link"]').on('click', '.generate-new-link', function() {

      generate_share_link( true );

    });

  }

  function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 10; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }
  

  function get_prod_info_on_click( item ) {

    var row_id = item.parents('tr.acf-row').attr('data-id');
    var post_id = item.attr('data-id');
    var secret = $( '#sales_nonce .sales_nonce' ).val();
    var row = select_tools_row( row_id );

    console.log(  row.find( '.acf-field[data-name="product"] .values .list li'  ) );

    console.log( row_id, post_id, secret );

    if ( row_id && post_id && secret ) {
      get_unit_price( row_id, post_id, secret );
    }

  }

  remove_prod_info_on_click();

  function remove_prod_info_on_click() {

    $('.acf-field[data-name="product"]').on( 'click', '.values .acf-rel-item', function( e ) {

      var target = $( e.target );
      var target_id = target.attr('data-id');

      console.log( target, 'removing ' + target_id );

      // if ( target.indexOf('remove_item') >= 0 ) {
        var row_id = $(this).parents('tr.acf-row').attr('data-id');
        var row = select_tools_row( row_id );

        row.find('input').val('');
        row.find('.acf-field[data-name="size"] .acf-input').siblings().remove();
      // }
    });
  }


  function auto_load_sizes_from_storage() {

    var size_fields = $('.acf-field[data-name="products"] .acf-field[data-name="product"]');
    var sizes;

    size_fields.each( function() {

      var post_id = $(this).find('.values ul li:eq(0) input').val();

      if ( post_id ) {
        var row_id = $(this).parents('.acf-row').attr('data-id');

        sizes  = loadLocalStorage( 'prod_' + post_id, 'json' );


        if ( sizes ) {
          add_size_selectors( row_id, post_id, sizes );
        }
      }

    });

  }


  function get_unit_price( row_id, post_id, secret ) {

    var data_json, post_id, sizes, sizes_as_string;

    $.ajax({
      method: "POST",      
      url: ajax_object.ajax_url,
      data: { 
        action: 'get_product_json',
        post_id: post_id, 
        secret: secret
      },
      success: function( data, status, jqXHR ) {        

        data_json = JSON.parse( data );
        post_id = data_json.post_id;
        sizes = data_json.sizes;
        sizes_as_string = JSON.stringify( data_json.sizes);

      }
    })
    .done( function() {

      console.log( row_id, post_id, 'size', sizes );
      
      saveLocalStorage( 'prod_' + post_id, sizes_as_string );

      add_size_selectors( row_id, post_id, sizes );
      set_default_size_and_price( row_id, post_id, sizes );
      update_pricing_for_row( row_id );

    });

  }

  function select_tools_row( row_id ) {

    var row = $('.acf-field[data-name="products"] .acf-row[data-id="' + row_id + '"]');

    return row;

  }

  function set_default_size_and_price( row_id, post_id, sizes ) {

    var default_size = '';
    var default_price = '';
    var row = select_tools_row( row_id );

    var field_size = row.find('.acf-field[data-name="size"]');
    var field_unit_price = row.find('.acf-field[data-name="unit_price"] input');

    var current_size = field_size.find( 'input' ).val();
    var current_price = field_unit_price.val();


    //clear current size if there is a value
    if ( current_size ) {
      field_size.find( 'input' ).val('');
    }

    //clear current price if there is a value
    if ( current_price ) {
      field_unit_price.val( '' );
    }

    if ( sizes ) {

      if ( sizes['0'].weight && field_size.find('input').val().length <= 0 ) {
        default_size = sizes['0'].weight;
        field_size.find('input').val( default_size )
      }

      if ( sizes['0'].unit_price && field_unit_price.val().length <= 0 ) {
        default_price = parseFloat( Math.round( sizes['0'].unit_price * 100 ) / 100 ).toFixed(2);
        field_unit_price.val( default_price );
      }
    }

  }

  function add_size_selectors( row_id, post_id, sizes ) {

    var row = select_tools_row( row_id );

    var field_size = row.find('.acf-field[data-name="size"]');
    var field_unit_price = row.find('.acf-field[data-name="unit_price"] input');

    //clear all old sizes;
    field_size.find('.acf-input').siblings().remove();

    field_size.append('<div class="option-heading">Available Options: </div>');

    var field_size_current = field_size.find('input').val();    

    var thumb_src, html_thumb;

    if ( sizes ) {

      sizes.map( function( size, index ){

        var weight = size.weight;      
        var unit_price = size.unit_price;      
        var weight_and_price = weight;
        var default_checked = '';
        var src = size.img.sizes.thumbnail;
      
        console.log( field_size_current );

        if ( field_size_current <= 0 && index == 0 ) {
          default_checked = 'checked="checked"';
          thumb_src = size.img.sizes.thumbnail;
        }

        if ( field_size_current == weight ) {
          default_checked = 'checked="checked"';
          thumb_src = size.img.sizes.thumbnail;        
        }

        if ( unit_price ) {
          unit_price = parseFloat(Math.round(unit_price * 100) / 100).toFixed(2); 
        }

        if ( weight && unit_price ) {
          var weight_and_price = weight + ' - <i>$' + unit_price + '</i>';
        }

        if ( weight ) {
          var html_checkbox = '<input type="checkbox" '+ default_checked + ' id="size_' + row_id + '_' + post_id + '_' + index +'" ' +
            'value="' + weight + '" data-price="' + unit_price + '" data-src="' + src + '" />' +
            '<label for="size_' + row_id + '_' + post_id + '_' + index +'">' + weight_and_price + '</label>';
            

          field_size.append( '<div class="size-checkbox">' + html_checkbox + '</div>');

          set_size_and_price_if_checkbox_is_checked();

        } else {

        }

      });

    
      if ( thumb_src ) {
        html_thumb = '<img src="' + thumb_src + '"/>';
      }

      field_size.append( '<div class="size-thumb">' + html_thumb + '</div>');      

    } else {

      var no_size_html = '<div class="option-heading">Available Options: </div>' + 
        '<i>Not Found.</i><br/>';

      field_size.find('.acf-input').siblings().remove();
      field_size.find('.acf-input').after( no_size_html );        

    }

    field_size.append( '<a class="edit-product" target="_blank" href="post.php?post=' + post_id + '&action=edit">' + 
      '<span class="dashicons dashicons-edit"></span> Edit options</a>' )

  }



  function set_size_and_price_if_checkbox_is_checked() {

    $('.size-checkbox input[type="checkbox"]').on('change', function() {

      var row_id = $(this).parents('tr.acf-row').attr('data-id');
      var row = select_tools_row( row_id );

      row.find('.size-checkbox input[type="checkbox"]').not(this).prop('checked', false);


      if ( $(this).prop('checked') ) {
        
        var checked_item = $(this);  
        var new_size = checked_item.val();
        var new_unit_price = checked_item.attr('data-price');
        var field_unit_price = $(this).parents('tr.acf-row').find( '.acf-field[data-name="unit_price"] input');
        var new_src = checked_item.attr('data-src');

        $(this).parents('.size-checkbox').siblings('.acf-input').find('input').val( new_size );
        $(this).parents('.size-checkbox').siblings('.size-thumb').find('img').attr( 'src', new_src );
        field_unit_price.val( new_unit_price );

        update_pricing_for_row( row_id );

        update_sales_subtotal();
      }

    });

  }

  function do_action_when_quantity_or_unit_price_input() {

    $( '.acf-field[data-name="products"]' ).on(
      'input', 
      '.acf-field[data-name="quantity"] input, .acf-field[data-name="unit_price"] input', 
      function() {
        var row_id = $(this).parents('tr.acf-row').attr('data-id');
        update_pricing_for_row( row_id );
        update_sales_subtotal();
      }
    );

  }

  function update_pricing_for_row( row_id ) {

    var row = select_tools_row( row_id );
    var quantity = row.find('.acf-field[data-name="quantity"] input').val();
    var unit_price = row.find('.acf-field[data-name="unit_price"] input').val();
    var this_total = 0;

    if ( quantity && unit_price ) {

      unit_price = parseFloat( unit_price.replace(',', '') );
      this_total = quantity * unit_price;
      this_total = parseFloat(Math.round( this_total * 100) / 100).toFixed(2); 

    }

    this_total = numberWithCommas( this_total );

    row.find('.acf-field[data-name="pricing"] input').val( this_total );

  }

  function update_sales_subtotal() {
    var field_subtotal = $('.acf-field[data-name="subtotal"] input');
    var product_pricings = $('.acf-field[data-name="products"] .acf-field[data-name="pricing"]');
    var subtotal = 0;

    product_pricings.each( function() {

      var this_pricing = parseFloat ( $(this).find('input').val().replace(',', '') * 100 / 100 );

      console.log( this_pricing );
      subtotal = ( parseFloat( subtotal ) + parseFloat(Math.round( this_pricing * 100) / 100) ).toFixed(2); 
      
      console.log( 'this_total '+ subtotal );

    }).promise().done( function() {

      console.log( subtotal );

      subtotal = numberWithCommas( subtotal );

      console.log( subtotal );


      field_subtotal.val( subtotal );

      update_all_sales_percentage();

      update_sales_total();

    });

  }


  function numberWithCommas(x) {
      var parts = x.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
  }


  function update_sales_total_per_adjustments() {

    $('.acf-field[data-name="adjustments"]').on(
      'input',
      '.acf-field[data-name="percentage"] input',
      function() {
                      
        update_sales_percentage( $(this) );

        update_sales_total();
    });

    $('.acf-field[data-name="adjustments"]').on(
      'input',     
      '.acf-field[data-name="amount"] input',
      function() {
        update_sales_total();
      }
    );

  }

  function update_all_sales_percentage() {

    var fields_percentage = $('.acf-field[data-name="percentage"]');

    fields_percentage.each( function() {

      var field_percentage = $(this).find('input');

      update_sales_percentage( field_percentage );

    }).promise().done( function() {

      update_sales_total();

    });
    
  }


  function update_sales_percentage( field_percentage ) {

    var percentage = parseFloat ( field_percentage.val() * 100 / 100 );
    var subtotal = parseFloat( $('.acf-field[data-name="subtotal"] input').val().replace(',' , '') * 100 / 100 );
    var amount = parseFloat( subtotal * percentage / 100 ).toFixed(2); 
    var amount = numberWithCommas( amount );

    var field_amount = field_percentage.parents('.acf-row').find('.acf-field[data-name="amount"] input');

    field_amount.val( amount );

  }

  function update_sales_total() {

    var adjustments_amounts = $('.acf-field[data-name="adjustments"] .acf-field[data-name="amount"]');
    var field_total = $('.acf-field[data-name="total"] input');
    var percentage = 0;
    var amount = 0;
    var total = 0;
    var subtotal = parseFloat( $('.acf-field[data-name="subtotal"] input').val().replace(',' , '') * 100 / 100 );

    adjustments_amounts.each( function() {

      this_amount = parseFloat( $(this).find('input').val().replace(',', '') );

      if ( ! isNaN( this_amount ) ) {
        amount = ( parseFloat( amount ) + parseFloat(Math.round( this_amount * 100) / 100) ).toFixed(2); 
      }

    });

    total = ( parseFloat( subtotal ) + parseFloat( amount ) * 100 / 100 ).toFixed(2);

    total = numberWithCommas( total );
    field_total.val( total );

  }

  // Put the object into storage
  function saveLocalStorage( key, data_as_string ) {

    if ( key && data_as_string )
      localStorage.setItem( key, data_as_string );

    return;
  }

  function loadLocalStorage( key, format ) {

    var data;

    if ( key ) {
      data = localStorage.getItem( key ); //string
    } else {      
      return false;
    }

    if ( data && format == 'json' ) {
      data = JSON.parse( data ); //json
    }

    return data;
  }

  var wait_for_update;

  function recalculate_on_row_removal() {

    $('.acf-field[data-name="products"]').on( 'click', 'a[data-event="remove-row"]', function(e) {

        window.clearTimeout( wait_for_update );

        wait_for_update = window.setTimeout(
          function() {
            update_sales_subtotal();
            update_sales_total();
          }, 500 
        );
        
      }
    );

  }

});