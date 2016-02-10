<?php
/**
 * The file that defines the video scraper
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 */

/**
 * Ktzplugin module video
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 * @author     Gian MR <g14nblog@gmail.com>
 */
 
/**
 * get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found. 
 */
function ktzplg_get_youtube_id_from_url( $youtube ) {
    $url = parse_url($youtube);
    if(	$url['host'] !== 'youtube.com' &&
		$url['host'] !== 'www.youtube.com'&&
		$url['host'] !== 'youtu.be'&&
		$url['host'] !== 'www.youtu.be')
	return false;
    
	$youtube = preg_replace('~
        # Match non-linked youtube URL in the wild. (Rev:20111012)
        https?://         # Required scheme. Either http or https.
        (?:[0-9A-Z-]+\.)? # Optional subdomain.
        (?:               # Group host alternatives.
          youtu\.be/      # Either youtu.be,
        | youtube\.com    # or youtube.com followed by
          \S*             # Allow anything up to VIDEO_ID,
          [^\w\-\s]       # but char before ID is non-ID char.
        )                 # End host alternatives.
        ([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
        (?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
        (?!               # Assert URL is not pre-linked.
          [?=&+%\w]*      # Allow URL (query) remainder.
          (?:             # Group pre-linked alternatives.
            [\'"][^<>]*>  # Either inside a start tag,
          | </a>          # or inside <a> element text contents.
          )               # End recognized pre-linked alts.
        )                 # End negative lookahead assertion.
        [?=&+%\w]*        # Consume any URL (query) remainder.
        ~ix', 
        '$1',
        $youtube);
    
	return $youtube;
}
 
/*
 *************************************************************************************
 ************************************* Start Bing video ******************************
 *************************************************************************************
 */
 
if ( !function_exists('ktzplg_get_bingss_video') ) {
	/* 
	 * bing video Scrape 
	 */
	function ktzplg_get_bingss_video( $keyword, $num = 1 ) {	
		global $wp_embed;

		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(' ', '+', $keyword ) : '';
		/*
		 * This is BING XML where the picture come from. :D
		 */
		$xmlbing = array('http://www.bing.com/search?q='.$keywords.'+site:youtube.com&go=&form=QBLH&filt=all&format=rss');
		if ($xmlbing) {
			foreach ($xmlbing as $xmlbing) {

				$rss = fetch_feed($xmlbing);
			
				if ( ! is_wp_error( $rss ) ) : # Checks that the object is created correctly
					// Figure out how many total items there are, but limit it to $num. 
					$maxitems = $rss->get_item_quantity( $num ); 
					// Build an array of all the items, starting with element $startfrom (first element).
					$bing_result = $rss->get_items( 0, $maxitems );
				endif;
				$output = '';
				if ( ! is_wp_error( $rss ) ) :
					if ( $maxitems != 0  ) {

						foreach ($bing_result as $bing_results) {
							// get youtube id with function, please see above function
							$youtube_id = ktzplg_get_youtube_id_from_url( trim( $bing_results->get_link() ) );
							$output .= '<p>';
							/* 
							 * ktzplg_plugin_clean_character find in _functions.php
							 * ucfirst(strtolower( this function doc: http://php.net/ucfirst
							 */
							$output .= '<div class="ktzplg-responsive-video"><iframe height="352" width="625" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allowfullscreen></iframe></div>';
							$output .= '</p>';
						}
					}
				endif;
			}
		}
		return $output;
	} /* End ktzplg_get_bingss_video */
	add_action('ktzplg_get_bingss_video', 'ktzplg_get_bingss_video', 10, 2);
}

/*
 *************************************************************************************
 ************************************* Start aSk video ******************************
 *************************************************************************************
 */
 
if ( !function_exists('ktzplg_get_ask_video') ) {
	/* 
	 * Ask Video Scrape 
	 */
	function ktzplg_get_ask_video( $keyword, $num = 1 ) {
		
		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(' ', '+', $keyword ) : '';
		 
		/* 
		 * @str_get_html Simple HTML DOM and get url via ktzplg_fetch_agc ( curl and fopen )
		 * ktzplg_fetch_agc find in _functions.php
		 */
		$fetch = ktzplg_fetch_agc( 'http://www.ask.com/youtube?q='.$keywords );
		
		$html = new simple_html_dom();
		
		$html->load($fetch); //Simple HTML now use the result craped by cURL.
		 
		$result = array();
		if( $html && is_object($html) )
		{
			foreach($html->find('div.video-result') as $g)
			{
				/*
				 * each search results are in a list item with a class name 'g'
				 * we are seperating each of the elements within, into an array
				 * Summaries are stored in a p with a classname of 'web-result-description'
				 */
				$item['videourl'] = isset($g->find('.video-result-thumbnail-link', 0)->href) ? $g->find('.video-result-thumbnail-link', 0)->href : '';
				$result[] =  $item;
			}
		
			// Clean up memory
			$html->clear();
			unset($html);
			
			/* 
			 * Otherwise it prints out the array structure so that it
			 * is more human readible. You could instead perform a 
			 * foreach loop on the variable $result so that you can 
			 * organize the html output, or insert the data into a database
			 */
			$output = '';
			if($result)
			{
				$i = 0;
				$output .= '<p>';
				foreach($result as $r)
				{
					if ( !empty ($r['videourl']) ) {
						
						// get youtube id with function, please see above function
						$youtube_id = ktzplg_get_youtube_id_from_url( $r['videourl'] );
						
						# ktzplg_plugin_clean_character find in _functions.php
						$output .= '<div class="ktzplg-responsive-video"><iframe height="352" width="625" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allowfullscreen></iframe></div>';
						
					}
					if(++$i==$num) break;
				}
				$output .= '</p>';
			}
		} 
		return $output;
	} /* End ktzplg_get_ask_video */
	add_action('ktzplg_get_ask_video', 'ktzplg_get_ask_video', 10, 2);
}