<?php
/**
 * The file that defines the google trend scraper
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 */

/**
 * Ktzplugin module google trend
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
 ************************************* Start Bing video ******************************
 *************************************************************************************
 */
 
if ( !function_exists('ktzplg_get_google_trend') ) {
	/* 
	 * bing video Scrape
	 * value $permalink, $startfrom, $num
	 */
	function ktzplg_get_google_trend( $country_code = 'p1', $num = 4 ) {	
	
		# $country_code : 'p30','p8','p44','p41','p18','p13','p38','p32','p43','p49','p29','p50','p16','p15','p48','p10','p45','p3','p19','p6','p27','p4','p37','p34','p21','p17','p52','p51','p25','p31','p47','p39','p14','p36','p5','p40','p23','p26','p42','p46','p12','p33','p24','p35','p9','p1','p28'
		# $country_name : 'Argentina','Australia','Austria','Belgium','Brazil','Canada','Chile','Colombia','Czech Republic','Denmark','Egypt','Finland','France','Germany','Greece','Hong Kong','Hungary','India','Indonesia','Israel','Italy','Japan','Kenya','Malaysia','Mexico','Netherlands','Nigeria','Norway','Philippines','Poland','Portugal','Romania','Russia','Saudi Arabia','Singapore','South Africa','South Korea','Spain','Sweden','Switzerland','Taiwan','Thailand','Turkey','Ukraine','United Kingdom','United States','Vietnam'

		// Use default country code p1 = USA
		$country_codes = isset( $country_code ) ? $country_code : 'p1';
	
		/*
		 * This is BING XML where the picture come from. :D
		 */
		$xml = array('http://www.google.com/trends/hottrends/atom/feed?pn='.$country_codes);
		$output = '';
		if ($xml) {
			foreach ($xml as $x) {

				$rss = fetch_feed($x);
			
				if ( ! is_wp_error( $rss ) ) : # Checks that the object is created correctly
					// Figure out how many total items there are, but limit it to $num. 
					$maxitems = $rss->get_item_quantity( $num ); 
					// Build an array of all the items
					$xml_result = $rss->get_items( 0, $maxitems );
				endif;
			
				if ( ! is_wp_error( $rss ) ) :
					if ( $maxitems != 0  ) {
						$output .= '<ul>';
						foreach ($xml_result as $xml_results) {
							$output .= '<li>';
							$output .= '<a href="'. ktzplg_permalink( $xml_results->get_title(), $choice = 'default' ) .'">';
							$output .= $xml_results->get_title();
							$output .= '</a>';
							$output .= '</li>';
						}
						$output .= '</ul>';
					}
				endif;
			}
		}
		return $output;
	} /* End ktzplg_get_google_trend */
	add_action('ktzplg_get_google_trend', 'ktzplg_get_google_trend', 10, 2);
}