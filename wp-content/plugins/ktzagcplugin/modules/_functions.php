<?php
/**
 * The file that defines all  necessery function for scrapper
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
 
/* 
 * Add functionally wp_insert_post using function
 * @return $post_ID
 */
function ktzplg_insert_post ( $ktzplg_post_type = '', $title = '', $status = '', $category_id = array() , $content = '', $author = '' ) {
	
	# Post type
	if( $ktzplg_post_type == 'post' ) {
		$post_type_ktz = 'post';
	} elseif ( $ktzplg_post_type == 'page' ) {
		$post_type_ktz = 'page';
	} else {
		$post_type_ktz = 'post';
	}
	
	# Post status
	if( $status == 'publish' ) {
		$status_ktz = 'publish';
	} elseif ( $status == 'draft' ) {
		$status_ktz = 'draft';
	} else {
		$status_ktz = 'publish';
	}
	
	# category_id
	if( empty( $category_id ) ) {
		$category_id_ktz = array(1);
	} else {
		$category_id_ktz = $category_id;
	}
	
	# Content
	if( empty( $content ) ) {
		$content_ktz = '';
	} else {
		$content_ktz = $content;
	}
	
	# Author
	if( empty( $author ) ) {
		$author_ktz = 1;
	} else {
		$author_ktz = $author;
	}

	$ktz_insert_post = array(
		'post_type' => $post_type_ktz,
		'post_title' => $title,
		'post_status' => $status_ktz,
		'post_category' => $category_id_ktz,
		'post_content' => $content_ktz,
		'post_author' => $author_ktz
	);
	$post_ID =  wp_insert_post( $ktz_insert_post );
	
	return $post_ID;							
}

/* 
 * Clean all character in content results
 * @return $results
 */
function ktzplg_plugin_clean_character( $result ) {	

	$result = trim($result);
	
	/*
	 * Remove class=f and inner content
	 */
	$result = preg_replace( '/<(span).*?class="\s*(?:.*\s)?f(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '', $result );
	
	/*
	 * Remove date format in string
	 * http://php.net/manual/en/function.preg-replace.php
	 */
	$result = preg_replace('/(\d+) (\w+) (\d+)/i', '', $result);
	$result = preg_replace('/(\w+) (\d+), (\d+)/i', '', $result);

	/*
	 * Remove html in string
	 * https://php.net/strip_tags
	 */
	$result = strip_tags($result);
	
    // 1) convert á ô => a o
    $result = preg_replace("/[áàâãªä]/u","a",$result);
    $result = preg_replace("/[ÁÀÂÃÄ]/u","A",$result);
    $result = preg_replace("/[ÍÌÎÏ]/u","I",$result);
    $result = preg_replace("/[íìîï]/u","i",$result);
    $result = preg_replace("/[éèêë]/u","e",$result);
    $result = preg_replace("/[ÉÈÊË]/u","E",$result);
    $result = preg_replace("/[óòôõºö]/u","o",$result);
    $result = preg_replace("/[ÓÒÔÕÖ]/u","O",$result);
    $result = preg_replace("/[úùûü]/u","u",$result);
    $result = preg_replace("/[ÚÙÛÜ]/u","U",$result);
    $result = preg_replace("/[’‘‹›‚]/u","'",$result);
    $result = preg_replace("/[“”«»„]/u",'"',$result);
    $result = str_replace("–","-",$result);
    $result = str_replace(" "," ",$result);
    $result = str_replace("ç","c",$result);
    $result = str_replace("Ç","C",$result);
    $result = str_replace("ñ","n",$result);
    $result = str_replace("Ñ","N",$result);
 
    //2) Translation CP1252. &ndash; => -
    $trans = get_html_translation_table(HTML_ENTITIES); 
    $trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark 
    $trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook 
    $trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark 
    $trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis 
    $trans[chr(134)] = '&dagger;';    // Dagger 
    $trans[chr(135)] = '&Dagger;';    // Double Dagger 
    $trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent 
    $trans[chr(137)] = '&permil;';    // Per Mille Sign 
    $trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron 
    $trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark 
    $trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE 
    $trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark 
    $trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark 
    $trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark 
    $trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark 
    $trans[chr(149)] = '&bull;';    // Bullet 
    $trans[chr(150)] = '&ndash;';    // En Dash 
    $trans[chr(151)] = '&mdash;';    // Em Dash 
    $trans[chr(152)] = '&tilde;';    // Small Tilde 
    $trans[chr(153)] = '&trade;';    // Trade Mark Sign 
    $trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron 
    $trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark 
    $trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE 
    $trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis 
    $trans['euro'] = '&euro;';    // euro currency symbol 
    ksort($trans); 
     
    foreach ($trans as $k => $v) {
        $result = str_replace($v, $k, $result);
    }
 
    // 3) remove <p>, <br/> ...
    $result = strip_tags($result); 
     
    // 4) &amp; => & &quot; => '
    $result = html_entity_decode($result);
     
    // 5) remove Windows-1252 symbols like "TradeMark", "Euro"...
    $result = preg_replace('/[^(\x20-\x7F)]*/','', $result); 
	$result = str_replace('#39;', '\'', $result);
     
    $targets=array('\r\n','\n','\r','\t');
    $results=array(" "," "," ","");
    $result = str_replace($targets,$results,$result);

	/*
	 * Remove URL in string
	 * http://stackoverflow.com/questions/5928951/remove-full-url-from-text
	 */
	$result = preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '', $result);
	$result = preg_replace('|www\.[a-z\.0-9]+|i', '', $result);
	
	$remove_this = array(' ....',' ...',' ..', '....','...','..', '.... ','... ','.. ','Read more', 'Show less', '%', ')', '&','-. -', '(');
	$result     = str_replace($remove_this, ' ', $result);

	return $result;
}

/* 
 * Fixed non quote key json
 * http://stackoverflow.com/questions/6250815/parsing-json-missing-quotes-on-name
 */
function ktzplg_fix_json( $j ){
	$j = trim( $j );
	$j = ltrim( $j, '(' );
	$j = rtrim( $j, ')' );
	$a = preg_split('#(?<!\\\\)\"#', $j );
	for( $i=0; $i < count( $a ); $i+=2 ){
		$s = $a[$i];
		$s = preg_replace('#([^\s\[\]\{\}\:\,]+):#', '"\1":', $s );
		$a[$i] = $s;
	}
	//var_dump($a);
	$j = implode( '"', $a );
	//var_dump( $j );
	return $j;
}

/*
 * Do not cache kentooz AGC with transient. :P
 */
function ktzplg_do_not_cache_feeds(&$feed) {
	$feed->enable_cache(false);
}
add_action( 'wp_feed_options', 'ktzplg_do_not_cache_feeds' );

/***************************************************************************
 ******************* Start Curl and file_get_content ***********************
 **************************************************************************/
 
/*
 * Curl function
 */ 
function ktzplg_curl_agc( $url, $referer = '', $ua = 'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/534.7 (KHTML, like Gecko) Ubuntu/10.04 Chromium/7.0.514.0 Chrome/7.0.514.0 Safari/534.7' ) {
	$ch = curl_init();
	$proxy = Ktzagcplugin_Option::get_option( 'ktzplg_curl_proxy' );
	$proxy_userpass = Ktzagcplugin_Option::get_option( 'ktzplg_curl_proxy_userpass' );
	curl_setopt($ch, CURLOPT_URL, $url);
	#proxy
	if ( !empty($proxy) ) :
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
	endif;
	
	#proxy username:pass
	if ( !empty($proxy_userpass) ) :
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_userpass);
	endif;
	
	#referer
    if ( !empty($referer) ) {
        curl_setopt($ch, CURLOPT_REFERER, $referer);
    } else {
        curl_setopt($ch, CURLOPT_REFERER, $url);
    }
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 45);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
    if ( !empty($ua) ) {
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	} else {
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	}
	
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

/*
 * Fopen function
 */ 
function ktzplg_fopen_agc( $url ) {
	$result = @file_get_contents($url, false, $context);
	return $result;
}

/*
 * Fetch url
 * @return function
 */ 
function ktzplg_fetch_agc( $url, $referer = '' ) {
	if (function_exists("curl_init")) {
		return ktzplg_curl_agc( $url, $referer );
	} elseif (ini_get("allow_url_fopen")) {
		return ktzplg_fopen_agc( $url );
	}
}

/***************************************************************************
 *************** Start build Permalink and rewrite rule ********************
 **************************************************************************/

/*
 * Generate random number and alphabate
 */ 
function ktzplg_random_numalpha($size) {
	$alpha_key = '';
	$keys = range('a', 'z');

	for ($i = 0; $i < 2; $i++) {
		$alpha_key .= $keys[array_rand($keys)];
	}

	$length = $size - 2;

	$key = '';
	$keys = range(0, 9);

	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}

	return $alpha_key . $key;
}
 
/*
 * Get first word
 */
function ktzplg_first_word( $keyword ){
	$arr = explode(' ',strtolower(trim( $keyword )) );
	return $arr[0];
}

/*
 * Get first word
 */
function ktzplg_pk_stt2_add_rewrite_rules( $wp_rewrite ){
	$rules = array(
		'default' => array(
			'rule' => 'search/(.*)\.html', 
			'index' => 1 
		),
		'rand' => array(
			'rule' => '(.*)/(.*)\.html', 
			'index' => 2
		)
	);
	foreach( $rules as $value ){
		$new_rules[$value['rule']] =  'index.php?s='.$wp_rewrite->preg_index($value['index']);
	}
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action('generate_rewrite_rules', 'ktzplg_pk_stt2_add_rewrite_rules');

// filter search query
function ktzplg_pk_stt2_filter_search_query(){
	global $wp;
	if (!empty($wp->query_vars['s'])){
		$result = str_replace('-',' ',$wp->query_vars['s']);
		$result = str_replace('.html','',$result);
		$wp->set_query_var('s', $result);
	}	
}
add_action('parse_request', 'ktzplg_pk_stt2_filter_search_query');

// Let's flush rewrite rule after activated plugin or save plugin option
function ktzplg_flush_rewrite_rules(){
   global $wp_rewrite;
   $wp_rewrite->flush_rules();
}

function ktzplg_permalink( $keyword, $choice = 'default' ){
	if ( $choice == 'default' ) :
		$keyword				= ktzplg_plugin_clean_character($keyword);
		$change 				= array('+',' ','--');
		$searchpermalink     	= home_url( '/' ) . strtolower((str_replace($change, '-', $keyword))) .'.html';
	elseif ( $choice == 'search' ) :
		$keyword				= ktzplg_plugin_clean_character($keyword);
		$change 				= array('+',' ','--');
		$searchpermalink 		= '/search/';
		$searchpermalink     	= home_url( $searchpermalink ). '' . strtolower((str_replace($change, '-', $keyword))) .'.html';
	elseif ( $choice == 'rand' ) :
		$keyword				= ktzplg_plugin_clean_character($keyword);
		$change 				= array('+',' ','--');
		// 9 character random
		$searchpermalink_rand 	= ktzplg_random_numalpha(9);
		$searchpermalink 		= '/' . $searchpermalink_rand . '/';
		$searchpermalink     	= home_url( $searchpermalink ). '' . strtolower((str_replace($change, '-', $keyword))) .'.html';
	elseif ( $choice == 'first_word' ) :
		$keyword				= ktzplg_plugin_clean_character($keyword);
		$change 				= array('+',' ','--');
		// get first keyword
		$searchpermalink_first 	= ktzplg_first_word( $keyword );
		$searchpermalink 		= '/' . $searchpermalink_first . '/';
		$searchpermalink     	= home_url( $searchpermalink ). '' . strtolower((str_replace($change, '-', $keyword))) .'.html';
	endif;
	
	return $searchpermalink;
}
add_action('ktzplg_permalink', 'ktzplg_permalink', 10, 2);

/***************************************************************************
 ************************* Add title in 404 not found **********************
 **************************************************************************/

if ( !function_exists('ktzplg_get_404_title') ) {
	/**
	 * get error page 404 title
	 * From plugin ALRP https://wordpress.org/extend/plugins/seo-alrp/
	 **/
	function ktzplg_get_404_title() {
		$basename = str_replace( array( '.php','.html','.htm' ),'',basename( $_SERVER['REQUEST_URI'] ) );
		$search = array ( '@[\/]+@', '@( \..* )@', '@[\-]+@', '@[\_]+@', '@[\s]+@', '@archives@','@( \?.* )@','/\d/' );
		$replace = array ( ' ', '', ' ', ' ', ' ', '', '','' );
		$search_term = preg_replace( $search, $replace, $basename );
		$search_term = trim( $search_term );
		return $search_term;
	}
	add_action('ktzplg_get_404_title', 'ktzplg_get_404_title');
}

/***************************************************************************
 ************************* Bad word filter *********************************
 **************************************************************************/

/**
 * Check whether the search term contain forbidden word
 * @return $term
 **/
function ktzplg_filter_badwords( $term ){
	$option = Ktzagcplugin_Option::get_option( 'ktzplg_badword' );
	# if option empty define KTZPLG_BADWORDS (default option in ktzagcplugin.php)
	$option = ( empty( $option ) ) ? KTZPLG_BADWORDS : $option;
    
	$badwords = explode(',', $option);
    
	foreach($badwords as $bad){
        $term = str_ireplace($bad .' ', '', $term);
        $term = str_ireplace(' '. $bad .' ', '', $term);
        $term = str_ireplace(' '. $bad, '', $term);
        $term = str_ireplace($bad, '.', $term);
        $term = str_ireplace($bad, ',', $term);
        $term = str_ireplace($bad, '-', $term);
    }

	return $term;
}

/**
 * Filter the page title.
 */
function ktzplg_wp_title( $title, $sep ) {
	
	// Add a page number if necessary.
	if ( is_404() )
		$title = ucwords(ktzplg_get_404_title()) . " $sep " . get_bloginfo( 'name', 'display' ); 
	
	// Add a page number if necessary.
	if ( is_search() )
		$title = get_search_query() . " $sep " . get_bloginfo( 'name', 'display' ); 

	return $title;
}
add_filter( 'wp_title', 'ktzplg_wp_title', 15, 2 );

/**
 * Generate sitemap from sitemap generator plugin.
 * http://www.benhuson.co.uk/2009/07/12/integrate-google-xml-sitemaps/
 * This functions should display in sitemap-misc.xml
 */
function ktzplg_generate_sitemap() {
	if(class_exists('GoogleSitemapGenerator')){
		$gsg = &GoogleSitemapGenerator::GetInstance();
		if( $gsg != null ) {
			# Get keyword from options
			$data_searchterm_fromoption = Ktzagcplugin_Option::get_option( 'ktzplg_rand_keyword' );
			
			if ( $data_searchterm_fromoption != '' ) :
				$numb = 1000;
				# This solution for use multiple explode
				$keyword_fromoption = explode( "\n", $data_searchterm_fromoption );
				
				$keyword_fromoption = array_slice( $keyword_fromoption, 0, $numb, true );

				foreach ($keyword_fromoption as $term) {
					$keyword = str_replace(' ','-',$term);
					$domain = get_bloginfo('url');
					$url = $domain .'/'. $keyword . '.html';
					$gsg->AddUrl($url, time(), 'Daily',0.6);

				}
			endif;
		}
	}
}
add_action('sm_buildmap', 'ktzplg_generate_sitemap');

/**
 * Add nofollow in head this function will stop search engine to index your website.
 * https://support.google.com/webmasters/answer/96569?hl=en
 */
function ktzplg_nofollow_inheader() {
	# Get nofollow from options
	$data_nofollow_fromoption = Ktzagcplugin_Option::get_option( 'ktzplg_nofollow_head' );
	
	if ( $data_nofollow_fromoption != '' ) :
		$ktzplg_nofollow[] = '<!-- Add Nofollow by ktzagcplugin -->';
		$ktzplg_nofollow[] = '<meta name="robots" content="nofollow" />';
		$ktzplg_nofollow[] = '';
	else :
		$ktzplg_nofollow[] = '';
	endif;
	echo implode("\n", $ktzplg_nofollow);
	
}
add_action('wp_head', 'ktzplg_nofollow_inheader');