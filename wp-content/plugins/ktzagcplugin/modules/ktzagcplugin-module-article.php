<?php
/**
 * The file that defines the article scraper from source
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 */

/**
 * Ktzplugin module article
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 * @author     Gian MR <g14nblog@gmail.com>
 */
 
/*
 *************************************************************************************
 ********************************* Start Google Article ******************************
 *************************************************************************************
 */
 
if ( !function_exists('ktzplg_get_google_article') ) {
	/* 
	 * Google Article Scrape 
	 */
	function ktzplg_get_google_article( $keyword, $num = 4, $related = false ) {
		
		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(' ', '+', $keyword ) : '';
		 
		/* 
		 * @str_get_html Simple HTML DOM and get url via ktzplg_fetch_agc ( curl and fopen )
		 * ktzplg_fetch_agc find in _functions.php
		 */
		$fetch = ktzplg_fetch_agc( 'http://www.google.com/search?hl=en&q='.$keywords );
		
		$html = new simple_html_dom();
		
		$html->load($fetch); //Simple HTML now use the result craped by cURL.
		
		$result = array();
		if( $html && is_object($html) )
		{
			foreach($html->find('div.g') as $g)
			{
				/*
				 * each search results are in a list item with a class name 'g'
				 * we are seperating each of the elements within, into an array
				 * Summaries are stored in a span with a classname of 'st'
				 * Title are stored in a h3 with a classname of 'r'
				 */
				$item['title'] = isset($g->find('h3.r', 0)->innertext) ? $g->find('h3.r', 0)->innertext : '';
				$item['description'] = isset($g->find('span.st', 0)->innertext) ? $g->find('span.st', 0)->innertext : '';
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
				if ( $related == true ) :
					$output .= '<h3 class="ktzplg-title-related">' . __('Related posts to ','ktzagcplugin');
					$output .= $keyword;
					$output .= '</h3>';
					$output .= '<ul class="ktzplg-list-agcplugin">';
					foreach($result as $r)
					{
						$output .= '<li>';
						if ( !empty ($r['title']) ) {
							
							$result_title = ktzplg_filter_badwords( $r['title'] );	
							$result_title = sanitize_title($result_title);
							$result_title = str_replace('-',' ', $result_title);
							$result_title = ktzplg_plugin_clean_character($result_title);
							$result_title = ucwords($result_title);
							$output .= '<h3><a href="'; 
							$output .= ktzplg_permalink( $result_title, $choice = 'default' );
							$output .= '" title="' . __('Permalink to ','ktzagcplugin') . $result_title . '">'; 
							$output .= $result_title;
							$output .= '</a></h3>'; 
							
						}
						if ( !empty ($r['description']) ) {
							
							$result_desc = ktzplg_filter_badwords( $r['description'] );					
							$output .= '<p>' . ucfirst(ktzplg_plugin_clean_character($result_desc)) . '.</p>'; 
							
						}
						$output .= '</li>';
						if(++$i==$num) break;
					}
					$output .= '</ul>';
				else :
					$output .= '<p>';
					foreach($result as $r)
					{
						if ( !empty ($r['description']) ) {
							
							$result_desc = ktzplg_filter_badwords( $r['description'] );
							
							# ktzplg_plugin_clean_character find in _functions.php
							$output .= ucfirst(ktzplg_plugin_clean_character($result_desc)) . '.'; 
							
						}
						if(++$i==$num) break;
					}
					$output .= '</p>';
				endif;
			}
		} 
		return $output;
	} /* End ktzplg_get_google_article */
	add_action('ktzplg_get_google_article', 'ktzplg_get_google_article', 10, 3);
}

/*
 *************************************************************************************
 ********************************* Start Ask.com Article *****************************
 *************************************************************************************
 */

if ( !function_exists('ktzplg_get_ask_article') ) {
	/* 
	 * Ask Article Scrape 
	 */
	function ktzplg_get_ask_article( $keyword, $num = 4, $related = false ) {
		
		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(' ', '+', $keyword ) : '';
		 
		/* 
		 * @str_get_html Simple HTML DOM and get url via ktzplg_fetch_agc ( curl and fopen )
		 * ktzplg_fetch_agc find in _functions.php
		 */
		$fetch = ktzplg_fetch_agc( 'http://www.ask.com/web?q='.$keywords );
	
		$html = new simple_html_dom();
		
		$html->load($fetch); //Simple HTML now use the result craped by cURL.
		 
		$result = array();
		if( $html && is_object($html) )
		{
			foreach($html->find('div.web-result') as $g)
			{
				/*
				 * each search results are in a list item with a class name 'g'
				 * we are seperating each of the elements within, into an array
				 * Summaries are stored in a p with a classname of 'web-result-description'
				 * title are stored in a with a classname of 'web-result-title-link'
				 */
				$item['title'] = isset($g->find('a.web-result-title-link', 0)->innertext) ? $g->find('a.web-result-title-link', 0)->innertext : '';
				$item['description'] = isset($g->find('p.web-result-description', 0)->innertext) ? $g->find('p.web-result-description', 0)->innertext : '';
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
				if ( $related == true ) :
					$output .= '<h3 class="ktzplg-title-related">' . __('Related posts to ','ktzagcplugin');
					$output .= $keyword;
					$output .= '</h3>';
					$output .= '<ul class="ktzplg-list-agcplugin">';
					foreach($result as $r)
					{
						$output .= '<li>';
						if ( !empty ($r['title']) ) {
							
							$result_title = ktzplg_filter_badwords( $r['title'] );	
							$result_title = sanitize_title($result_title);
							$result_title = str_replace('-',' ', $result_title);
							$result_title = ktzplg_plugin_clean_character($result_title);
							$result_title = ucwords($result_title);
							$output .= '<h3><a href="'; 
							$output .= ktzplg_permalink( $result_title, $choice = 'default' );
							$output .= '" title="' . __('Permalink to ','ktzagcplugin') . $result_title . '">'; 
							$output .= $result_title;
							$output .= '</a></h3>'; 
							
						}
						if ( !empty ($r['description']) ) {
							
							$result_desc = ktzplg_filter_badwords( $r['description'] );					
							$output .= '<p>' . ucfirst(ktzplg_plugin_clean_character($result_desc)) . '.</p>'; 
							
						}
						$output .= '</li>';
						if(++$i==$num) break;
					}
					$output .= '</ul>';
				else :
					$output .= '<p>';
					foreach($result as $r)
					{
						if ( !empty ($r['description']) ) {
							
							$result = ktzplg_filter_badwords( $r['description'] );
							
							# ktzplg_plugin_clean_character find in _functions.php
							$output .= ucfirst(ktzplg_plugin_clean_character($result)) . '.'; 
							
						}
						if(++$i==$num) break;
					}
					$output .= '</p>';
				endif;
			}
		} 
		return $output;
	} /* End ktzplg_get_ask_article */
	add_action('ktzplg_get_ask_article', 'ktzplg_get_ask_article', 10, 3);
}

/*
 *************************************************************************************
 ********************************* Start bing.com Article ****************************
 *************************************************************************************
 */

if ( !function_exists('ktzplg_get_bing_article') ) {
	/* 
	 * Bing Article Scrape
	 */
	function ktzplg_get_bing_article( $keyword, $num = 4, $related = false ) {
		
		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(' ', '+', $keyword ) : '';
		 
		/* 
		 * @str_get_html Simple HTML DOM and get url via ktzplg_fetch_agc ( curl and fopen )
		 * ktzplg_fetch_agc find in _functions.php
		 */
		$fetch = ktzplg_fetch_agc( 'http://www.bing.com/search?q='.$keywords );
		
		$html = new simple_html_dom();
		
		$html->load($fetch); //Simple HTML now use the result craped by cURL.
		 
		$result = array();
		if( $html && is_object($html) )
		{
			foreach($html->find('li.b_algo') as $g)
			{
				/*
				 * each search results are in a list item with a class name 'g'
				 * we are seperating each of the elements within, into an array
				 * Summaries are stored in a p
				 * Summaries are stored in h2 a
				 */
				$item['title'] = isset($g->find('h2 a', 0)->innertext) ? $g->find('h2 a', 0)->innertext : '';
				$item['description'] = isset($g->find('p', 0)->innertext) ? $g->find('p', 0)->innertext : '';
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
				if ( $related == true ) :
					$output .= '<h3 class="ktzplg-title-related">' . __('Related posts to ','ktzagcplugin');
					$output .= $keyword;
					$output .= '</h3>';
					$output .= '<ul class="ktzplg-list-agcplugin">';
					foreach($result as $r)
					{
						$output .= '<li>';
						if ( !empty ($r['title']) ) {
							
							$result_title = ktzplg_filter_badwords( $r['title'] );	
							$result_title = sanitize_title($result_title);
							$result_title = str_replace('-',' ', $result_title);
							$result_title = ktzplg_plugin_clean_character($result_title);
							$result_title = ucwords($result_title);
							$output .= '<h3><a href="'; 
							$output .= ktzplg_permalink( $result_title, $choice = 'default' );
							$output .= '" title="' . __('Permalink to ','ktzagcplugin') . $result_title . '">'; 
							$output .= $result_title;
							$output .= '</a></h3>'; 
							
						}
						if ( !empty ($r['description']) ) {
							
							$result_desc = ktzplg_filter_badwords( $r['description'] );					
							$output .= '<p>' . ucfirst(ktzplg_plugin_clean_character($result_desc)) . '.</p>'; 
							
						}
						$output .= '</li>';
						if(++$i==$num) break;
					}
					$output .= '</ul>';
				else :
				$output .= '<p>';
				foreach($result as $r)
				{
					if ( !empty ($r['description']) ) {
						
						# ktzplg_plugin_clean_character find in _functions.php
						$result = ktzplg_filter_badwords( $r['description'] );
						$output .= ucfirst(ktzplg_plugin_clean_character($result)) . '.'; 
						
					}
					if(++$i==$num) break;
				}
				$output .= '</p>';
				endif;
			}
		} 
		return $output;
	} /* End ktzplg_get_bing_article */
	add_action('ktzplg_get_bing_article', 'ktzplg_get_bing_article', 10, 3);
}

/*
 *************************************************************************************
 ********************** Start bing.com Article with format RSS ***********************
 *************************************************************************************
 */

if ( !function_exists('ktzplg_get_bingrss_article') ) {
	/* 
	 * Bing Rss Article Scrape
	 * This Function From Bing RSS in theme agcsuper
	 */
	function ktzplg_get_bingrss_article( $keyword, $num = 4, $related = false ) {
		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(' ', '+', $keyword ) : '';
		/*
		 * This is BING XML where the picture come from. :D
		 */
		$xmlbing = array('http://www.bing.com/search?q='.$keywords.'&go=&form=QBLH&filt=all&format=rss');
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
						if ( $related == true ) :
							$output .= '<h3 class="ktzplg-title-related">' . __('Related posts to ','ktzagcplugin');
							$output .= $keyword;
							$output .= '</h3>';
							$output .= '<ul class="ktzplg-list-agcplugin">';
							foreach ($bing_result as $bing_results)
							{
								$output .= '<li>';
								$result_title = ktzplg_filter_badwords( $bing_results->get_title() );	
								$result_title = sanitize_title($result_title);
								$result_title = str_replace('-',' ', $result_title);
								$result_title = ktzplg_plugin_clean_character($result_title);
								$result_title = ucwords($result_title);
								$output .= '<h3><a href="'; 
								$output .= ktzplg_permalink( $result_title, $choice = 'default' );
								$output .= '" title="' . __('Permalink to ','ktzagcplugin') . $result_title . '">'; 
								$output .= $result_title;
								$output .= '</a></h3>'; 
									
								/* 
								 * ktzplg_plugin_clean_character find in _functions.php
								 */
								$result_desc = ktzplg_filter_badwords( $bing_results->get_description() );
								$output .= '<p>' . ucfirst(ktzplg_plugin_clean_character($result_desc)) . '.</p>';
								$output .= '</li>';
							}
							$output .= '</ul>';
						else :
							$output .= '<p>';
							foreach ($bing_result as $bing_results) {
								/* 
								 * ktzplg_plugin_clean_character find in _functions.php
								 */
								$result = ktzplg_filter_badwords( $bing_results->get_description() );
								$output .= ucfirst(ktzplg_plugin_clean_character($result)) . '.';
							}
							$output .= '</p>';
						endif;
					}
				endif;
			}
		}
		return $output;
	}/* End ktzplg_get_bingrss_article */
	add_action('ktzplg_get_bingrss_article', 'ktzplg_get_bingrss_article', 10, 3);
}