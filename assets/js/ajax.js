jQuery(document).ready(function ($) {
    if( $('body').hasClass('archive')){
        return;
    }
    $.ajax({
        url: wp_post_views_ajax_object.ajaxurl, // this is the object instantiated in wp_localize_script function
        type: 'POST',
        data: {
            action: 'wppv_counter', // this is the function in your functions.php that will be triggered
            post_id: wp_post_views_ajax_object.post_id,
            nonce: wp_post_views_ajax_object.nonce,
        },
        success: function (data) {
            //Do something with the result from server
            // console.log(data);
        }
    });
});