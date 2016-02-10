<?php
/**
 * The file that defines the STT2
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 */

/**
 * Ktzplugin module STT2
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
 ************************************* Start STT2 Funct ******************************
 * We change default function STT2 with ktzplg for prevent error *********************
 *************************************************************************************
 */
 
/**
 * get search delimiter for each search engine
 * base on the original searchterms tagging plugin
 **/ 
function ktzplg_stt2_function_get_delimiter( $ref ) {
    $search_engines = array(
		'google.com' => 'q',
		'go.google.com' => 'q',
		'images.google.com' => 'q',
		'video.google.com' => 'q',
		'news.google.com' => 'q',
		'blogsearch.google.com' => 'q',
		'maps.google.com' => 'q',
		'local.google.com' => 'q',
		'search.yahoo.com' => 'p',
		'search.msn.com' => 'q',
		'bing.com' => 'q',
		'msxml.excite.com' => 'qkw',
		'search.lycos.com' => 'query',
		'alltheweb.com' => 'q',
		'search.aol.com' => 'query',
		'search.iwon.com' => 'searchfor',
		'ask.com' => 'q',
		'ask.co.uk' => 'ask',
		'search.cometsystems.com' => 'qry',
		'hotbot.com' => 'query',
		'overture.com' => 'Keywords',
		'metacrawler.com' => 'qkw',
		'search.netscape.com' => 'query',
		'looksmart.com' => 'key',
		'dpxml.webcrawler.com' => 'qkw',
		'search.earthlink.net' => 'q',
		'search.viewpoint.com' => 'k',
		'yandex.kz' => 'text',
		'yandex.ru' => 'text',
		'baidu.com' => 'wd',			
		'mamma.com' => 'query'
	);
    $delim = false;
    if (isset($search_engines[$ref])) {
        $delim = $search_engines[$ref];
    } else {
        if (strpos('ref:'.$ref,'google'))
            $delim = "q";
		elseif (strpos('ref:'.$ref,'search.atomz.'))
            $delim = "sp-q";
		elseif (strpos('ref:'.$ref,'search.msn.'))
            $delim = "q";
		elseif (strpos('ref:'.$ref,'search.yahoo.'))
            $delim = "p";
		elseif (strpos('ref:'.$ref,'yandex'))
            $delim = "text";
		elseif (strpos('ref:'.$ref,'baidu'))
            $delim = "wd";	
        elseif (preg_match('/home\.bellsouth\.net\/s\/s\.dll/i', $ref))
            $delim = "bellsouth";
    }
    return $delim;
}

/**
 * get the referer
 **/ 
function ktzplg_stt2_function_get_referer() {
    if (!isset($_SERVER['HTTP_REFERER']) || ($_SERVER['HTTP_REFERER'] == '')) return false;
    $referer_info = parse_url($_SERVER['HTTP_REFERER']);
    $referer = $referer_info['host'];
    if(substr($referer, 0, 4) == 'www.')
        $referer = substr($referer, 4);
    return $referer;
}

/**
 * retrieve the search terms from search engine query
 **/ 
function ktzplg_stt2_function_get_terms($d) {
    $terms       = null;
    $query_array = array();
    $query_terms = null;
    $query = explode($d.'=', $_SERVER['HTTP_REFERER']);
    $query = explode('&', $query[1]);
    $query = urldecode($query[0]);
    $query = str_replace("'", '', $query);
    $query = str_replace('"', '', $query);
    $query_array = preg_split('/[\s,\+\.]+/',$query);
    $query_terms = implode(' ', $query_array);
    $terms = htmlspecialchars(urldecode(trim($query_terms)));
    return $terms;
}

/**
 * save search terms into database
 * we change with update meta value it's better than hardcode
 **/ 
function ktzplg_stt2_db_save_searchterms( $meta_value ) {	
	if ( strlen($meta_value ) > 3 ){
		$search_term = sanitize_text_field( strtolower( trim( $meta_value ) ) );
		# proceed only if the search keyword contain more than 3 characters
		if( strlen( $search_term ) > 3 )
			return;
		
		$option = get_option( 'ktzplg_agcplg_searchterm' );
		
		if( isset( $option[$search_term] ) ) :
			$option[$search_term]++;
		else :
			$option[$search_term] = 1;
		endif;
		
		update_option( 'ktzplg_agcplg_searchterm', apply_filters( 'ktzplg_agcplg_searchterm', $option ) );
			
	}
	
}

/**
 * hooked to wp-head()
 **/ 
function ktzplg_stt2_function_wp_head_hook() {
	$referer = ktzplg_stt2_function_get_referer();
	if ( !$referer ) return false;
	$delimiter = ktzplg_stt2_function_get_delimiter( $referer );
	if( $delimiter ){
		$term = ktzplg_stt2_function_get_terms( $delimiter );
		#filter badword before save...
		$result = ktzplg_filter_badwords( $term );
		#save in database
		ktzplg_stt2_db_save_searchterms( $result );
	}
}
add_action('wp_head', 'ktzplg_stt2_function_wp_head_hook');

if ( !function_exists('ktzplg_get_random_term') ) {
	/* 
	 * Get Rand Term
	 */
	function ktzplg_get_random_term( $numb = 10 ) {
		
		# update option from ktzplg_stt2_db_save_searchterms in ktzagcplugin-module-stt2
		$data_searchterm = get_option( 'ktzplg_agcplg_searchterm' );
		$output = '';
		if( !empty($data_searchterm) && count($data_searchterm) >= $numb ) {
				
			$output .= '<ul class="ktzplg-randomterm">';
			foreach( $data_searchterm as $keyword ) {		
				$output .= '<li>';
				$output .= '<a href="'. ktzplg_permalink( $keyword, $choice = 'default' ) .'" rel="nofollow">' . esc_html( $keyword ) . '</a>';
				$output .= '</li>';
			}
			$output .= '</ul>';
			
		} else {
			$data_searchterm_fromoption = Ktzagcplugin_Option::get_option( 'ktzplg_rand_keyword' );
			if( !empty ( $data_searchterm_fromoption ) ){
				# This solution for use multiple explode
				$keyword_fromoption = explode( "\n", $data_searchterm_fromoption );
				
				shuffle ($keyword_fromoption);
				
				$keyword_fromoption = array_slice( $keyword_fromoption, 0, $numb, true );
				
				$output .= '<ul class="ktzplg-randomterm">';
				foreach( $keyword_fromoption as $keyword ) {			
					$output .= '<li>';
					$output .= '<a href="'. ktzplg_permalink( $keyword, $choice = 'default' ) .'">' . $keyword . '</a>';
					$output .= '</li>';
				}
				$output .= '</ul>';
			}
		}
		return $output;
	} /* End ktzplg_get_bingss_video */
	add_action( 'ktzplg_get_random_term', 'ktzplg_get_random_term', 10 );
}