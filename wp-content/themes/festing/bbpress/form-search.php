<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" class="ktz-bbpsearch" action="<?php bbp_search_url(); ?>">
	<div class="ktz-search has-feedback">
		<label class="control-label sr-only" for="inputSuccess5">Search for</label>
		<input type="hidden" name="action" value="bbp-search-request" />
		<input class="form-control btn-box" tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" placeholder="Search forum" />
		<span class="glyphicon glyphicon-search form-control-feedback"></span>
	</div>
</form>
