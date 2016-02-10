<?php
/* Kentooz Framework widget for recent posts. */

class ktz_recent_posts extends WP_Widget {
	function ktz_recent_posts() {
		$widget_ops = array( 'classname' => 'ktz_recent_post clearfix', 'description' => __( 'Recent posts with category selection [This widget cannot used in BIG MODULE].',ktz_theme_textdomain ) );
		$this->WP_Widget('ktz-recent-posts', __( 'KTZ Recent Posts',ktz_theme_textdomain ), $widget_ops);
		$this->alt_option_name = 'ktz_recent';
		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}
	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');
		if ( !is_array($cache) )
			$cache = array();
		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}
		ob_start();
		extract($args);
		$style_latest = empty( $instance['style_latest'] ) ? 'list' : $instance['style_latest'];
		$cats = empty( $instance['cats'] ) ? '' : $instance['cats'];
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$number = empty( $instance['number'] ) ? '5' : $instance['number'];
		$ktzrecent = new WP_Query(array('showposts' => $number , 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'cat' => $cats));
		if ($ktzrecent->have_posts()) : 
		global $post;
		echo $before_widget; 
        if ( $title ) :
			if ( $title != '' ) {
				echo '<h4 class="widget-title';
				if ( $cats != '' ) { 
				$cat_array = get_category($cats);
				echo ' ' . $cat_array->slug; }
				echo '">';
				echo '<span class="ktz-blocktitle">' . $title . '</span>';
				echo '</h4>';
			} else { 
				echo '';
			}
		endif;
		if ( $style_latest == "list" ) {
			echo '<ul class="ktz-recent-list ktz-widgetcolor';
				if ( $cats != '' ) { 
				$cat_array = get_category($cats);
				echo ' ' . $cat_array->slug; }
				echo '">';
			while ($ktzrecent -> have_posts()) : $ktzrecent -> the_post(); 
			echo '<li class="clearfix">';
				echo '<a href="' . get_permalink() . '" title="Permalink to ' . get_the_title() . '">';
				echo '<img src="';
				ktz_featured_just_img_link( 230, 80 );
				echo '" data-src="';
				ktz_featured_just_img_link( 230, 80 );
				echo '" class="media-object ktz-lazyload" alt="' . get_the_title() . '" width="auto" height="auto" title="' . get_the_title() . '" />';
				echo '</a>';
			echo '<div class="ktz-content-related clearfix">';
			echo '<div class="ktz-posttitle">';
			echo ktz_posted_title_a();
			echo '</div>';	
			echo '<div class="ktz-metapost-widget">';
			echo ktz_posted_on_nonsnippet();
			echo '</div>';		
			echo '</div></li>';
			endwhile;
			echo '</ul>';
		} elseif ( $style_latest == "box" ) {
			echo '<ul>';
			while ($ktzrecent -> have_posts()) : $ktzrecent -> the_post(); 
			echo '<li class="ktz-widgetcolor';
				if ( $cats != '' ) { 
				$cat_array = get_category($cats);
				echo ' ' . $cat_array->slug; }
				echo '">';
				echo '<a href="' . get_permalink() . '" title="Permalink to ' . get_the_title() . '">';
				echo '<img src="';
				ktz_featured_just_img_link( 230, 150 );
				echo '" data-src="';
				ktz_featured_just_img_link( 230, 150 );
				echo '" class="media-object ktz-lazyload" alt="' . get_the_title() . '" width="auto" height="auto" title="' . get_the_title() . '" />';
				echo '</a>';
			echo '</li>';
			endwhile;
			echo '</ul>';
		} else {
			echo '<ul class="ktz-widgetcolor ktz_widget_default';
				if ( $cats != '' ) { 
				$cat_array = get_category($cats);
				echo ' ' . $cat_array->slug; }
				echo '">';
			while ($ktzrecent -> have_posts()) : $ktzrecent -> the_post(); 
			echo '<li>';
			echo ktz_posted_title_a();
			echo '</li>';
			endwhile;
			echo '</ul>';
		}
		wp_reset_query();  
		endif;
		echo $after_widget;
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_add('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['style_latest'] = strip_tags( $new_instance['style_latest'] );
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cats'] = (int) $new_instance['cats'];
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['ktz_recent']) )
		delete_option('ktz_recent');
		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'cats' => '', 'style_latest' => 'list') );
		$title = esc_attr( $instance['title'] );
		$cats = esc_attr( $instance['cats'] );
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;  ?>
		<p><label for="<?php echo $this->get_field_id('title',ktz_theme_textdomain ); ?>"><?php _e( 'Title:',ktz_theme_textdomain ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            <br/>
            <small><?php _e( 'This title will not show in widget.',ktz_theme_textdomain ); ?></small>
        </p>
		<p><label for="<?php echo $this->get_field_id('number',ktz_theme_textdomain ); ?>"><?php _e( 'Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
		<small><?php _e( '(at most 15)',ktz_theme_textdomain ); ?></small>
        </p>
        <p><label for="<?php echo $this->get_field_id('style_latest'); ?>"><?php _e( 'Style box:',ktz_theme_textdomain ); ?></label>
            <select name="<?php echo $this->get_field_name('style_latest'); ?>" id="<?php echo $this->get_field_id('style_latest',ktz_theme_textdomain); ?>" class="widefat">
            <option value="list" <?php selected( $instance['style_latest'], 'list' ); ?>><?php _e( 'List',ktz_theme_textdomain ); ?></option>
            <option value="list-2" <?php selected( $instance['style_latest'], 'list-2' ); ?>><?php _e( 'List style 2',ktz_theme_textdomain ); ?></option>
            <option value="box" <?php selected( $instance['style_latest'], 'box' ); ?>><?php _e( 'Box style',ktz_theme_textdomain ); ?></option>
            </select>
            <br/>
            <small><?php _e( 'Select style for recent post widget.',ktz_theme_textdomain ); ?></small>
		</p>
		<p><label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e( 'Fill with Category ID:',ktz_theme_textdomain); ?></label>
		<select id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>" class="widefat">
		<option value="" <?php selected( $instance['cats'], '' ); ?>><?php _e('All', ktz_theme_textdomain); ?></option>
		<?php $blog_categories = get_categories( array('orderby' => 'id') ); foreach( $blog_categories as $category ): ?>
		<option value="<?php echo $category->term_id; ?>" <?php selected( $instance['cats'], $category->term_id ); ?>><?php echo $category->name; ?></option>
		<?php endforeach; ?>
		</select>
		<br />
		<small><?php _e('Please select category for display in your widget', ktz_theme_textdomain); ?></small>
		</p>
	<?php }
}?>