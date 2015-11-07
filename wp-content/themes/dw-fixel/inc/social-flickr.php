<?php  
/**
 *  Fetch data feed from flickr 
 */
function get_flickrs( $query ){
    $flickr_get_favorite_photos = 0;

    $regex = '/\d+\@[^\@]+/';
    $searchById = 0;
    $fetchUrl = 'http://api.flickr.com/services/feeds/photos_public.gne?format=php_serial';
    if(preg_match($regex, $query)) {
        $searchById = 1;
        $fetchUrl .= '&id='.$query;
    } else {
        $fetchUrl .= '&tags='.$query;
    }
    
    $content = dw_file_get_content( $fetchUrl );
    $data = unserialize($content);

    $numResult = 0;
    //$aResult = array();
    
    $items = array();
    if(isset($data['items']) && is_array($data['items']) && count($data['items'])) {
        $items = $data['items'];
    }
    
    //Favorite Photos
    if($searchById && $flickr_get_favorite_photos) {
        $fetchUrl2 = 'http://api.flickr.com/services/feeds/photos_faves.gne?format=php_serial&id='.$query;
        $content2 = dw_file_get_content( $fetchUrl2 );
        $data2 = unserialize($content2);
        
        if(isset($data2['items']) && is_array($data2['items']) && count($data2['items'])) {
            foreach ($data2['items'] as $dt) {
                $items[] = $dt;
            }
        }
    }
    if(count($items)) {
        return $items;
    }
    return false;
}


?>