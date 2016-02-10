<?php 
/* 
Plugin Name: SPP Sitemap
*/

function spp_generate_sitemap() {
	require('settings.php');
	if(class_exists('GoogleSitemapGenerator')){
		$generatorObject = &GoogleSitemapGenerator::GetInstance();
		if($generatorObject!=null) {
			global $wpdb;
			// Let's get some keywords
			$terms = $wpdb->get_col('SELECT term FROM ' . $wpdb->prefix . 'spp ORDER BY RAND() LIMIT ' . $settings['limit']);	
			
			foreach ($terms as $term) {
				$generatorObject->AddUrl(build_permalink_for($term, $settings['permalink']), time(), "daily",0.5);
			}
		}
	}
}
add_action("sm_buildmap", "spp_generate_sitemap");