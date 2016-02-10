<?php
/**
 * Provides a notification everytime the theme is updated
 */

function update_notifier_menu() {  
	$xml = get_latest_theme_version(21600); // This tells the function to cache the remote call for 21600 seconds (6 hours)
	$kentooz_theme = wp_get_theme(); // Get theme data from style.css (current version is what we want)
	
	if(version_compare($kentooz_theme->Version, $xml->latest) == -1) {
		add_dashboard_page( $kentooz_theme->Name . 'Theme Updates', $kentooz_theme->Name . '<span class="update-plugins count-1"><span class="update-count">New Updates</span></span>', 'administrator', strtolower($kentooz_theme->Name) . '-updates', 'update_notifier');
	}
}  

//add_action('admin_menu', 'update_notifier_menu');

function update_notifier() { 
	$xml = get_latest_theme_version(21600); // This tells the function to cache the remote call for 21600 seconds (6 hours)
	$xml_latestrelease = ktz_latest_theme(21600); // This tells the function to cache the remote call for 21600 seconds (6 hours)
	$kentooz_theme = wp_get_theme(); // Get theme data from style.css (current version is what we want) ?>
	
	<style>
		.update-nag {display: none;}
		#instructions {max-width: 800px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
	</style>

	<div class="wrap">
	
		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo $kentooz_theme->Name; ?> Theme Updates</h2>
	    <div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo $kentooz_theme->Name; ?> theme available.</strong> You have version <?php echo $kentooz_theme->Version; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>
        
        <img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="<?php echo get_bloginfo( 'template_url' ) . '/screenshot.png'; ?>" />
        
        <div id="instructions" style="max-width: 800px;">
            <h3>Update Download and Instructions</h3>
            <p><strong>Please note:</strong> make a <strong>backup</strong> of the Theme inside your WordPress installation folder <strong>/wp-content/themes/<?php echo strtolower($kentooz_theme->Name); ?>/</strong></p>
            <p>To update the Theme, go to <a href="http://member.kentooz.com/login">http://member.kentooz.com/login</a> or link where you download this themes (for free theme), login to your kentooz account or download theme where you download before, head over to your <strong>downloads</strong> section and re-download the theme like you did when you bought it or download it.</p>
            <p>Extract the zip's contents, look for the extracted theme folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/themes/<?php echo strtolower($kentooz_theme->Name); ?>/</strong> folder overwriting the old ones (this is why it's important to backup any changes you've made to the theme files).</p>
            <p>If you didn't make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed.</p>
        </div>
        
            <div class="clear"></div>
	    
	    <h3 class="title">Changelog</h3>
	    <?php echo $xml->changelog; ?>
		
	    <h3 class="title">Latest release themes from kentooz</h3>
	    <?php echo $xml_latestrelease->ktzlatestthemes; ?>

	</div>
    
<?php } 

// This function retrieves a remote xml file on my server to see if there's a new update 
// For performance reasons this function caches the xml content in the database for XX seconds ($interval variable)
function get_latest_theme_version($interval) {
	// remote xml file location
	$notifier_file_url = 'http://www.kentooz.com/xml/fasthink-notifier.xml';
	
	$db_cache_field = 'ktzfasthink-notifier-cache';
	$db_cache_field_last_updated = 'ktzfasthink-notifier-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}
		
		if ($cache) {			
			// we got good results
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );			
		}
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}
	
	$xml = simplexml_load_string($notifier_data); 
	
	return $xml;
}

// Get latest themes
function ktz_latest_theme($interval) {
	$notifier_file_url = 'http://www.kentooz.com/latest-themes.xml';
	$db_cache_field = 'ktzfasthink-notifier-cache';
	$db_cache_field_last_updated = 'ktzfasthink-notifier-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	if ( !$last || (( $now - $last ) > $interval) ) {
		if( function_exists('curl_init') ) { 
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url);
		}
		if ($cache) {			
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );			
		}
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		$notifier_data = get_option( $db_cache_field );
	}
	$xml = simplexml_load_string($notifier_data); 
	return $xml;
}

?>