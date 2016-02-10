<?php 
/**
 * KENTOOZ 404 ERROR TEMPLATE
**/
get_header(); ?>	
<section class="col-md-12">
	<div class="error-img">
	<?php
	/**
	* Add error page layout via function
	* Functions @ includes/functions/_content_ktz.php
	**/
	ktz_error_page(); ?>
	</div>
</section>
<?php get_footer(); ?>