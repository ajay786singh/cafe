<?php
function fetch_instagram_feed($url) {
	$ch = curl_init($url); 
	 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

		$json = curl_exec($ch); 
		$data=json_decode($json, true);
		$result=$data['data'];
		$results='';
		$img='';
		$date='';
		$total_feeds=count($result);	
		
		if($total_feeds>0) {
			for($i=0;$i<$total_feeds;$i++) {
				$img = $result[$i]['images']['standard_resolution']['url'];
				$date = date("d-m-Y H:i:s", $result[$i]['created_time']);
				$title = $result[$i]['caption']['text'];
				$link = $result[$i]['link'];
				$author=$result[$i]['caption']['from']['full_name'];
				$results[]=array('title'=>$title,'author'=>$author,'link'=>$link,'img'=>$img,'date'=>$date,'label'=>'instagram','filter'=>'social');
			}
		}
	
	curl_close($ch);

	return $results;
}

function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    } else {
      $status = false;
    }
    curl_close($ch);
	return $status;
}

function get_google_plus_feed(){
	$id = '103003693720550915919';
	$key = 'AIzaSyCVwzWMT9LbcUx0kJP3ZIXHM9vZovgGCZE';
	$feed = json_decode(file_get_contents('https://www.googleapis.com/plus/v1/people/'.$id.'/activities/public?key='.$key));
	$results='';
	$img='';
	foreach ($feed->items as $item) {
		if($item->object->attachments[0]->objectType=='album') {			
			$img=$item->object->attachments[0]->thumbnails[0]->image->url;
		} else if($item->object->attachments[0]->objectType=='photo') {
			$img=$item->object->attachments[0]->image->url;
		} else if($item->object->attachments[0]->objectType=='article') {
			$img=$item->object->attachments[0]->fullImage->url;
		} else if($item->object->attachments[0]->objectType=='video') {
			$img=$item->object->attachments[0]->image->url;
		}
		$date=date("d-m-Y H:i:s", strtotime($item->published));
		$results[]=array('title'=>$item->title, 'author'=>$item->author, 'link'=>$item->url,'img'=>$img,'date'=>$date,'label'=>'google plus','filter'=>'social');
	}
	return $results;
}

function sort_by_date($a, $b) {
    if ($a['date'] == $b['date']) return 0;
    return (strtotime($a['date']) < strtotime($b['date'])) ? 1 : -1;
}

function youtube_thumbnail_url($url) {
	if(!filter_var($url, FILTER_VALIDATE_URL)) {
		// URL is Not valid
		return false;
	}
	$domain=parse_url($url,PHP_URL_HOST);
	if($domain=='www.youtube.com' OR $domain=='youtube.com') // http://www.youtube.com/watch?v=t7rtVX0bcj8&feature=topvideos_film
	{
		if($querystring=parse_url($url,PHP_URL_QUERY))
		{   
			parse_str($querystring);
			if(!empty($v)) return "http://img.youtube.com/vi/$v/0.jpg";
			else return false;
		}
		else return false;
	 
	}
	elseif($domain == 'youtu.be') // something like http://youtu.be/t7rtVX0bcj8
	{
		$v= str_replace('/','', parse_url($url, PHP_URL_PATH));
		return (empty($v)) ? false : "http://img.youtube.com/vi/$v/0.jpg" ;
	}
	else
	return false;
}

function getFeed($feed_url) {
	$content = file_get_contents($feed_url);
	$x = new SimpleXmlElement($content);
	$results="";
	$i=1;
    foreach($x->channel->item as $entry) {
		if($i<=20) {
			$newDate = date("d-m-Y H:i:s", strtotime($entry->pubDate));
			$results[] = array('title'=> (string) $entry->title, 'author'=> (string) $entry->author, 'link'=> (string) $entry->link,'img'=> (string) $entry->feedimg,'date'=>$newDate,'label'=>'virtual farm tour','filter'=>'virtual_farm_tour','city'=> (string) $entry->feedcity,'state'=> (string) $entry->feedstate);
			$i++;
		}
	}
	return $results;
}

function get_feed_results($feeds) {
		$results='';
		for($i=0;$i<count($feeds);$i++) {
			$params = array(
			  'q' => $feeds[$i]['link'],
			  'v' => '1.0', // API version
			  'num' => 10, // maximum entries (limited)
			  'output' => 'JSON', // mixed content: JSON for feed, XML for full entries (json|xml|json_xml)
			  'scoring' => 'h', // include historical entries
			);
			$result = file_get_contents('http://ajax.googleapis.com/ajax/services/feed/load?' . http_build_query($params));
			$json = json_decode($result);
			$data = $json->responseData;
			
			// json version
			if($data->feed->entries) {
				
				foreach ($data->feed->entries as $entry) {
					$title=$entry->title;
					$author=$entry->author;
					if($feeds[$i]['label']=='pinterest') {
						$title=$entry->contentSnippet;	
					}
		
					// Get Img src from content
					$doc = new DOMDocument();
					@$doc->loadHTML($entry->content);	
					$tags = $doc->getElementsByTagName('img');
					$img=''; 		
					foreach ($tags as $tag) {
						$img = $tag->getAttribute('src');
						if($feeds[$i]['label']=='pinterest') {	
							$img = str_replace('/192x/', '/736x/', $img);
						}
						if($feeds[$i]['label']=='facebook') {								
							if (strpos($img,'url=') == true) {
								$img = explode("url=", $img);
								$img = urldecode($img[1]);
							}
							
							if (strpos($img,'/v/t1.0-9/') == true) {
								$img = explode("/v/t1.0-9/", $img);
								$img=implode("/",$img);
							}
							
							if (strpos($img,'/v/t1.0-9/s720x720/') == true) {
								$img = explode("/v/t1.0-9/s720x720/", $img);
								$img=implode("/",$img);
							}
							
							if (strpos($img,'/p130x130/') == true) {
								$img = explode("/p130x130/", $img);
								$img=implode("/",$img);
							}
							
							if (strpos($img,'/s130x130/') == true) {
								$img = explode("/s130x130/", $img);
								$img=implode("/",$img);
							}
							if (strpos($img,'/p100x100/') == true) {
								$img = explode("/p100x100/", $img);
								$img=implode("/",$img);
							}
						}	
					}
					// Push feed entries to an array
					$newDate = date("d-m-Y H:i:s", strtotime($entry->publishedDate));
					$results[] = array('title'=>$title,'author'=>$author,'link'=>$entry->link,'img'=>$img,'date'=>$newDate,'author'=>$author, 'label'=>$feeds[$i]['label'],'filter'=>$feeds[$i]['filter']);
				}
			}
		}
		// Get Instagram Feeds
		$instagram_tags = array('cafelarue','cafelarueetfils','cafelarueetfilsjarry');
		for($i=0;$i<count($instagram_tags);$i++) {
			$instagram_url="";
			$instagram_feeds="";
			$client_id="84e0a91bb0ca49bc91b0b5d88eb1289c";
			$instagram_url='https://api.instagram.com/v1/tags/'.$instagram_tags[$i].'/media/recent?client_id='.$client_id;
			$instagram_feeds=fetch_instagram_feed($instagram_url);
			
			
			if($instagram_feeds !='') {
				if($results !='') {
					$results=array_merge($instagram_feeds,$results);
				}else {
					$results=$instagram_feeds;	
				}
			}
		}
				
		if($results) {
			usort($results, "sort_by_date");
			for( $j=0;$j<count($results);$j++) {
				$results[$j]['row_id'] = $j+1 ;
				?>
				
				<?php
			}
		}
		return $results;
}


function show_feed_results( $results = NULL ) {
    if( !$results ) return false;
	$total = count($results);
	?>
	
    <?php
			$i=0;
			foreach( $results as $result) {
				$id=$result->row_id;
				$link= $result->link;
				$title=$result->title;
				$author=$result->author;
				$feed_img=$result->img;
				$label=$result->label;
				$filter=$result->filter;
				$newDate=$result->date;
				
				?>

				<div class="element-item item <?php echo $label;?> <?php echo $filter;?>" data-category="transition" id="<?php echo "item_".$id;?>">
						<?php 
								if($feed_img==''){
									$feed_img="http://www.cabotcheese.coop/pages/recipes/images/Recipe_NoImage2.jpg";
									$error_img="http://www.cabotcheese.coop/pages/recipes/images/Recipe_NoImage2.jpg";
								}
								if($label =='youtube') {
									if($feed_img=youtube_thumbnail_url($link)) {
										$feed_img=htmlspecialchars($feed_img);
									}else {
										$feed_img="http://www.cabotcheese.coop/pages/recipes/images/Recipe_NoImage2.jpg";
									}
								}
							?>
					<p class="none"><?php echo $label;?></p>
                    <div class="element-title" style="height: 100px; margin: 0 12px 18px 12px;">
                    	<p><b><?php 
                    			if (!$author): 
                    				echo "Cafe Larue & Fils";
                    			else: 
                    				echo $author;
                    			endif; ?></b> // Posted <?php echo date("M d, Y", strtotime($newDate));?></p>
					
                    <p class="title">
                    	<a href="<?php echo $link;?>" <?php if($label!='blog') { ?> target="_blank" <?php } ?>>
						<?php 					
							if (strlen($title) > 100 && $label !='twitter') {
								echo substr($title, 0, 100) . '...'; 
							
							} else {
								echo $title;
							}
						?>
                        </a>
                    </p>
					</div>
	                <div style="overflow: hidden;width: 100%;height: 250px; background-image:url(<?php echo $feed_img;?>); background-repeat:no-repeat; background-size: cover; background-position: center center;">
		                <img class="element-img" src="<?php echo $feed_img;?>" style="display:none;">
	            	</div>
				</div>

				<?php
			}
}



function json_cached_results($urls,$cache_file = NULL, $expires = NULL) {
    global $request_type, $purge_cache, $limit_reached, $request_limit;
	ob_start();
    if( !$cache_file ) $cache_file = TEMPLATEPATH. '/rss-feed.json';
    if( !$expires) $expires = time() - 60 * 10;
	
    if( !file_exists($cache_file) ) die("Cache file is missing: $cache_file");


	if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 10 )) && file_get_contents($cache_file)  != '') {
		// Cache file is less than fifteen minutes old. 
		// Don't bother refreshing, just use the file as-is.
		$json_results = file_get_contents($cache_file);
	} else {
		//$file = file_get_contents($url);
		$json_results ="";
		file_put_contents($cache_file, $json_results, LOCK_EX);
		$api_results = get_feed_results($urls);
		$json_results = json_encode($api_results);
		file_put_contents($cache_file, $json_results, LOCK_EX);
	}

    return json_decode($json_results);
	ob_end_flush();
}
?>