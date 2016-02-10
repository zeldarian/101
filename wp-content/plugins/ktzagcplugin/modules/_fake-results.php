<?php
/**
 * The file that defines all  necessery fake results in post page and search page if no content.
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 */

/**
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 * @author     Gian MR <g14nblog@gmail.com>
 */

/***************************************************************************
 ******************** Link fixed always have link post *********************
 **************************************************************************/

function ktzplg_link_more_clean( $flink ) {
	# first check for the original slug - use the wordpress slug fixer on it.
	if (strpos(strtolower($flink)."\t","/index.html\t")!==false) $flink=substr($flink."\t",0,strpos(strtolower($flink)."\t","/index.html\t"));
	if (strpos(strtolower($flink)."\t","/index.htm\t")!==false) $flink=substr($flink."\t",0,strpos(strtolower($flink)."\t","/index.htm\t"));
	if (strpos(strtolower($flink)."\t","/index.shtml\t")!==false) $flink=substr($flink."\t",0,strpos(strtolower($flink)."\t","/index.shtml\t"));
	if (strpos(strtolower($flink)."\t","/default.asp\t")!==false) $flink=substr($flink."\t",0,strpos(strtolower($flink)."\t","/default.asp\t"));
	$flink = basename($flink);
		
	# get dir of html and shtml at the end - don't need to search for these
	$flink = str_replace('.html','',$flink); 
	$flink = str_replace('.shtml','',$flink); 
	$flink = str_replace('.htm','',$flink); 
		
	# underscores should be dashes
	$flink = str_replace('_','-',$flink); 
		
	# periods should be dashes
	$flink = str_replace('.','-',$flink);  
		
	# spaces are wrong
	$flink = str_replace(' ','-',$flink); 
		
	# spaces are wrong
	$flink = str_replace('%20','-',$flink); 
	$flink = str_replace('http://','',$flink);
	$flink = str_replace('https://','',$flink);
	$flink = esc_url($flink);
	$flink = str_replace('http://','',$flink);
	$flink = str_replace('https://','',$flink);
		
	# spaces are wrong
	$flink = str_replace('%22','-',$flink); 
		
	# spaces are wrong
	$flink = str_replace('"','-',$flink); 
	
	return $flink;
}

# load a post based on my Static-Pages Plugin.
function ktzplg_load_post( $ID, $flink ) {
	global $wp_query;
	
	if (empty($wp_query)) {
		# create a new $wp_query?
		$wp_query = new WP_Query();
	}

	if (!empty($flink)) {
		$title = sanitize_title( $flink );
		$title = str_replace('-',' ', $title);
		$title = ucwords( $title );
	} else {
		$title = '';
	}
	
	$post = get_post($ID);
	
	if ( empty($post) && !empty($flink) ) {
		# option AGC single
		$content = Ktzagcplugin_Option::get_option( 'ktzplg_agc_content' );
		$content = do_shortcode( $content );
		
		$status = Ktzagcplugin_Option::get_option( 'ktzplg_autopost_status' );
		
		$category_id = Ktzagcplugin_Option::get_option( 'ktzplg_autopost_category' );
		
		$format = get_option('date_format') . ' ' . get_option('time_format');
		$post_date = date_i18n($format, current_time('timestamp'));
		
		# New Post object
		$post = new stdClass();
		$post->post_title = $title;
		
		
		# Add post_date
		$post->post_date = $post_date;
		
		# Add some categories. an array()???
		$post->post_category = array( 1 ); 
		
		$post->post_author = 1; 
		
		# Set the status of the new post.
		$post->post_status = 'publish';
		
		# Sometimes you might want to post a page.
		$post->post_type = 'post'; 
		
		$post->comment_status = 'closed';
		
		$post->post_content = $content;
		
		/*
		 * Auto insert post for search result
		 */
		
		/* Prevent duplicate post - If not duplicate title
		sangat berat dan akan terposting otomatis tanpa ada filter termasuk ping, cape deh... 
		Ane nonaktifkan saja, tolong jangan diaktifkan fitur ini lagi gaes.
		
		if (!get_page_by_title($title, 'OBJECT', 'post')) :
			$autopost_option = Ktzagcplugin_Option::get_option( 'ktzplg_autopost_agccontent' );
			if ( $autopost_option == 1 ) :
				# Insert post => ktzplg_insert_post ( $post_type='', $title = '', $status = '', $category_id = array() , $content = '', $author = '' );
				ktzplg_insert_post ( $post->post_type, $post->post_title, $status, array( $category_id ) , $content, $post->post_author );
			endif;
		endif;
		*/
		
	}
	
	$wp_query->queried_object = $post;
	$wp_query->post = $post;
	$wp_query->current_post = 0;
	$wp_query->is_404 = false;	
	$wp_query->is_post = true;
	$wp_query->is_page = true;
	$wp_query->in_the_loop = true;
	$wp_query->is_archive = false;
	$wp_query->posts = array($post);
	$wp_query->is_single = 1;
	$wp_query->found_posts = 1;
	$wp_query->post_count = 1;
	$wp_query->max_num_pages = 1;

	if ( !have_posts() ) {
	  # echo "<!-- have posts fails -->";
	}
	
	/* 
	 * find the correct template for this post
	 * stolen from template-redirect 
	 */
	$td = get_template_directory();
	$template = $td.'/single.php';
	# $template = get_index_template();
	# if ( $template = apply_filters( 'template_include', $template ) )
	include( $template );
	
	return $post;

}

/* 
 * If post ID = 0 this will add canonical in <head>
 */
function ktzplg_showCanonicalLink( $ID ) {

	$post = get_post($ID);
	
	# fix request_uri on IIS
	if (!array_key_exists('REQUEST_URI',$_SERVER)) {
		$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
		if (isset($_SERVER['QUERY_STRING'])) {
			$_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING']; 
		}
	}	
	
	
	$plink = $_SERVER['REQUEST_URI'];
	$pulink = $plink;
	
	$plink = trim($plink,'/');
	
	# flink has the page that was 404'd - not the basename
	$flink = $plink; 
	
	# More clean
	$flink = ktzplg_link_more_clean( $flink );
	
	$title = str_replace( '-', ' ', $flink);
	
	$keyword = str_replace( '-', ',', $flink);
	
	$content = $post->post_content;
	
	if ( empty($post) && !empty($flink) ) {
		$ktzplg_metadata_arg[] = '<meta name="description" content="' . $title . '" />';
		$ktzplg_metadata_arg[] = '<meta name="keywords" content="' . $keyword . '" />';
		$ktzplg_metadata_arg[] = '<meta content="index,follow" name="robots" />';
		$ktzplg_metadata_arg[] = '<meta content="2 days" name="revisit-after" />';
		$ktzplg_metadata_arg[] = '<meta content="2 days" name="revisit" />';
		$ktzplg_metadata_arg[] = '<meta content="never" name="expires" />';
		$ktzplg_metadata_arg[] = '<meta content="always" name="revisit" />';
		$ktzplg_metadata_arg[] = '<meta content="global" name="distribution" />';
		$ktzplg_metadata_arg[] = '<meta content="general" name="rating" />';
		$ktzplg_metadata_arg[] = '<meta content="true" name="MSSmartTagsPreventParsing" />';
		$ktzplg_metadata_arg[] = '<meta content="index, follow" name="googlebot" />';
		$ktzplg_metadata_arg[] = '<meta content="follow, all" name="Googlebot-Image" />';
		$ktzplg_metadata_arg[] = '<meta content="follow, all" name="msnbot" />';
		$ktzplg_metadata_arg[] = '<meta content="follow, all" name="Slurp"/>';
		$ktzplg_metadata_arg[] = '<meta content="follow, all" name="ZyBorg"/>';
		$ktzplg_metadata_arg[] = '<meta content="follow, all" name="Scooter"/>';
		$ktzplg_metadata_arg[] = '<meta content="all" name="spiders"/>';
		$ktzplg_metadata_arg[] = '<meta content="all" name="WEBCRAWLERS"/>';
		$ktzplg_metadata_arg[] = '<meta content="no" http-equiv="imagetoolbar"/>';
		$ktzplg_metadata_arg[] = '<meta content="no-cache" http-equiv="cache-control"/>';
		$ktzplg_metadata_arg[] = '<meta content="no-cache" http-equiv="pragma"/>';
		$ktzplg_metadata_arg[] = '<meta content="aeiwi, alexa, alltheWeb, altavista, aol netfind, anzwers, canada, directhit, euroseek, excite, overture, go, google, hotbot. infomak, kanoodle, lycos, mastersite, national directory, northern light, searchit, simplesearch, Websmostlinked, webtop, what-u-seek, aol, yahoo, webcrawler, infoseek, excite, magellan, looksmart, bing, cnet, googlebot" name="search engines" />';
		$ktzplg_metadata_arg[] = '<link rel="canonical" content="' . home_url('/') . $flink . '.html" />';
		$ktzplg_metadata_arg[] = '<meta property="og:url" content="' . home_url('/') . $flink . '.html" />';
		$ktzplg_metadata_arg[] = '<meta property="og:type" content="article" />';
		$ktzplg_metadata_arg[] = '<meta property="og:site_name" content="'. get_bloginfo('name') . '" />';
		$ktzplg_metadata_arg[] = '<meta property="og:title" content="' . $title . '" />';
		$ktzplg_metadata_arg[] = '<meta property="og:description" content="' . $keyword . '" />';
		$ktzplg_metadata_arg[] = '';
		echo implode( "\n", $ktzplg_metadata_arg );
	}
	
}
add_action('wp_head', 'ktzplg_showCanonicalLink' );

/* 
 * Guts of the plugin. This is where we do the redirect. We are already in a 404 before we get here.
 * Function from plugin https://wordpress.org/plugins/permalink-finder/
 */
function ktzplg_permalink_fixer() {
	
	# fix request_uri on IIS
	if (!array_key_exists('REQUEST_URI',$_SERVER)) {
		$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
		if (isset($_SERVER['QUERY_STRING'])) {
			$_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING']; 
		}
	}
	
	$plink = $_SERVER['REQUEST_URI'];
	$pulink = $plink;
	
	// keeping the query - there is a chance that there is a query variable that needs to be preserved.
	// possibly a search or an update has been bookmarked.
	if (strpos($plink,'/feed/')!==false) return;
	$query='';
	if (strpos($plink,'?')!==false) {
		$query=substr($plink,strpos($plink,'?'));
		$plink=substr($plink,0,strpos($plink,'?'));
	}
	// do not redirect search queries
	if (strpos('?'.$query,'?s=')!==false) return;
	if (strpos($query,'&s=')!==false) return;
	if (strpos($plink,'#')!==false)  $plink=substr($plink,0,strpos($plink,'#'));
	$plink=trim($plink,'/');
	$flink= $plink; // flink has the page that was 404'd - not the basename
	
	/* 
	 * keeping the query - there is a chance that there is a query variable that needs to be preserved.
	 * possibly a search or an update has been bookmarked.
	 */
	if (strpos($plink,'/feed/')!==false) return;

	$plink = trim($plink,'/');
	
	# flink has the page that was 404'd - not the basename
	$flink = $plink; 
	
	# More clean
	$flink = ktzplg_link_more_clean( $flink );

	header("HTTP/1.1 200 Ok");
	if ( ktzplg_load_post( $ID, $flink ) ) exit();

	return; // end of permalink fixer
}

/* 
 * set up the main action firs
 * this hooks template redirect where it detects the 404 error and does a redirect
 * ktzplg_permalink_finder is the main action. 
 * it checks to see if the includes file exists and then includes it.
 */
 
function ktzplg_permalink_finder() {
	# if we made it here, remove the redundant actions
	if (!is_404()) return;
	remove_action('template_redirect', 'ktzplg_permalink_finder');
	
	# Only loaded on a 404
	ktzplg_permalink_fixer(); 
	# if we are redirecting we will be back. if not return for legit 404
	return; 
}
add_action( 'template_redirect', 'ktzplg_permalink_finder' ); 

/***************************************************************************
 ******************** Fake search results if no results ********************
 **** Code From Google CSE Plugin: https://wordpress.org/plugins/google-cse/
 **************************************************************************/
 
/**
 * Google API Request
 * @param boolean $test
 * @return array
 */
function ktzplg_search_request( $posts, $q ) {
	if($q->is_single !== true && $q->is_search === true) {
		global $wp_query;
		$query = html_entity_decode(get_search_query());
		
		# Set query if any passed
		$keywords = isset( $query ) ? str_replace(' ', '+', $query ) : '';
			 
		/* 
		 * @str_get_html Simple HTML DOM and get url via ktzplg_fetch_agc ( curl and fopen )
		 * ktzplg_fetch_agc find in _functions.php
		 */
		# option source AGC in search page
		$agcsource_option = Ktzagcplugin_Option::get_option( 'ktzplg_agc_searchresults' );
		
		if ($agcsource_option == 'bing') :
			$fetch = ktzplg_fetch_agc( 'http://www.bing.com/search?q='.$keywords );
		elseif ($agcsource_option == 'ask') :
			$fetch = ktzplg_fetch_agc( 'http://www.ask.com/web?q='.$keywords );
		else :
			$fetch = ktzplg_fetch_agc( 'http://www.google.com/search?hl=en&q='.$keywords );
		endif;
		
		$html = new simple_html_dom();
		
		$html->load($fetch); //Simple HTML now use the result craped by cURL.
		
		$result = array();
		if( $html && is_object($html) )
		{
			if ($agcsource_option == 'bing') :
			
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
				
			elseif ($agcsource_option == 'ask') :
			
				foreach($html->find('div.web-result') as $g)
				{
					/*
					 * each search results are in a list item with a class name 'g'
					 * we are seperating each of the elements within, into an array
					 * Summaries are stored in a p with a classname of 'web-result-description'
					 * title are stored in a with a classname of 'web-result-title-link'
					 */
					$item['title'] = isset($g->find('a.web-result-title-link', 0)->innertext) ? $g->find('a.web-result-title-link', 0)->innertext : '';
					$item['description'] = isset($g->find('.web-result-description', 0)->innertext) ? $g->find('.web-result-description', 0)->innertext : '';
					$result[] =  $item;
				}
				
			else :
				
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
			
			endif; # endif $agcsource_option
			
			// Clean up memory
			$html->clear();
			unset($html);
			
			/* 
			 * Otherwise it prints out the array structure so that it
			 * is more human readible. You could instead perform a 
			 * foreach loop on the variable $result so that you can 
			 * organize the html output, or insert the data into a database
			 */
			if($result)
			{

				$results = array();
				$i = 0;
				foreach($result as $r) {
					
					$post = get_post($ID);
					$result_title = ktzplg_filter_badwords( $r['title'] );	
					$result_title = sanitize_title($result_title);
					$result_title = str_replace('-',' ', $result_title);
					$result_title = ktzplg_plugin_clean_character($result_title);
					$result_title = ucwords($result_title);
					$result_desc = ktzplg_filter_badwords( $r['description'] );	
					
					$format = get_option('date_format') . ' ' . get_option('time_format');
					$post_date = date_i18n($format, current_time('timestamp'));
					
					if ( empty($post) ) {
						$post = (object)array(
							'post_type'      => 'post',
							'post_title'     => $result_title,
							'post_date'      => $post_date,
							'post_category'  =>  1,
							'post_author' 	 =>  1,
							'post_status'    => 'published',
							'post_excerpt'   => $result_desc,
							'post_content'   => $result_desc,
							'guid'           => ktzplg_permalink( $result_title, $choice = 'default' ),
							'ID'             => 0,
							'comment_status' => 'closed'
						);
					}
					
					if(++$i==8) break;
					$results[] = $post;
					
				}

				$post = '';
				// Set results as posts
				$posts = $results;
				$results = '';
				// Update post count
				$wp_query->post_count = count($posts);

				$wp_query->found_posts = 8;

				// Apply filters
				add_filter('the_permalink', 'ktzplg_search_permalink');
				add_filter('post_link', 'ktzplg_search_permalink');
			}
		}
	} 
	return $posts;
}


if(!is_admin()) {
	
	# option source AGC in search page
	$agcsource_option = Ktzagcplugin_Option::get_option( 'ktzplg_agc_searchresults' );
	if ($agcsource_option != 'disable') :
		// Modifies results directly after query is made
		add_filter('posts_results', 'ktzplg_search_request', 99, 2);
	endif;
	
}

/**
 * Permalink Filter
 * @param string $the_permalink
 * @return string
 */
function ktzplg_search_permalink( $the_permalink ) {
    if(function_exists('is_main_query') && is_main_query() && $the_permalink == '') {
        global $post;
        return $post->guid;
    }
    else {
        return $the_permalink;
    }
}