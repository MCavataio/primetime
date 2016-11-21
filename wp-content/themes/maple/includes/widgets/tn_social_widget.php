<?php
//social widget
add_action( 'widgets_init', 'tn_register_social_widget' );

function tn_register_social_widget() {
	register_widget( 'tn_social_widget' );
}


class tn_social_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname'   => 'social-widget', 'description' => esc_html__( '[Sidebar Widget] Show Social Url. This widget can place in SIDEBAR', 'tn' ));
		parent::__construct( 'social-widget', esc_html__( '[SIDEBAR] - Social Widget', 'tn' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title   = ( ! empty( $instance['title'] ) ) ? esc_attr( $instance['title'] ) : '';
		$new_tab = ( ! empty( $instance['new_tab'] ) ) ? $instance['new_tab'] : true;
		if ( ! empty( $new_tab ) ) {
			$new_tab = true;
		}

        echo $before_widget;
        if ($title) echo $before_title . esc_attr($title) . $after_title; ?>

		<div class="social-widget-wrap">
			<?php echo tn_util::render_web_social( $new_tab ); ?>
		</div>

        <?php echo $after_widget;
    }

	//update
	function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['new_tab'] = strip_tags( $new_instance['new_tab'] );

		return $instance;
	}

	//admin form
    function form($instance) {
	    $defaults = array( 'title' => '', 'new_tab' => true );
	    $instance = wp_parse_args( (array) $instance, $defaults );
	    ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php  esc_html_e('Title :','tn') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php if (!empty($instance['title'])) echo esc_attr($instance['title']); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('new_tab')); ?>"><?php  esc_html_e('Open in new tab','tn'); ?></label>
            <input class="widefat" type="checkbox" id="<?php echo esc_attr($this->get_field_id('new_tab')); ?>" name="<?php echo esc_attr($this->get_field_name('new_tab')); ?>" value="true" <?php if (!empty($instance['new_tab'])) echo 'checked="checked"'; ?>  />
        </p>
	    <p><?php  esc_html_e( 'To set social link, Please go to theme options - shares & social - site social profiles', 'tn' ); ?></p>
    <?php
    }
}

?>