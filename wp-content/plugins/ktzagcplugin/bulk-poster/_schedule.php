<?php
/**
 * All Schedule Function For campaign Ktzagcplugin Bulk Posters.
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin
 */
/**
 * All Schedule Function For campaign Ktzagcplugin Bulk Posters.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin
 * @author     Your Name <g14nblog@gmail.com>
 */
 
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/* 
 * Time convertion
 */
function ktzplg_time_seconds( $num, $timeperiod ) {
	if ( $timeperiod == 'days' ) {
		$timeval = 3600 * 24;
	} else if ($timeperiod == 'hours') {
		$timeval = 3600;
	} else {
		$timeval = 1;
	}
	# is this a range? i.e 2-6? pick a random time between them
	if ( preg_match( "/(\d+)\s*\D+\s*(\d+)/", $num, $matches ) ) {
		$random = mt_rand( $matches[1] * $timeval, $matches[2] * $timeval);
		return $random;
	}
	else
	
	return (int)($num * $timeval);

}

/**
 * Add cron job interval schedule auto post
 * 
 * @param object $post camp_bulkposter
 * @return $schedules
 */
function ktzplg_set_next_schedules( $schedules ) {	// add custom time when to check for next auto post
	
	$args = array( 'post_type' => 'camp_bulkposter', 'post_status'=> 'publish' );
	$myposts = get_posts( $args );
	
	if ( $myposts ) {
		foreach ( $myposts as $post ) {
			setup_postdata( $post );
			
			# Schedule Post
			$ktzplg_next = get_post_meta( $post->ID, 'ktzplg_next', true );
			if ( empty( $ktzplg_next ) ) {
				$ktzplg_next = 24;
			}
			$ktzplg_next_time = get_post_meta( $post->ID, 'ktzplg_next_time', true );
			if ( empty( $ktzplg_next_time ) ) {
				$ktzplg_next_time = 'hours';
			}
			
			$recurrance = "ktzplg_" . $ktzplg_next . "_" . $ktzplg_next_time;

			$timesecs = ktzplg_time_seconds ( $ktzplg_next,  $ktzplg_next_time );
			$schedules[$recurrance] = array(
				'interval' => $timesecs, 
				'display' => sprintf("%c%c%c %s", 0x44, 0x42, 0x42, str_replace("_", " ", $recurrance)),
			);
		}
		wp_reset_postdata();
	}
	return $schedules;
}
add_filter( 'cron_schedules', 'ktzplg_set_next_schedules', 99 );

/**
 * Add cron job schedule auto post
 * 
 * @param object $post camp_bulkposter
 */
function ktzplg_schedule_auto_post() {
	
	$args = array( 'post_type' => 'camp_bulkposter', 'post_status'=> 'publish' );
	$myposts = get_posts( $args );
	
	if ( $myposts ) {
		foreach ( $myposts as $post ) {
			setup_postdata( $post );
	
			# Schedule Post
			$ktzplg_next = get_post_meta( $post->ID, 'ktzplg_next', true );
			if ( empty( $ktzplg_next ) ) {
				$ktzplg_next = 24;
			}
			$ktzplg_next_time = get_post_meta( $post->ID, 'ktzplg_next_time', true );
			if ( empty( $ktzplg_next_time ) ) {
				$ktzplg_next_time = 'hours';
			}
			
			$recurrance = "ktzplg_" . $ktzplg_next . "_" . $ktzplg_next_time;
			
			$camp_id = $post->ID;
			
			wp_clear_scheduled_hook( 'ktzplg_auto_post_hook', array( $camp_id ) );
		
			wp_schedule_event( time(), $recurrance, 'ktzplg_auto_post_hook', array( $camp_id ) );
			
			# event hook exists - do nothing
			if ( wp_next_scheduled( 'ktzplg_auto_post_hook', array( $camp_id ) ) ) { 
				return;
			}
		}
		wp_reset_postdata();
	}
}
add_filter( 'wp_head', 'ktzplg_schedule_auto_post');

/* 
 * Check for restart event
 */
function ktzplg_lets_start_autopost( $camp_id ) {
	$arr = array ( $camp_id );
	$args = array( 'post_type' => 'camp_bulkposter', 'post_status'=> 'publish', 'post__in'=> $arr );
	$myposts = get_posts( $args );
	
	if ( $myposts ) {
		foreach ( $myposts as $post ) {
			setup_postdata( $post );
	
			$keyword = get_post_meta( $post->ID, 'keyword', true );
			if ( empty( $keyword ) ) {
				$keyword = '';
			}
			
			$count = get_post_meta( $post->ID, 'count', true );
			if ( empty( $count ) ) {
				$count = 1;
			}
			
			# get category id meta post
			$category_id = get_post_meta( $post->ID, 'category_id', true );
			if ( empty( $category_id ) ) {
				$category_id = 1;
			}
			
			# get status meta post
			$status = get_post_meta( $post->ID, 'status', true );
			if ( empty( $status ) ) {
				$status = 'publish';
			}
			
			# get post_type meta post
			$ktzplg_post_type = get_post_meta( $post->ID, 'ktzplg_post_type', true );
			if ( empty( $ktzplg_post_type ) ) {
				$status = 'post';
			}

			# Logical insert post after Publish campaign
			if ( !empty( $count ) && !empty( $keyword ) ) {
				
				$keyword = explode( "\n", $keyword );
				
				# Rand Keyword Submission
				if( count( $keyword > 0 ) ) {
					shuffle( $keyword );
					$keyword = array_slice( $keyword, 0, $count );
				}
				
				foreach ( $keyword as $kwd ){
					
					# get title via keyword
					$title = sanitize_title( $kwd );
					$title = str_replace('-',' ', $title);
					$title = ucwords( $title );
					
					$args = array( 'post_type' => $ktzplg_post_type, 'post_status'=> 'publish' );
					$myposts = get_posts( $args );
					
					# get content via plugin settings
					$content = Ktzagcplugin_Option::get_option( 'ktzplg_agc_content' );
					$replace_with_this = ' keyword="' . $title . '"]';
					$content_wow = str_replace( ']', $replace_with_this, $content );
					$content = do_shortcode( $content_wow );
					
					# if not post same keyword do it..
					if (!get_page_by_title($title, 'OBJECT', $ktzplg_post_type) ){
						
						# Insert post => ktzplg_insert_post ( $post_type='', $title = '', $status = '', $category_id = array() , $content = '', $author = '' );
						ktzplg_insert_post ( $ktzplg_post_type, $title, $status, array( $category_id ) , $content , 1 );
						
					}
					
				} # end if foreach ( $keyword as $kwd )
				
			} # end if !empty( $count ) && !empty( $keyword )
			
		} # end if foreach ( $myposts as $post )
		wp_reset_postdata();
	}
}
add_action( 'ktzplg_auto_post_hook', 'ktzplg_lets_start_autopost', 1, 1 );