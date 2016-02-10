<?php
/* Kentooz Plugin widget for Random Term. */

// Do not load directly...
if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Ktzplg_Agcplugin_GoogleTrend_Wgt extends WP_Widget {
    /**
     * Constructor
     */
    public function __construct()
	{
		$widget_ops = array( 'classname' => 'ktzplg_google_trend', 'description' => __( 'Add Google Trend for AGC Plugin', 'ktzagcplugin') );
		parent::__construct( 'ktzplg-googletrend', __( 'KTZPLG Google Trend','ktzagcplugin' ), $widget_ops );
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
		$country = apply_filters('country', isset($instance['country']) ? esc_attr($instance['country']) : 'p1');
        echo $before_widget;
        if(!empty($title)) {
            echo $before_title . $title . $after_title;
        }
		
		echo do_shortcode('[ktzagcplugin_google_trend number="'.$number.'" country_code="'.$country.'"]');
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
		$country = isset($instance['country']) ? esc_attr($instance['country']) : 'p1';
	?>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ktzagcplugin'); ?> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"	name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'country' ); ?>"><?php _e( 'Country:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'country' ); ?>" name="<?php echo $this->get_field_name( 'country' ); ?>">
			<option value="p30" <?php if($instance['country']=='p30') { echo 'selected="selected"'; } ?> >Argentina</option>
			<option value="p8" <?php if($instance['country']=='p8') { echo 'selected="selected"'; } ?> >Australia</option>
			<option value="p44" <?php if($instance['country']=='p44') { echo 'selected="selected"'; } ?> >Austria</option>
			<option value="p41" <?php if($instance['country']=='p41') { echo 'selected="selected"'; } ?> >Belgium</option>
			<option value="p18" <?php if($instance['country']=='p18') { echo 'selected="selected"'; } ?> >Brazil</option>
			<option value="p13" <?php if($instance['country']=='p13') { echo 'selected="selected"'; } ?> >Canada</option>
			<option value="p38" <?php if($instance['country']=='p38') { echo 'selected="selected"'; } ?> >Chile</option>
			<option value="p32" <?php if($instance['country']=='p32') { echo 'selected="selected"'; } ?> >Colombia</option>
			<option value="p43" <?php if($instance['country']=='p43') { echo 'selected="selected"'; } ?> >Czech Republic</option>
			<option value="p49" <?php if($instance['country']=='p49') { echo 'selected="selected"'; } ?> >Denmark</option>
			<option value="p29" <?php if($instance['country']=='p29') { echo 'selected="selected"'; } ?> >Egypt</option>
			<option value="p50" <?php if($instance['country']=='p50') { echo 'selected="selected"'; } ?> >Finland</option>
			<option value="p16" <?php if($instance['country']=='p16') { echo 'selected="selected"'; } ?> >France</option>
			<option value="p15" <?php if($instance['country']=='p15') { echo 'selected="selected"'; } ?> >Germany</option>
			<option value="p48" <?php if($instance['country']=='p48') { echo 'selected="selected"'; } ?> >Greece</option>
			<option value="p10" <?php if($instance['country']=='p10') { echo 'selected="selected"'; } ?> >Hong Kong</option>
			<option value="p45" <?php if($instance['country']=='p45') { echo 'selected="selected"'; } ?> >Hungary</option>
			<option value="p3" <?php if($instance['country']=='p3') { echo 'selected="selected"'; } ?> >India</option>
			<option value="p19" <?php if($instance['country']=='p19') { echo 'selected="selected"'; } ?> >Indonesia</option>
			<option value="p6" <?php if($instance['country']=='p6') { echo 'selected="selected"'; } ?> >Israel</option>
			<option value="p27" <?php if($instance['country']=='p27') { echo 'selected="selected"'; } ?> >Italy</option>
			<option value="p4" <?php if($instance['country']=='p4') { echo 'selected="selected"'; } ?> >Japan</option>
			<option value="p37" <?php if($instance['country']=='p37') { echo 'selected="selected"'; } ?> >Kenya</option>
			<option value="p34" <?php if($instance['country']=='p34') { echo 'selected="selected"'; } ?> >Malaysia</option>
			<option value="p21" <?php if($instance['country']=='p21') { echo 'selected="selected"'; } ?> >Mexico</option>
			<option value="p17" <?php if($instance['country']=='p17') { echo 'selected="selected"'; } ?> >Netherlands</option>
			<option value="p52" <?php if($instance['country']=='p52') { echo 'selected="selected"'; } ?> >Nigeria</option>
			<option value="p51" <?php if($instance['country']=='p51') { echo 'selected="selected"'; } ?> >Norway</option>
			<option value="p25" <?php if($instance['country']=='p25') { echo 'selected="selected"'; } ?> >Philippines</option>
			<option value="p31" <?php if($instance['country']=='p31') { echo 'selected="selected"'; } ?> >Poland</option>
			<option value="p47" <?php if($instance['country']=='p47') { echo 'selected="selected"'; } ?> >Portugal</option>
			<option value="p39" <?php if($instance['country']=='p39') { echo 'selected="selected"'; } ?> >Romania</option>
			<option value="p14" <?php if($instance['country']=='p14') { echo 'selected="selected"'; } ?> >Russia</option>
			<option value="p36" <?php if($instance['country']=='p36') { echo 'selected="selected"'; } ?> >Saudi Arabia</option>
			<option value="p5" <?php if($instance['country']=='p5') { echo 'selected="selected"'; } ?> >Singapore</option>
			<option value="p40" <?php if($instance['country']=='p40') { echo 'selected="selected"'; } ?> >South Africa</option>
			<option value="p23" <?php if($instance['country']=='p23') { echo 'selected="selected"'; } ?> >South Korea</option>
			<option value="p26" <?php if($instance['country']=='p26') { echo 'selected="selected"'; } ?> >Spain</option>
			<option value="p42" <?php if($instance['country']=='p42') { echo 'selected="selected"'; } ?> >Sweden</option>
			<option value="p46" <?php if($instance['country']=='p46') { echo 'selected="selected"'; } ?> >Switzerland</option>
			<option value="p12" <?php if($instance['country']=='p12') { echo 'selected="selected"'; } ?> >Taiwan</option>
			<option value="p33" <?php if($instance['country']=='p33') { echo 'selected="selected"'; } ?> >Thailand</option>
			<option value="p24" <?php if($instance['country']=='p24') { echo 'selected="selected"'; } ?> >Turkey</option>
			<option value="p35" <?php if($instance['country']=='p35') { echo 'selected="selected"'; } ?> >Ukraine</option>
			<option value="p9" <?php if($instance['country']=='p9') { echo 'selected="selected"'; } ?> >United Kingdom</option>
			<option value="p1" <?php if($instance['country']=='p1') { echo 'selected="selected"'; } ?> >United States</option>
			<option value="p28" <?php if($instance['country']=='p28') { echo 'selected="selected"'; } ?> >Vietnam</option>
		</select>
	</p>

	<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Google Trend:', 'ktzagcplugin'); ?> <input	id="<?php echo $this->get_field_id('number'); ?>"
		name="<?php echo $this->get_field_name('number'); ?>" type="text"
		size="3" value="<?php echo $number; ?>" /></label>
	</p>

	<?php
    }
} // End of classes Ktzplg_Agcplugin_GoogleTrend_Wgt
add_action('widgets_init', create_function('', 'return register_widget("Ktzplg_Agcplugin_GoogleTrend_Wgt");'));