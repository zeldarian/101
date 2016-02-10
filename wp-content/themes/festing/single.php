<?php 
/**
 * KENTOOZ SINGLE PAGE TEMPLATE
**/
get_header(); ?>
	<section class="col-md-12">
	<div class="row">
	<?php 		
		$ktz_meta_values = get_post_custom($post->ID);
		if ( ot_get_option('ktz_sb_layout') == 'left' ) : 
		get_sidebar(); 
		else :
			if(!isset($ktz_meta_values['ktz_meta_layout'][0])){
			 	$ktz_meta_values['ktz_meta_layout'][0] = 'right';
			}
			if ( $ktz_meta_values['ktz_meta_layout'][0] == 'left' ) { 
				get_sidebar(); 
			} else {
				echo '';
			}
		endif; ?>
		<div role="main" class="main col-md-9">
		<section class="new-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'single' ); ?>
			<?php endwhile; // end of the loop. ?>
		</section>
		
		<?php if ( ot_get_option('ktz_def_com_activated') == 'yes' || ot_get_option('ktz_facebook_com_activated') == 'yes' || ot_get_option('ktz_active_autbox') == 'yes' || ot_get_option('ktz_active_related') == 'yes' ) : ?>
		<div class="tab-comment-wrap" id="comments">
		
		<ul class="nav nav-tabs" id="kentooz-comment">
		
			<?php if ( ot_get_option('ktz_def_com_activated') == 'yes' ) : ?>
			<li><a href="#comtemplate" data-toggle="tab" title="Default comment"><span class="fontawesome ktzfo-comment-alt"></span> <?php _e( 'Comments', ktz_theme_textdomain ); ?></a></li>
			<?php endif; ?>		
		
			<?php if ( ot_get_option('ktz_facebook_com_activated') == 'yes' ) : ?>
			<li><a href="#comfacebook" data-toggle="tab" title="Facebook comment"><span class="fontawesome ktzfo-facebook"></span> <?php _e( 'FB Comments', ktz_theme_textdomain ); ?></a></li>
			<?php endif; ?>
			
			<?php if ( ot_get_option('ktz_active_autbox') == 'yes' ) : ?>
			<li><a href="#comauthor" data-toggle="tab" title="Author tab"><span class="glyphicon glyphicon-user"></span> <?php _e( 'Author', ktz_theme_textdomain ); ?></a></li>
			<?php endif; ?>
			
			<?php if ( ot_get_option('ktz_active_related') == 'yes' ) : ?>
			<li><a href="#comrelated" data-toggle="tab" title="Author tab"><span class="fontawesome ktzfo-link"></span> <?php _e( 'Related', ktz_theme_textdomain ); ?></a></li>
			<?php endif; ?>
			
		</ul>
		
		<div class="tab-content">
		
			<?php if ( ot_get_option('ktz_def_com_activated') == 'yes' ) : ?>
			<div class="tab-pane" id="comtemplate">
				<div class="wrapcomment">
				<?php hook_ktz_comment_template(); ?>
				</div>			
			</div>
			<?php endif; ?>		
		
			<?php if ( ot_get_option('ktz_facebook_com_activated') == 'yes' ) : ?>
			<div class="tab-pane" id="comfacebook">
				<div class="wrapcomment">
				<?php hook_ktz_comment_facebook(); ?>
				</div>
			</div>
			<?php endif; ?>
			
			<?php if ( ot_get_option('ktz_active_autbox') == 'yes' ) : ?>
			<div class="tab-pane" id="comauthor">
				<div class="wrapcomment">
				<?php hook_ktz_singlecontent_after(); ?>
				</div>
			</div>
			<?php endif; ?>
			
			<?php if ( ot_get_option('ktz_active_related') == 'yes' ) : ?>
			<div class="tab-pane" id="comrelated">
				<div class="wrapcomment">
				<?php hook_ktz_single_relpost(); ?>
				</div>
			</div>
			<?php endif; ?>
			
		</div>
		
		</div>
		<?php endif; ?>
		</div>
	<?php if ( ot_get_option('ktz_sb_layout') == 'right' ) : 
		get_sidebar(); 
		else :
			$ktz_meta_values = get_post_custom($post->ID);
			if ($ktz_meta_values['ktz_meta_layout'][0] == 'right') { 
				get_sidebar(); 
			} else {
				echo '';
			}
		endif; ?>
	</div>
	</section>
<?php get_footer(); ?>