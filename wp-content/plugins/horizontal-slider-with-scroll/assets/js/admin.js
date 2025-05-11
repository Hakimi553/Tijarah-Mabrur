jQuery(document).ready(function () {

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // on window load
    jQuery('.hsscheck').each(function () {
        if (jQuery(this).val() == 'on') {
            jQuery(this).prop("checked", true);

        } else {
            jQuery(this).prop("checked", false);
        }
    });

    /* Choose Card Hover Effect */
    if (jQuery('#cardhover').val() == 'on') {
        jQuery('#cardhover').prop("checked", true);
        jQuery('.hvreffct').css('display', 'flex');
    } else {
        jQuery('#cardhover').prop("checked", false);
        jQuery('.hvreffct').css('display', 'none');
    }


    // wordpress image uploader
    jQuery('#upload-btn').click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: true
        }).open()
            .on('select', function (e) {
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get('selection');

                for (var x = 0; x < uploaded_image.toJSON().length; x++) {
                    var url = uploaded_image.toJSON()[x].url;
                    var id = uploaded_image.toJSON()[x].id;
                    jQuery("#card_box").prepend('<div id="card_' + id + '" class="cards"><img src="' + url + '"/><input type="hidden" name="hss_gallery_image[]" value="' + url + '"/><span class="dashicons dashicons-remove removeicon"></span></div>');
                }
                remove_card();
            });
    });

    remove_card();


    /*Choose setting*/
    jQuery('#choose_setting').click(function () {
        if (jQuery(this).prop("checked") === true) {
            jQuery(this).val('on');
            jQuery('.hss_post_type').removeClass('hide').addClass('active');
            jQuery('.hss_custom_image').removeClass('active').addClass('hide');
        } else {
            jQuery(this).val('off');
            jQuery('.hss_custom_image').removeClass('hide').addClass('active');
            jQuery('.hss_post_type').removeClass('active').addClass('hide');
        }
    });

    /*Checkbox check value*/
    jQuery('.hsscheck').each(function () {
        jQuery(this).click(function () {
            if (jQuery(this).prop("checked") === true) {
                jQuery(this).val('on');
            } else {
                jQuery(this).val('off');
            }
        });
    });

    /*Hover Effect*/
    jQuery('#cardhover').click(function () {
        if (jQuery(this).prop("checked") === true) {
            jQuery('.hvreffct').show('slow').css('display', 'flex');
        } else {
            jQuery('.hvreffct').hide('slow');
        }
    });
    /*Description*/
    jQuery('#desc_on_off').click(function () {
        if (jQuery(this).prop("checked") === true) {
            jQuery('.descstus').removeClass('hide').addClass('active');
        } else {
            jQuery('.descstus').removeClass('active').addClass('hide');
        }
    });
    /*Read More Button*/
    jQuery('#post_button').click(function () {
        if (jQuery(this).prop("checked") === true) {
            jQuery('.btnlbl').removeClass('hide').addClass('active');
        } else {
            jQuery('.btnlbl').removeClass('active').addClass('hide');
        }
    });
    //  carousals  
    jQuery(function () {
        jQuery('#banners').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,

            autoplay: true,
            autoPlaySpeed: 5000,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 2
                }
            }
        });

        jQuery('#kinsta_banners').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoPlaySpeed: 5000,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 5
                },
                991: {
                    items: 6
                },
                1200: {
                    items: 4
                },
                1400: {
                    items: 6
                }
            }
        });

    });


});


function remove_card() {
    jQuery('.removeicon').each(function () {
        jQuery(this).click(function () {
            jQuery(this).parent().remove();
        });
    });
}
