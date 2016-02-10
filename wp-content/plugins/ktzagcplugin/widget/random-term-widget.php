<?php
/* Kentooz Plugin widget for Random Term. */

// Do not load directly...
if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Ktzplg_Agcplugin_RandTerm_Wgt extends WP_Widget {
    /**
     * Constructor
     */
    public function __construct()
	{
		$widget_ops = array( 'classname' => 'ktzplg_rand_term', 'description' => __( 'Add Random Term for AGC Plugin, for keyword you can setting di Ktzagcplugin -> General Setting', 'ktzagcplugin') );
		parent::__construct( 'ktzplg-randterm', __( 'KTZPLG Random Term','ktzagcplugin' ), $widget_ops );
	}

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        extract( $args );
 		$title = apply_filters('title', isset($instance['title']) ? esc_attr($instance['title']) : '');
		$number = apply_filters('number', isset($instance['number']) && is_numeric($instance['number']) ? esc_attr($instance['number']) : 10);
        echo $before_widget;
        if(!empty($title)) {
            echo $before_title . $title . $after_title;
        }
		
		echo do_shortcode('[ktzagcplugin_random_term number="'.$number.'"]');
		echo $after_widget;
	}

    /**
     * @param array $new_instance
     * @param arrau $old_instance
     * @return mixed
     */
    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    /**
     * @param array $instance
     */
    public function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) && is_numeric($instance['number']) ? esc_attr($instance['number']) : 10;
	?>

	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ktzagcplugin'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
		name="<?php echo $this->get_field_name('title'); ?>" type="text"
		value="<?php echo $title; ?>" /></label>
	</p>

	<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of random terms:', 'ktzagcplugin'); ?> <input	id="<?php echo $this->get_field_id('number'); ?>"
		name="<?php echo $this->get_field_name('number'); ?>" type="text"
		size="3" value="<?php echo $number; ?>" /></label>
	</p>

	<?php
    }
} // End of classes Ktzplg_Agcplugin_RandTerm_Wgt
add_action('widgets_init', create_function('', 'return register_widget("Ktzplg_Agcplugin_RandTerm_Wgt");'));