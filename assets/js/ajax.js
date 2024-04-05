document.addEventListener('DOMContentLoaded', function () {
    if (false == document.body.classList.contains("archive")) {
        let url = wp_post_views_ajax_object.ajaxurl;

        let data = new FormData();
        data.append('action', 'wppv_counter');
        data.append('post_id', wp_post_views_ajax_object.post_id);
        data.append('nonce', wp_post_views_ajax_object.nonce);
        
        let xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            let res = JSON.parse(this.responseText);
        }

        xhttp.open("POST", url);
        xhttp.send(data);
    }
});
