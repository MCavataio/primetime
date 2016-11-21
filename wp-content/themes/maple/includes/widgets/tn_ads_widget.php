<?php
//ads widget
function tn_register_ads_widget() {
	register_widget( 'tn_ads_widget' );
}


//register widget
class tn_ads_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname'   => 'tn-ads-widget',
		                     'description' => esc_html__( 'Show your custom ads, your banner JS or Google Adsense code, Support Google Ads Responsive', 'tn' )
		);
		parent::__construct( 'tn_ads_widget', esc_html__( '[SIDEBAR] - Ads Box', 'tn' ), $widget_ops );
	}

	//load widget
	function widget( $args, $instance ) {
		extract( $args );
		$title      = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$url        = ( ! empty( $instance['url'] ) ) ? $instance['url'] : '';
		$img        = ( ! empty( $instance['image_url'] ) ) ? $instance['image_url'] : '';
		$google_ads = ( ! empty( $instance['google_ads'] ) ) ? $instance['google_ads'] : '';

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . esc_attr( $title ) . $after_title;
		}

		?>
        <div class="ads-widget-content-wrap clearfix">
          <?php if(!empty($img)) : ?>
            <?php if (!empty($url)) : ?>
                    <a class="ads-widget-link" target="_blank" href="<?php echo esc_url($url); ?>"><img class="ads-image" src="<?php echo esc_url($img); ?>" alt="<?php bloginfo('name') ?>"></a>
                <?php else : ?>
                    <img class="ads-widget-image" src="<?php echo esc_url($img); ?>" alt="<?php bloginfo('name') ?>">
                <?php endif; ?>
           <?php else : ?>
              <?php if(!empty($google_ads)) echo stripcslashes(tn_ads_support::render_google_ads($google_ads,'sidebar_ads')); ?>
            <?php endif; ?>
          </div>

        <?php  echo $after_widget;
    }

	//update
	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['url']        = strip_tags( $new_instance['url'] );
		$instance['image_url']  = strip_tags( $new_instance['image_url'] );
		$instance['google_ads'] = esc_js( $new_instance['google_ads'] );

		return $instance;
	}

    //load form
    function form($instance)
    {
	    $defaults = array( 'title' => '', 'url' => '', 'image_url' => '', 'google_ads' => '' );
	    $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><strong><?php  esc_html_e('Title:', 'tn'); ?></strong></label>
            <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php  esc_html_e('Ads Link:', 'tn'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php if( !empty($instance['url']) ) echo  esc_url($instance['url']); ?>"/>
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('image_url')); ?>"><?php  esc_html_e('Ads Image Url:', 'tn'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('image_url')); ?>" name="<?php echo esc_attr($this->get_field_name('image_url')); ?>" type="text" value="<?php if( !empty($instance['image_url']) ) echo esc_url($instance['image_url']); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'google_ads' )); ?>"><?php  esc_html_e('JS or Google AdSense Code:','tn'); ?></label>
            <textarea rows="10" cols="50" id="<?php echo esc_attr($this->get_field_id( 'google_ads' )); ?>" name="<?php echo esc_attr($this->get_field_name('google_ads')); ?>" class="widefat"><?php echo html_entity_decode(stripcslashes($instance['google_ads'])); ?></textarea>
        </p>
    <?php
    }
}

add_action('widgets_init', 'tn_register_ads_widget');
?>