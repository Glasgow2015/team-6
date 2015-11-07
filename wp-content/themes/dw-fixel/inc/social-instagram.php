<?php  

function getInstagramItems($keyword, $limit) {
    $keyword = trim($keyword);
    $author = '';
    if(strtoupper($keyword) == '[POPULAR]') {
        $xml = ("http://web.stagram.com/rss/popular/");
    } elseif (substr($keyword, 0, 1) == '@') {
        $username = substr($keyword, 1);
        $author = $username;
        $xml = ('http://widget.stagram.com/rss/n/'.$username.'/');
    } elseif (substr($keyword, 0, 1) == '#') {
        $keyword = substr($keyword, 1);
        $xml = ('http://widget.stagram.com/rss/tag/'.$keyword.'/');
    } else {
        $xml = ('http://widget.stagram.com/rss/tag/'.$keyword.'/');
    }

    $xmlDoc = new DOMDocument();
    $xmlDoc->load($xml);
    
    $items = array();
    
    $x= $xmlDoc->getElementsByTagName('item');
    if(is_object($x)) {
        for ($i=0; $i<$limit; $i++) {
            $item = @$x->item($i);
            if(!is_object($item)) {
                break;
            }
            $it = new stdClass();
            $it->image      = @$item->getElementsByTagName('image')->item(0)->getElementsByTagName('url')->item(0)->childNodes->item(0)->nodeValue;
            if(!$it->image) {
                continue;
            }
            $it->title      = $item->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
            $it->link       = $item->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
            $it->desc       = $item->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
            $it->pubDate    = $item->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;
            $it->author       = $item->getElementsByTagName('author')->item(0)->childNodes->item(0)->nodeValue;
            if(!empty($author)) {
                $it->author     = $author;
            } else {
                preg_match('/>\s*(\@[^<]+)</', $it->desc, $matches);
                if(isset($matches[1])) {
                    $it->author     = trim(substr($matches[1], 1));
                } else {
                    $it->author     = '';
                }
            }
            
            
            $it->id = preg_replace('/.*?([0-9_]+)\s*$/', '$1', $it->link);
            
            $items[] = $it;
        }
    }
    return $items;
}

?>
