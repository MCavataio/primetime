<?php
//footer instagram widget
add_action( 'widgets_init', 'tn_register_footer_instagram' );

function tn_register_footer_instagram() {
	register_widget( 'tn_footer_instagram' );
}

//setup
class tn_footer_instagram extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname'   => 'footer-instagram-widget', 'description' => esc_html__( '[Top Footer Widget] Display Instagram Image Grid', 'tn' ));
		parent::__construct( 'footer-instagram-widget', esc_html__( '[TOP FOOTER] - Instagram', 'tn' ), $widget_ops );
	}

	//Render Widget
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title           = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$instagram_token = ( ! empty( $instance['instagram_token'] ) ) ? $instance['instagram_token'] : '';
		$num_images      = ( ! empty( $instance['num_image'] ) ) ? $instance['num_image'] : '';
		$num_column      = ( ! empty( $instance['num_column'] ) ) ? $instance['num_column'] : 'col-xs-3';
		$click_popup     = ( ! empty( $instance['click_popup'] ) ) ? $instance['click_popup'] : '';
		$max_width       = ( ! empty( $instance['max_width'] ) ) ? $instance['max_width'] : '';

		if ( 'wrapper' == $max_width ) {
			$max_width = 'tn-container';
		} else {
			$max_width = '';
		}

		$data_images = get_transient( 'tn_footer_instagram_data' );

		if ( empty( $data_images ) ) {
			if ( ! empty( $instagram_token ) ) {
				$user = $users = explode( ".", $instagram_token );
				if ( empty( $user[0] ) ) {
					echo ' <div class="tn-issue">' . esc_html__( 'Configuration error or no pictures...', 'tn' ) . '</div>';
				} else {
					$response = wp_remote_get( 'https://api.instagram.com/v1/users/' . $user[0] . '/media/recent/?access_token=' . $instagram_token . '&count=' . $num_images, array( 'timeout' => 100 ) );
					if ( is_wp_error( $response ) || '200' != $response['response']['code'] ) {
						echo ' <div class="tn-issue">' . esc_html__( 'Configuration error or no pictures...', 'tn' ) . '</div>';
					} else {
						$data_images = json_decode( wp_remote_retrieve_body( $response ) );
						set_transient( 'tn_footer_instagram_data', $data_images, 12000 );
					}
				}
			}
		}
        echo $before_widget;

	    if ( ! empty( $title ) ) {
		    echo $before_title . esc_attr( $title ) . $after_title;
	    } ?>

        <?php if(!empty($data_images->data)) : ?>
        <div class="instagram-content-wrap row <?php echo ' ' . $max_width; ?>">
            <?php foreach ($data_images->data as $post) : ?>
                <div class="footer-instagram-el <?php echo esc_attr($num_column) ?>">

                    <?php if(!empty($click_popup))  : ?>
                        <a href="<?php echo esc_url($post->images->standard_resolution->url) ?>" class="footer-instagram-link cursor-zoom" data-source="<?php if(!empty($post->user->username)){ echo esc_attr($post->user->username); } ?>"><img src="<?php echo esc_url($post->images->low_resolution->url) ?>" alt=""></a>
                    <?php else : ?>
	                    <a href="<?php echo esc_html( $post->link ); ?>" target="_blank"><img src="<?php echo esc_url($post->images->low_resolution->url) ?>" alt=""></a>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>

	    <?php if ( ! empty( $click_popup ) ) {
		    wp_localize_script( 'tn-script', 'tn_footer_instagram_widget', '1' );
	    } ?>

    <?php else : ?>
        <div class="tn-issue"><?php  esc_html_e('Configuration error or no pictures...', 'tn') ?></div>
    <?php endif; ?>

        <?php  echo $after_widget;
    }
    //update setting.
    function update($new_instance, $old_instance)
    {
	    $instance = $old_instance;
	    delete_transient( 'tn_footer_instagram_data' );
	    $instance['title']           = strip_tags( $new_instance['title'] );
	    $instance['instagram_token'] = strip_tags( $new_instance['instagram_token'] );
	    $instance['num_image']       = absint( strip_tags( $new_instance['num_image'] ) );
	    $instance['num_column']      = strip_tags( $new_instance['num_column'] );
	    $instance['max_width']       = strip_tags( $new_instance['max_width'] );
	    $instance['click_popup']     = strip_tags( $new_instance['click_popup'] );

	    return $instance;
    }

	//load form setting
	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'           => 'Follow @ Instagram',
				'max_width'       => 'full',
				'instagram_token' => '',
				'num_image'       => 12,
				'num_column'      => 'col-xs-2',
				'click_popup'     => ''
			) );
		?>

		<p><?php echo html_entity_decode( esc_html__( 'How to Create an app and generate your Instagram access token on: <a target="_blank" href="http://instagram.themeruby.com/">Instagram access token tutorial</a> website</p>', 'tn' ) ); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><strong><?php  esc_html_e('Title:', 'tn') ?></strong>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram_token')); ?>"><strong><?php  esc_html_e('Instagram Access Token:', 'tn') ?></strong>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram_token')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram_token')); ?>" type="text" value="<?php echo esc_attr($instance['instagram_token']); ?>"/></label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num_image')); ?>"><strong><?php  esc_html_e('Limit Image Number:', 'tn') ?></strong>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('num_image')); ?>" name="<?php echo esc_attr($this->get_field_name('num_image')); ?>" type="text" value="<?php echo esc_attr($instance['num_image']); ?>"/></label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'num_column' )); ?>"><strong><?php  esc_html_e('Number of Columns:', 'tn'); ?></strong></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'num_column' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'num_column' )); ?>" >
                <option value="col-xs-3" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'col-xs-3' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('4 columns', 'tn'); ?></option>
                <option value="tn-col-5" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'tn-col-5' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('5 columns', 'tn'); ?></option>
                <option value="col-xs-2" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'col-xs-2' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('6 columns', 'tn'); ?></option>
                <option value="tn-col-7" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'tn-col-7' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('7 columns', 'tn'); ?></option>
                <option value="tn-col-8" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'tn-col-8' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('8 columns', 'tn'); ?></option>
                <option value="tn-col-9" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'tn-col-9' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('9 columns', 'tn'); ?></option>
                <option value="tn-col-10" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'tn-col-10' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('10 columns', 'tn'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'max_width' )); ?>"><strong><?php  esc_html_e('Width of Gird:', 'tn'); ?></strong></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_width' )); ?>" >
                <option value="full" <?php if( !empty($instance['max_width']) && $instance['max_width'] == 'full' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Full Width', 'tn'); ?></option>
                <option value="wrapper" <?php if( !empty($instance['max_width']) && $instance['max_width'] == 'wrapper' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Has Wrapper', 'tn'); ?></option>
            </select>
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'click_popup' )); ?>"><?php  esc_html_e('Popup When Click:','tn') ?></label>
            <input class="widefat" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'click_popup' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'click_popup' )); ?>" value="checked" <?php if( !empty( $instance['click_popup'] ) ) echo 'checked="checked"'; ?>  />
        </p>

    <?php
    }
}

