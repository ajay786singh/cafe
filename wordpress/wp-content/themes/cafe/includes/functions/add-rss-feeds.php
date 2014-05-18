<?php
function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
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
		}else if($item->object->attachments[0]->objectType=='photo') {
			$img=$item->object->attachments[0]->image->url;
		}else if($item->object->attachments[0]->objectType=='article') {
			$img=$item->object->attachments[0]->fullImage->url;
		}else if($item->object->attachments[0]->objectType=='video') {
			$img=$item->object->attachments[0]->image->url;
		}
		$date=date("d-m-Y H:i:s", strtotime($item->published));
		$results[]=array('title'=>$item->title,'link'=>$item->url,'img'=>$img,'date'=>$date,'label'=>'google plus','filter'=>'social');
	}
	return $results;
}
function sort_by_date($a, $b) {
    if ($a['date'] == $b['date']) return 0;
    return (strtotime($a['date']) < strtotime($b['date'])) ? 1 : -1;
}

function youtube_thumbnail_url($url)
{
	if(!filter_var($url, FILTER_VALIDATE_URL)){
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
			$results[] = array('title'=> (string) $entry->title,'link'=> (string) $entry->link,'img'=> (string) $entry->feedimg,'date'=>$newDate,'label'=>'virtual farm tour','filter'=>'virtual_farm_tour','city'=> (string) $entry->feedcity,'state'=> (string) $entry->feedstate);
			$i++;
		}
	}
	return $results;
}

/*
* Feed 
*/

function get_feed_results($feeds) {
		$results='';
		for($i=0;$i<count($feeds);$i++) {
			$params = array(
			  'q' => $feeds[$i]['link'],
			  'v' => '1.0', // API version
			  'num' => 50, // maximum entries (limited)
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
						if($feeds[$i]['label']=='facebook') {
							if (strpos($img,'_s.jpg') == true) {						
								$img = explode("_s.jpg", $img);
								$img[1]="_o.jpg";
								$img=implode("",$img);
							}
								$newimg= explode('url=',$img);
								$img=$newimg[0];
								if($newimg[1]){
									$img=urldecode($newimg[1]);
								}
								if(is_url_exist($img)=='' || is_url_exist($img)!=1){
									$img=get_bloginfo('template_url')."/images/logo.png";	
								}
								
						}
					}
					// Push feed entries to an array
					$newDate = date("d-m-Y H:i:s", strtotime($entry->publishedDate));
					$feed_img=explode("&",$img);
					$img=$feed_img[0];
					if($feeds[$i]['label']=='recipes') {
							if($img && preg_match('/^(http|https):\/\/([a-z0-9-]\.+)*/i', $img)==true) {
								$results[] = array('title'=>$title,'link'=>$entry->link,'img'=>$img,'date'=>$newDate,'label'=>$feeds[$i]['label'],'filter'=>$feeds[$i]['filter']);
							}
					}else {
						$results[] = array('title'=>$title,'link'=>$entry->link,'img'=>$img,'date'=>$newDate,'label'=>$feeds[$i]['label'],'filter'=>$feeds[$i]['filter']);
					}
				}
			}
		}
			// Code to get blog posts
//			$blog_posts=new WP_Query('post_type=post&showposts=-1');
//			$blogs='';
//			if($blog_posts->have_posts()):while($blog_posts->have_posts()):$blog_posts->the_post();
//			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
//			
//			$blogs[]=array('title'=>get_the_title(),'link'=>get_permalink(),'img'=>$feat_image,'date'=>get_the_date('d-m-Y H:i:s'),'label'=>'blog','filter'=>'blog');
//			endwhile; endif; wp_reset_query();
//			if($blogs !='') {
//					if($results !='') {
//						$results=array_merge($blogs,$results);
//					}else {
//						$results=$blogs;	
//					}
//			}
			// Get Google Plus feeds
			//$google_feeds=get_google_plus_feed();
//			if($google_feeds !='') {
//				if($results !='') {
//					$results=array_merge($google_feeds,$results);
//				}else {
//					$results=$google_feeds;	
//				}
//			}
					
		//$vtf_feeds=getFeed('http://virtualfarmtour.cabotcheese.coop/cabot/feed/?post_type=farm');
//			if($vtf_feeds!=''){
//				if($results !='') {
//					$results=array_merge($vtf_feeds,$results);
//				}else {
//					$results=$vtf_feeds;	
//				}	
//			}
				
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
				$feed_img=$result->img;
				$label=$result->label;
				$filter=$result->filter;
				?>
				<div class="element-item item transition <?php echo $label;?> <?php echo $filter;?>" data-category="transition" id="<?php echo "item_".$id;?>">
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
                    <a class="element-img-container" href="<?php echo $link;?>" <?php if($label!='blog') { ?> target="_blank" <?php } ?>>                    
	                    <div class="element-img" style="background-image:url('<?php echo $feed_img;?>'); height: 200px; width: 200px;"></div>
                    </a>   
					<div class="element-title">
					<p><?php echo $label;?></p>			
					<?php
						if ($filter =='virtual_farm_tour' && $result->city !='') {
					?>	
					<p style="margin-bottom:0.5em;"><?php echo $result->city.", ".$result->state;?></p>			
					<?php } ?>
                    <p class="title">
                    	<a href="<?php echo $link;?>" <?php if($label!='blog') { ?> target="_blank" <?php } ?>>
						<?php 					
							if (strlen($title) > 50 && $label !='twitter') {
								echo substr($title, 0, 50) . '...'; 
							
							} else {
								echo $title;
							}
						?>
                        	</a>
                        </p>
					</div>
					
				</div>
				<?php
			}
}



function json_cached_results($urls,$cache_file = NULL, $expires = NULL) {
    global $request_type, $purge_cache, $limit_reached, $request_limit;
	ob_start();
    if( !$cache_file ) $cache_file = TEMPLATEPATH. '/rss-feed.json';
    if( !$expires) $expires = time() - 60 * 15;
	
    if( !file_exists($cache_file) ) die("Cache file is missing: $cache_file");


	if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 15 )) && file_get_contents($cache_file)  != '') {
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