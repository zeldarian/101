<?php
/* Kentooz Framework widget for popular posts. */

class ktz_popular_posts extends WP_Widget {
	function ktz_popular_posts() {
		$widget_ops = array( 'classname' => 'ktz_popular_post clearfix', 'description' => __( 'Popular posts without box border.',ktz_theme_textdomain ) );
		$this->WP_Widget('ktz-popular-posts', __( 'KTZ popular Posts',ktz_theme_textdomain ), $widget_ops);
		$this->alt_option_name = 'ktz_popular';
		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}
	
	function filter_where_yearly( $where = '' ) {	
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-365 days')) . "'";
		return $where;
    }
	
	function filter_where_mountly( $where = '' ) {	
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
		return $where;
    }
	
	function filter_where_weekly( $where = '' ) {	
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
		return $where;
    }
	
	function filter_where_daily( $where = '' ) {	
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-1 days')) . "'";
		return $where;
    }
	
	function widget($args, $instance) {
		global $wpdb;
		$cache = wp_cache_get('widget_popular_posts', 'widget');
		if ( !is_array($cache) )
			$cache = array();
		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}
		ob_start();
		extract($args);
		$popular_by = empty( $instance['popular_by'] ) ? 'comment' : $instance['popular_by'];
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$style_latest = empty( $instance['style_latest'] ) ? 'list' : $instance['style_latest'];
		$popular_date = empty( $instance['popular_date'] ) ? 'alltime' : $instance['popular_date'];
		$number = empty( $instance['number'] ) ? '5' : $instance['number'];
		if ( $popular_date == "yearly" ) {
			add_filter( 'posts_where', array($this, 'filter_where_yearly' ) );
		} elseif ( $popular_date == "mountly" ) {
			add_filter( 'posts_where', array($this, 'filter_where_mountly' ) );
		} elseif ( $popular_date == "weekly" ) {
			add_filter( 'posts_where', array($this, 'filter_where_weekly' ) );
		} elseif ( $popular_date == "daily" ) {
			add_filter( 'posts_where', array($this, 'filter_where_daily' ) );
		} else {
			echo "";
		}
		if ( $popular_by == "comment" ) {
		$ktzpopular = new WP_Query(array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'orderby' => 'comment_count', 'order' => 'DESC'));
		} elseif ( $popular_by == "view" ) {
		$ktzpopular = new WP_Query(array('showposts' => $number, 'post_type' => 'post','meta_key' => 'post_views_count','orderby' => 'meta_value_num','order' => 'desc','post_status' => 'publish','ignore_sticky_posts' => 1));
		} else {
		$ktzpopular = new WP_Query(array('showposts' => $number, 'post_type' => 'post','meta_key' => 'ktz_stars_rating','orderby' => 'meta_value_num','order' => 'desc','post_status' => 'publish','ignore_sticky_posts' => 1));
		} 
		if ( $popular_date == "yearly" ) {
			remove_filter( 'posts_where', array($this, 'filter_where_yearly' ) );
		} elseif ( $popular_date == "mountly" ) {
			remove_filter( 'posts_where', array($this, 'filter_where_mountly' ) );
		} elseif ( $popular_date == "weekly" ) {
			remove_filter( 'posts_where', array($this, 'filter_where_weekly' ) );
		} elseif ( $popular_date == "daily" ) {
			remove_filter( 'posts_where', array($this, 'filter_where_daily' ) );
		} else {
			echo "";
		}
		if ($ktzpopular->have_posts()) : 
		echo $before_widget; 
        if ( $title ) :
			echo '<h4 class="widget-title"><span class="ktz-blocktitle">';
			echo $title;
			echo '</span>';
			echo '</h4>';
		endif;
		global $post;
		if ( $style_latest == "list" ) {
			echo '<ul class="ktz-recent-list ktz-widgetcolor">';
			while ($ktzpopular -> have_posts()) : $ktzpopular -> the_post(); 
			echo '<li>';
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
			if ( $popular_by == "comment" ) {
			echo ktz_comment_num();
			} elseif ( $popular_by == "view" ) {
			echo ktz_getPostViews(get_the_ID());
			} else {
			echo ktz_ajaxstar_SEO_widget();
			}
			echo '</div>';	
			echo '</div></li>';
			endwhile;
			echo '</ul>';
		} else {
			echo '<ul class="ktz-widgetcolor ktz_widget_default">';
			while ($ktzpopular -> have_posts()) : $ktzpopular -> the_post(); 
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
		wp_cache_add('widget_popular_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style_latest'] = strip_tags( $new_instance['style_latest'] );
		$instance['popular_by'] = strip_tags($new_instance['popular_by']);
		$instance['popular_date'] = strip_tags($new_instance['popular_date']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['ktz_popular']) )
		delete_option('ktz_popular');
		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_popular_posts', 'widget');
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'popular_by' => 'comment', 'popular_date' => 'alltime', 'style_latest' => 'list') );
		$title = esc_attr( $instance['title'] );
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5; ?>
		<p><label for="<?php echo $this->get_field_id('title',ktz_theme_textdomain ); ?>"><?php _e( 'Title:',ktz_theme_textdomain ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('number',ktz_theme_textdomain ); ?>"><?php _e( 'Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
		<small><?php _e( '(at most 15)',ktz_theme_textdomain ); ?></small>
        </p>
        <p><label for="<?php echo $this->get_field_id('style_latest'); ?>"><?php _e( 'Style box:',ktz_theme_textdomain ); ?></label>
            <select name="<?php echo $this->get_field_name('style_latest'); ?>" id="<?php echo $this->get_field_id('style_latest',ktz_theme_textdomain); ?>" class="widefat">
            <option value="list" <?php selected( $instance['style_latest'], 'list' ); ?>><?php _e( 'List',ktz_theme_textdomain ); ?></option>
            <option value="list-2" <?php selected( $instance['style_latest'], 'list-2' ); ?>><?php _e( 'List style 2',ktz_theme_textdomain ); ?></option>
            </select>
            <br/>
            <small><?php _e( 'Select style for recent post widget.',ktz_theme_textdomain ); ?></small>
		</p>
        <p><label for="<?php echo $this->get_field_id('popular_by'); ?>"><?php _e( 'Popular by:',ktz_theme_textdomain ); ?></label>
            <select name="<?php echo $this->get_field_name('popular_by'); ?>" id="<?php echo $this->get_field_id('popular_by',ktz_theme_textdomain); ?>" class="widefat">
            <option value="comment" <?php selected( $instance['popular_by'], 'comment' ); ?>><?php _e( 'Comment',ktz_theme_textdomain ); ?></option>
            <option value="view" <?php selected( $instance['popular_by'], 'view' ); ?>><?php _e( 'View',ktz_theme_textdomain ); ?></option>
            <option value="rate" <?php selected( $instance['popular_by'], 'rate' ); ?>><?php _e( 'Rating',ktz_theme_textdomain ); ?></option>
            </select>
            <br/>
            <small><?php _e( 'Select popular by comment or by most view.',ktz_theme_textdomain ); ?></small>
		</p>
        <p><label for="<?php echo $this->get_field_id('popular_date'); ?>"><?php _e( 'Popular range:',ktz_theme_textdomain ); ?></label>
            <select name="<?php echo $this->get_field_name('popular_date'); ?>" id="<?php echo $this->get_field_id('popular_date',ktz_theme_textdomain); ?>" class="widefat">
            <option value="alltime" <?php selected( $instance['popular_date'], 'alltime' ); ?>><?php _e( 'Alltime',ktz_theme_textdomain ); ?></option>
            <option value="yearly" <?php selected( $instance['popular_date'], 'yearly' ); ?>><?php _e( 'Yearly',ktz_theme_textdomain ); ?></option>
            <option value="mountly" <?php selected( $instance['popular_date'], 'mountly' ); ?>><?php _e( 'Mountly',ktz_theme_textdomain ); ?></option>
            <option value="weekly" <?php selected( $instance['popular_date'], 'weekly' ); ?>><?php _e( 'Weekly',ktz_theme_textdomain ); ?></option>
            <option value="daily" <?php selected( $instance['popular_date'], 'daily' ); ?>><?php _e( 'Daily',ktz_theme_textdomain ); ?></option>
            </select>
            <br/>
            <small><?php _e( 'Select popular by comment or by most view.',ktz_theme_textdomain ); ?></small>
		</p>
	<?php }
}?>