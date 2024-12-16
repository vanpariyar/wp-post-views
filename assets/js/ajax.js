document.addEventListener('DOMContentLoaded', function () {
    if ( true == document.body.classList.contains("archive") || true == document.body.classList.contains("blog") ) {
        return;
    } else {
        let url = wp_post_views_ajax_object.ajaxurl;

        let data = new FormData();
        data.append('action', 'wppv_counter');
        data.append('post_id', wp_post_views_ajax_object.post_id);
        data.append('nonce', wp_post_views_ajax_object.nonce);
        let xhttp = new XMLHttpRequest();

        xhttp.open("POST", url);
        xhttp.send(data);
    }
});
