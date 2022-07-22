jQuery( document ).ready( function($){

    $('.career-list').click(function(){
        var selected_career_index = $(this).data('career-index');
        close_all_career_contents();
        $(this).addClass('selected');
        $('.career-content[data-career-index="' + selected_career_index + '"]').css('display', 'block');
    });

    $('.btn-close-career-content').click(function(){
        close_all_career_contents();
    });

    function close_all_career_contents(){
        $('.career-list').each(function(){
           $(this).removeClass('selected');
        });
        $('.career-content').css('display', 'none');
    }


    $('.btn-trigger-popup').click(function(){

        var product_id = $(this).data('product-id');
        var size_id = $(this).data('size-id');
        var main_content = $('.main-content[data-product-id=' + product_id + ']');
        var popups = $('.product-popup[data-product-id=' + product_id + ']');
        var popup_to_open = $('.product-popup[data-product-id=' + product_id + '][data-size-id=' + size_id +']');


        main_content.hide();
        popups.hide();
        popup_to_open.show();

    });

    $('.btn-close-popup').click(function(){

        var product_id = $(this).closest('section').data('product-id');
        var main_content = $('.main-content[data-product-id=' + product_id + ']');
        var popups = $('.product-popup[data-product-id=' + product_id + ']');

        main_content.show();
        popups.hide();

    });



    var current_language = $('.translator-dropdown-current-language').text();
    update_tagline_image( current_language );
    hide_any_sup_tags( current_language );
    reverse_serves( current_language );

    $('.translator-dropdown-languages-list > p').click(function(){
        var selected_language = $(this).text(); 
        update_tagline_image( selected_language );
        hide_any_sup_tags( selected_language );
        reverse_serves( selected_language );
    });

    function reverse_serves( selected_language ){
        //
        // Hide serving value
        //
        if( selected_language === 'Japanese' ){
            $('.reversed-serves').show();
            $('.serves').hide();
        }
        else{
            $('.reversed-serves').hide();
            $('.serves').show();
        }

    }

    function update_tagline_image( selected_language ){
        var tagline = $('.home-tagline img');
        if( tagline.length > 0 ){
            var tagline_url = tagline.attr('src');
            var last_slash_position = tagline_url.lastIndexOf('/');
            var image_path = tagline_url.substr(0, last_slash_position) + '/';

            var image_name = 'set_the_tone';
            var image_extension = '.png';

            switch( selected_language ){
                case 'French' : 
                    image_name += '_FRE';
                    break;
                case 'Japanese' :
                    image_name += '_JPN';
                    break;
                case 'Spanish' :
                    image_name += '_SPA';
                    break;
                case 'Chinese Traditional' :
                    image_name += '_CHN';
                    break;
            }

            var full_image_path = image_path + image_name + image_extension;
            tagline.attr('src' , full_image_path );
        }
    }

    function hide_any_sup_tags( selected_language ){
        var all_sup_tags = $('sup');
        switch( selected_language ){
            case 'French' : 
            case 'Japanese' :
            case 'Spanish' :
            case 'Chinese Traditional' :
                all_sup_tags.hide();
                break;
            default :
                all_sup_tags.show();
        }
    }

    

    hide_all_other_languages_except_eng_and_jp_on_single_recipe();

    function hide_all_other_languages_except_eng_and_jp_on_single_recipe(){
        if( $('body').hasClass('single-recipes') ){
            $('.translator-dropdown-languages-list p').each(function(){
                var language = $(this).find('a').attr('title');
                if( ! ( language === 'English' || language === 'Japanese' ) ){
                    $(this).hide();
                }
                           });
        }

    }

    translate_to_lang_in_parameter();
    
    function translate_to_lang_in_parameter(){
        var url_string = window.location.href;
        var url = new URL(url_string);
        var lang = url.searchParams.get("lang");
        if( lang == 'jp' ){
            lang = 'ja';
        }
        if( lang ){
            console.log('language detected');
            var interval = setInterval(function(){
                var target = $('.translator-dropdown-language-' + lang);
                if( target.length ){
                    target.trigger('click');
                    clearInterval(interval);
                }
            }, 500);
        }
    }



});

