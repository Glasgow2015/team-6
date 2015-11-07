<?php  

function update_tweet_urls($content) {
    $maxLen = 16;
    //split long words
    $pattern = '/[^\s\t]{'.$maxLen.'}[^\s\.\,\+\-\_]+/';
    $content = preg_replace($pattern, '$0 ', $content);

    //
    $pattern = '/\w{2,4}\:\/\/[^\s\"]+/';
    $content = preg_replace($pattern, '<a href="$0" title="" target="_blank">$0</a>', $content);

    //search
    $pattern = '/\#([a-zA-Z0-9_-]+)/';
    $content = preg_replace($pattern, '<a href="https://twitter.com/#%21/search/%23$1" title="" target="_blank">$0</a>', $content);

    //user
    $pattern = '/\@([a-zA-Z0-9_-]+)/';
    $content = preg_replace($pattern, '<a href="https://twitter.com/#!/$1" title="" target="_blank">$0</a>', $content);

    return $content;
}


function get_tweets_bearer_token( $consumer_key, $consumer_secret, $page_id ){
    if( ! $page_id ) {
        return false;
    }
    $consumer_key = rawurlencode( $consumer_key );
    $consumer_secret = rawurlencode( $consumer_secret );

    $token = maybe_unserialize( get_post_meta( $page_id, '_dw_twitter_widget', true ) );

    if( ! is_array($token) || empty($token) || $token['consumer_key'] != $consumer_key || empty($token['access_token']) ) {
        $authorization = base64_encode( $consumer_key . ':' . $consumer_secret );

        $args = array(
            'httpversion' => '1.1',
            'headers' => array( 
                'Authorization' => 'Basic ' . $authorization,
                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
            ),
            'body' => array( 'grant_type' => 'client_credentials' )
        );
        add_filter('https_ssl_verify', '__return_false');

        $remote_get_tweets = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );

        $result = json_decode( wp_remote_retrieve_body(  $remote_get_tweets ) );
        $token = serialize( array(
            'consumer_key'      => $consumer_key,
            'access_token'      => $result->access_token
        ) );

        update_post_meta( $page_id, '_dw_twitter_widget', $token );
    }
}

function get_tweets( $instance = array() ){
    global $social_wall_settings;

    extract( wp_parse_args( $instance, array(
        'page_id'           => 0,
        'query'             => '',
        'number'            =>  1,
        'consumer_key'      => '',
        'consumer_secret'   => ''
    ) ) );


    $token = maybe_unserialize( get_post_meta( $page_id, '_dw_twitter_widget', true ) );
    
    if( strpos($query, 'from:') === 0  ) {
        $query_type = 'user_timeline';
        $query = substr($query, 5);
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.rawurlencode($query).'&count='.$number;
    } else {
        $query_type = 'search';
        $url =  'https://api.twitter.com/1.1/search/tweets.json?q='.rawurlencode($query).'&count='.$number;
    }

    $remote_get_tweets = wp_remote_get( $url, array(
        'headers'   => array(
            'Authorization' => 'Bearer '. (is_array($token) && isset($token['access_token']) ? $token['access_token'] : '')
        ),
         // disable checking SSL sertificates               
        'sslverify'=>false
    ) );

    $result = json_decode( wp_remote_retrieve_body( $remote_get_tweets ) );
    if( empty($result) || (isset( $result->errors ) && ( $result->errors[0]->code == 89 || $result->errors[0]->code == 215 ) ) ) {
        delete_post_meta( $page_id, '_dw_twitter_widget' );
        get_tweets_bearer_token( $consumer_key, $consumer_secret, $page_id );
        return false;
    } 


    $tweets = array();
    if( 'user_timeline' == $query_type ) {
        if( !empty($result) ) {
            $tweets = $result;
        }
    } else {
        if( !empty($result->statuses) ) {
            $tweets = $result->statuses;
        }

    }

    $follow_button = '<a href="https://twitter.com/__name__" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @__name__</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

    if( !empty($tweets) ) {
        return $tweets;
    }
    return false;
}



?>