$stored_ip_addresses = get_post_meta($post_id,'view_ip',true);
          if($stored_ip_addresses)
          {
            if(sizeof($stored_ip_addresses))
            {
              $current_ip = get_ip_address();
              if(!in_array($current_ip, $stored_ip_addresses))
              {
                $meta_key         = 'entry_views';
                $view_post_meta   = get_post_meta($post_id, $meta_key, true);
                $new_viewed_count = $view_post_meta + 1;
                update_post_meta($post_id, $meta_key, $new_viewed_count);
                $stored_ip_addresses[] = $current_ip;
                update_post_meta($post_id,'view_ip',$stored_ip_addresses);
              }
            }
          }
          else {
              $meta_key         = 'entry_views';
              $view_post_meta   = get_post_meta($post_id, $meta_key, true);
              $new_viewed_count = $view_post_meta + 1;
              update_post_meta($post_id, $meta_key, $new_viewed_count);
              $ip_arr[] = get_ip_address();
              update_post_meta($post_id,'view_ip',$ip_arr);
          } 
          
          
          
          
function get_ip_address() 
{
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($iplist as $ip) {
            if (validate_ip($ip))
                return $ip;
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];
    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
 }
function validate_ip($ip) {
     if (filter_var($ip, FILTER_VALIDATE_IP, 
                         FILTER_FLAG_IPV4 | 
                         FILTER_FLAG_IPV6 |
                         FILTER_FLAG_NO_PRIV_RANGE | 
                         FILTER_FLAG_NO_RES_RANGE) === false)
        return false;
    return true;
}
