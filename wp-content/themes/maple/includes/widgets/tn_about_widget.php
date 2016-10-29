<?php
//About widget
add_action('widgets_init', 'tn_register_about_widget');
function tn_register_about_widget()
{
    register_widget('tn_about_widget');
}

class tn_about_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'about-widget', 'description' => esc_html__('[Sidebar Widget] Show about me', 'tn'));
        parent::__construct('tn_about_widget', esc_html__('[SIDEBAR] - About me', 'tn'), $widget_ops);
    }

    function widget($args, $instance)
    {
	    extract( $args );
	    $title         = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
	    $text          = ( ! empty( $instance['text'] ) ) ? $instance['text'] : '';
	    $name          = ( ! empty( $instance['name'] ) ) ? $instance['name'] : '';
	    $image         = ( ! empty( $instance['logo_image'] ) ) ? $instance['logo_image'] : '';
	    $breakline_bar = ( ! empty( $instance['breakline_image'] ) ) ? $instance['breakline_image'] : '';


        echo $before_widget;
        if ($title) echo $before_title . esc_attr($title) . $after_title;

        if (!empty($image)) : ?>
        <div class="about-widget-image about-widget-el"><img data-no-retina src="<?php echo esc_url($image); ?>" alt="<?php bloginfo() ?>"/></div><!--#image-->
        <?php endif; ?>

        <?php if(!empty($name)) : ?>
        <div class="about-widget-name post-title about-widget-el"><h4><?php echo esc_attr($name); ?></h4></div><!--#name-->
        <?php endif; ?>

        <?php if (!empty($breakline_bar)) : ?>
        <div class="about-widget-break about-widget-el"><img data-no-retina src="<?php echo esc_url($breakline_bar); ?>" alt="break-line"/></div><!--#breakline image-->
        <?php endif; ?>

        <?php if (!empty($text)) : ?>
        <div class="about-widget-content entry about-widget-el"><?php echo do_shortcode($text); ?></div><!--about-content-->
        <?php endif; ?>

        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
	    $instance                    = $old_instance;
	    $instance['title']           = strip_tags( $new_instance['title'] );
	    $instance['name']            = strip_tags( $new_instance['name'] );
	    $instance['breakline_image'] = strip_tags( $new_instance['breakline_image'] );
	    $instance['text']            = $new_instance['text'];
	    $instance['logo_image']      = strip_tags( $new_instance['logo_image'] );
        return $instance;
    }

    function form($instance)
    {
	    $defaults = array( 'title'           => esc_html__( 'About me', 'tn' ),
	                       'text'            => '',
	                       'name'            => '',
	                       'breakline_image' => '',
	                       'logo_image'      => ''
	    );
	    $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php  esc_html_e('Title:','tn');?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php if( !empty($instance['title']) ) echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'logo_image' )); ?>"><?php  esc_html_e('About Image Url (optional):','tn'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'logo_image' )); ?>" name="<?php echo esc_attr($this->get_field_name('logo_image')); ?>" value="<?php if( !empty($instance['logo_image']) ) echo esc_url($instance['logo_image']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'name' )); ?>"><?php  esc_html_e('Name:','tn'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'name' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'name' )); ?>" value="<?php if( !empty($instance['name']) ) echo esc_attr($instance['name']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'breakline_image' )); ?>"><?php  esc_html_e('Break Line Image URL(optional):','tn'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'breakline_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'breakline_image' )); ?>" value="<?php if( !empty($instance['breakline_image']) ) echo esc_url($instance['breakline_image']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_html($this->get_field_id( 'text' )); ?>"><?php  esc_html_e('About text:','tn'); ?></label>
            <textarea rows="10" cols="50" id="<?php echo esc_html($this->get_field_id( 'text' )); ?>" name="<?php echo esc_html($this->get_field_name('text')); ?>" class="widefat"><?php echo esc_html($instance['text']); ?></textarea>
        </p>


    <?php
    }
}
?>
