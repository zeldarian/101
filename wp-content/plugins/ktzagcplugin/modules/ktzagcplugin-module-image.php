<?php
/**
 * The file that defines the image scraper
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 */

/**
 * Ktzplugin module image
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
 ************************************* Start Bing Image ******************************
 *************************************************************************************
 */
 
if ( !function_exists('ktzplg_get_bing_image') ) {
	/* 
	 * bing Image Scrape 
	 */
	function ktzplg_get_bing_image( $keyword, $max_keyword = '', $num = 1, $related = false, $license = '' ) {

		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(array(' ', '-'), '+', $keyword ) : '';
		
		// Add license filter to query
		if ( $license == 'free_to_use' ) {
			$qlicense = '&qft=+filterui:license-L2_L3_L4_L5_L6_L7';
		} elseif ( $license == 'free_to_use_commercial' ) {
			$qlicense = '&qft=+filterui:license-L2_L3_L4';
		} elseif ( $license == 'free_to_modify_use' ) {
			$qlicense = '&qft=+filterui:license-L2_L3_L5_L6';
		} elseif ( $license == 'free_to_modify_use_commercial' ) {
			$qlicense = '&qft=+filterui:license-L2_L3';
		} elseif ( $license == 'public_domain' ) {
			$qlicense = '&qft=+filterui:license-L1';
		} else{
			$qlicense = '';
		}
		
		
		// Add maximal number keyword in search query
		if ( $max_keyword != '' ) {
			$max_keywords = (int)$max_keyword;
			$keywords_5_first = isset( $keyword ) ? implode( ' ', array_splice( explode( ' ', $keyword ), 0, $max_keywords ) ) : '';
			$keywords = isset( $keywords_5_first ) ? str_replace(array(' ', '-'), '+', $keywords_5_first ) : '';
		}
		 
		/* 
		 * @str_get_html Simple HTML DOM and get url via ktzplg_fetch_agc ( curl and fopen )
		 * ktzplg_fetch_agc find in _functions.php
		 */
		$fetch = ktzplg_fetch_agc( 'http://www.bing.com/images/search?q='.$keywords.$qlicense );
		 
		$html = new simple_html_dom();
		
		$html->load( $fetch ); //Simple HTML now use the result craped by cURL.
		 
		$result = array();
		if( $html && is_object($html) )
		{
			foreach($html->find('div[class="dg_b"] div[class="dg_u"]') as $gm)
			{
				/*
				 * each search results are in a list item with a class name '$gm'
				 * we are seperating each of the elements within, into an array
				 */
			
				# Find element a with m attribute where json code can find in div.dg_u
				$get_m_attr = $gm->find('a', 0)->m;
				
				# Fixed json code
				$get_m_attr = ktzplg_fix_json( stripslashes ( html_entity_decode( $get_m_attr ) ) );
				
				# Decode json
				$get_json_m = json_decode( $get_m_attr,true );
				
				# Get link with key surl in json code
			    $item['link'] = $get_json_m['surl'];
				
				# Get imgurl with key imgurl in json code
				$item['imgsrc'] = $get_json_m['imgurl'];
				
				# Get attribute t1 in a that is title image in bing search
				$item['title'] = $gm->find('a', 0)->t1;
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
					$output .= '<h3 class="ktzplg-title-related">' . __('Related images to ','ktzagcplugin');
					$output .= $keyword;
					$output .= '</h3>';
					$output .= '<ul class="ktzplg-list-image-agcplugin">';
					foreach($result as $r)
					{
						$output .= '<li>';
						if ( !empty ($r['imgsrc']) ) {
							
							$result_title = ktzplg_filter_badwords( $r['title'] );	
							$result_title = sanitize_title($result_title);
							$result_title = str_replace('-',' ', $result_title);
							$result_title = ktzplg_plugin_clean_character($result_title);
							$result_title = ucwords($result_title);
							$output .= '<a href="'; 
							$output .= ktzplg_permalink( $result_title, $choice = 'default' );
							$output .= '" title="' . __('Permalink to ','ktzagcplugin') . $result_title . '">'; 
							$output .= '<img src="';
							if ( !empty ($r['imgsrc']) ) {
								
								$output .= $r['imgsrc']; 
							
							}
							$output .= '"'; 
							if ( !empty ($r['title']) ) {
								$output .= ' alt="' . $result_title . '" title="' . $result_title . '"';
							}
							$output .= ' />';
							$output .= '</a>'; 
							
						}
						$output .= '</li>';
						if(++$i==$num) break;
					}
					$output .= '</ul>';
				else :
					foreach($result as $r)
					{
						$output .= '<div class="wp-caption aligncenter">';
							$output .= '<img src="';
							if ( !empty ( $r['imgsrc'] ) ) {
								$output .= $r['imgsrc']; 
							}
							$output .= '"'; 
							if ( !empty ($r['title']) ) {
								$result_title = ktzplg_filter_badwords( $r['title'] );	
								$result_title = sanitize_title($result_title);
								$result_title = str_replace('-',' ', $result_title);
								$result_title = ktzplg_plugin_clean_character($result_title);
								$result_title = ucwords($result_title);
								$output .= ' alt="' . $result_title . '" title="' . $result_title . '"';
							}
							$output .= ' />';
							if ( !empty ($r['title']) ) {
								$result_title = ktzplg_filter_badwords( $r['title'] );	
								$result_title = sanitize_title($result_title);
								$result_title = str_replace('-',' ', $result_title);
								$result_title = ktzplg_plugin_clean_character($result_title);
								$result_title = ucwords($result_title);
								$output .= '<p class="wp-caption-text">'. $result_title .'</p>';
							}
						$output .= '</div>';
						if(++$i==$num) break;
					}
				endif;
			}
		}
		return $output;
	} /* End ktzplg_get_bing_image */
	add_action('ktzplg_get_bing_image', 'ktzplg_get_bing_image', 10, 5);
}

/*
 *************************************************************************************
 ********************************** Start Ask.com Image ******************************
 *************************************************************************************
 */

if ( !function_exists('ktzplg_get_ask_image') ) {
	/* 
	 * Ask.com Image Scrape 
	 */
	function ktzplg_get_ask_image( $keyword, $max_keyword = '', $num = 1, $related = false ) {

		//Set query if any passed
		$keywords = isset( $keyword ) ? str_replace(' ', '+', $keyword ) : '';
		
		// Add maximal number keyword in search query
		if ( $max_keyword != '' ) {
			$max_keywords = (int)$max_keyword;
			$keywords_5_first = isset( $keyword ) ? implode( ' ', array_splice( explode( ' ', $keyword ), 0, $max_keywords ) ) : '';
			$keywords = isset( $keywords_5_first ) ? str_replace(array(' ', '-'), '+', $keywords_5_first ) : '';
		}
		 
		/* 
		 * @str_get_html Simple HTML DOM and get url via ktzplg_fetch_agc ( curl and fopen )
		 * ktzplg_fetch_agc find in _functions.php
		 */
		$fetch = ktzplg_fetch_agc( 'http://www.ask.com/pictures?q='.$keywords );
		
		$html = new simple_html_dom();
		
		$html->load($fetch); //Simple HTML now use the result craped by cURL.
		 
		$result = array();
		if( $html && is_object($html) )
		{
			foreach($html->find('div[class="picturesContainer"] div[class="picturesItem"]') as $gm)
			{
				/*
				 * each search results are in a list item with a class name '$gm'
				 * we are seperating each of the elements within, into an array
				 */
			
				# Find element a with data-imageurl attribute where image url can find there
				$get_href_attr = $gm->getAttribute( 'data-imageurl' );
				
				# Find element a with data-imagetitle attribute where image title can find there
				$get_title_attr = $gm->getAttribute( 'data-imagetitle' );
				
				# Get query imgrefurl
				$item['imgsrc'] = $get_href_attr;
				
				$item['title'] = $get_title_attr;

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
					$output .= '<h3 class="ktzplg-title-related">' . __('Related images to ','ktzagcplugin');
					$output .= $keyword;
					$output .= '</h3>';
					$output .= '<ul class="ktzplg-list-image-agcplugin">';
					foreach($result as $r)
					{
						$output .= '<li>';
						if ( !empty ($r['imgsrc']) ) {
							
							$result_title = ktzplg_filter_badwords( $r['title'] );	
							$result_title = sanitize_title($result_title);
							$result_title = str_replace('-',' ', $result_title);
							$result_title = ktzplg_plugin_clean_character($result_title);
							$result_title = ucwords($result_title);
							$output .= '<a href="'; 
							$output .= ktzplg_permalink( $result_title, $choice = 'default' );
							$output .= '" title="' . __('Permalink to ','ktzagcplugin') . $result_title . '">'; 
							$output .= '<img src="';
							if ( !empty ($r['imgsrc']) ) {
								
								$output .= $r['imgsrc']; 
								
							}
							$output .= '"'; 
							if ( !empty ($r['title']) ) {
								$output .= ' alt="' . $result_title . '" title="' . $result_title . '"';
							}
							$output .= ' />';
							$output .= '</a>'; 
							
						}
						$output .= '</li>';
						if(++$i==$num) break;
					}
					$output .= '</ul>';
				else :
					foreach($result as $r)
					{
						$output .= '<div class="wp-caption aligncenter">';
							$output .= '<img src="';
							if ( !empty ($r['imgsrc']) ) {
								
								$output .= $r['imgsrc']; 
							
							}
							$output .= '"'; 
							if ( !empty ($r['title']) ) {
								$result_title = ktzplg_filter_badwords( $r['title'] );	
								$result_title = sanitize_title($result_title);
								$result_title = str_replace('-',' ', $result_title);
								$result_title = ktzplg_plugin_clean_character($result_title);
								$result_title = ucwords($result_title);
								$output .= ' alt="' . $result_title . '" title="' . $result_title . '"';
							}
							$output .= ' />';
							if ( !empty ($r['title']) ) {
								$result_title = ktzplg_filter_badwords( $r['title'] );	
								$result_title = sanitize_title($result_title);
								$result_title = str_replace('-',' ', $result_title);
								$result_title = ktzplg_plugin_clean_character($result_title);
								$result_title = ucwords($result_title);
								$output .= '<p class="wp-caption-text">'. $result_title .'</p>';
							}
						$output .= '</div>';
						if(++$i==$num) break;
					}
				endif;
			}
		
		}
		return $output;
	} /* End ktzplg_get_ask_image */
	add_action('ktzplg_get_ask_image', 'ktzplg_get_ask_image', 10, 4);
}