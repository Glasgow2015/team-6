<?php  
if( ! function_exists('dw_get_twitter_count') ) {
    function dw_get_twitter_count($url){
        $twittercount = json_decode( dw_file_get_content( 'http://urls.api.twitter.com/1/urls/count.json?url='.$url ) );
        return isset($twittercount->count) ? $twittercount->count : 0;
    }
}

if( ! function_exists('dw_get_facebook_count') ) {
    function dw_get_facebook_count($url){
        $facebookcount = json_decode( dw_file_get_content( 'http://graph.facebook.com/'.$url ) );
        return isset($facebookcount->shares) ? $facebookcount->shares : 0;
    }
}

if( ! function_exists('dw_get_linkedin_count') ) {
    function dw_get_linkedin_count($url){
        $templinkedin = dw_file_get_content( 'http://www.linkedin.com/countserv/count/share?url='.$url );
        $templinkedin = explode('(',$templinkedin);
        $templinkedin = explode(',',$templinkedin[1]);
        $templinkedin = explode(':',$templinkedin[0]);
        $linkedincount = $templinkedin[1];
        return isset($linkedincount) ? $linkedincount : 0;
    }
}

if( ! function_exists('dw_get_pinterest_count') ) {
    function dw_get_pinterest_count($url){
        $pincount = json_decode( dw_file_get_content( 'http://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url='.$url ) );
        return $pincount->count;
    }
}


if( ! function_exists('dw_get_plusones_share_count') ) {
    function dw_get_plusones_share_count($url)  {
        $args = array(
                'method' => 'POST',
                'headers' => array(
                    // setup content type to JSON 
                    'Content-Type' => 'application/json'
                ),
                // setup POST options to Google API
                'body' => json_encode(array(
                    'method' => 'pos.plusones.get',
                    'id' => 'p',
                    'method' => 'pos.plusones.get',
                    'jsonrpc' => '2.0',
                    'key' => 'p',
                    'apiVersion' => 'v1',
                    'params' => array(
                        'nolog'=>true,
                        'id'=> $url,
                        'source'=>'widget',
                        'userId'=>'@viewer',
                        'groupId'=>'@self'
                    ) 
                 )),
                 // disable checking SSL sertificates               
                'sslverify'=>false
            );
         
        // retrieves JSON with HTTP POST method for current URL  
        $json_string = wp_remote_post("https://clients6.google.com/rpc", $args);
         
        if (is_wp_error($json_string)){
            // return zero if response is error                             
            return "0";             
        } else {        
            $json = json_decode($json_string['body'], true);                    
            // return count of Google +1 for requsted URL
            return intval( $json['result']['metadata']['globalCounts']['count'] ); 
        }
    }
}

?>