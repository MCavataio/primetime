<?php
/**
 * instagram Widget
 * display fickr gird images
 */
add_action('widgets_init', 'tn_register_instagram_widget');

function tn_register_instagram_widget()
{
    register_widget('tn_instagram');
}

// Setup
class tn_instagram extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'instagram-widget', 'description' => esc_html__('[Sidebar Widget] Display Instagram Image Grid', 'tn'));
        parent::__construct('tn-instagram', esc_html__('[SIDEBAR] - Instagram', 'tn'), $widget_ops);
    }

//Render Widget
    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);

        $title = empty($instance['title']) ? '' : $instance['title'];
        $instagram_token = empty($instance['instagram_token']) ? '' : $instance['instagram_token'];
        $num_images = empty($instance['num_image']) ? '' : $instance['num_image'];
        $num_column = empty($instance['num_column']) ? 'col-xs-3' : $instance['num_column'];
        $bottom_text = empty($instance['bottom_text']) ? '' : $instance['bottom_text'];
        $click_popup = empty($instance['click_popup']) ? '' : $instance['click_popup'];

	    $data_images = get_transient( 'tn_instagram_widget_data' );

	    if ( empty( $data_images ) ) {
		    $user = $users = explode( ".", $instagram_token );
		    if ( ! empty( $user[0] ) && ! empty( $instagram_token ) ) {
			    $data_images = wp_remote_get( 'https://api.instagram.com/v1/users/' . $user[0] . '/media/recent/?access_token=' . $instagram_token . '&count=' . $num_images, array( 'timeout' => 100 ) );
			    if ( ! is_wp_error( $data_images ) && '200' == $data_images['response']['code'] ) {
				    if ( is_array( $data_images ) && ! empty( $data_images['body'] ) ) {
					    $data_images = json_decode( $data_images['body'] );
					    set_transient( 'tn_instagram_widget_data', $data_images, 12000 );
				    }
			    }
		    }
	    }

        echo $before_widget;
        if (!empty($title)) echo $before_title . esc_attr($title) . $after_title; ?>

	    <?php if ( ! empty( $data_images->data ) ) : ?>
        <div class="instagram-content-wrap row clearfix">
            <?php foreach ($data_images->data as $post) : ?>
            <div class="instagram-el <?php echo esc_attr($num_column) ?>">

                <?php if(!empty($click_popup))  : ?>
                <a href="<?php echo esc_url($post->images->standard_resolution->url) ?>" class="instagram-link cursor-zoom" data-source="<?php if(!empty($post->user->username)){ echo esc_attr($post->user->username); } ?>"><img src="<?php echo esc_url($post->images->low_resolution->url) ?>" alt=""></a>
                <?php else : ?>
	                <a href="<?php echo esc_html( $post->link ); ?>" target="_blank"><img src="<?php echo esc_url($post->images->low_resolution->url) ?>" alt=""></a>
                <?php endif; ?>

                </div>
            <?php endforeach; ?>

            <?php if(!empty($bottom_text)) : ?>
                <div class="instagram-el bottom-text clearfix entry"><?php echo html_entity_decode(stripcslashes($bottom_text)); ?></div>
            <?php endif; ?>

        </div>


	    <?php if ( ! empty( $click_popup ) ) {
		    //call javascript
		    wp_localize_script( 'tn-script', 'tn_instagram_widget', '1' );
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
        delete_transient('tn_instagram_widget_data');
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['instagram_token'] = strip_tags($new_instance['instagram_token']);
        $instance['num_image'] = absint(strip_tags($new_instance['num_image']));
        $instance['bottom_text'] = addslashes($new_instance['bottom_text']);
        $instance['num_column'] = strip_tags($new_instance['num_column']);
        $instance['click_popup'] = strip_tags($new_instance['click_popup']);
        return $instance;
    }

    //load form setting
    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => 'instagram', 'instagram_token' => '', 'num_image' => 9, 'num_column' => 'col-xs-3', 'bottom_text' => 'Follow @ Instagram', 'click_popup' => ''));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><strong><?php  esc_html_e('Title:', 'tn') ?></strong>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/></label>
        </p>

	    <p><?php echo html_entity_decode( esc_html__( 'How to Create an app and generate your Instagram access token on: <a target="_blank" href="http://instagram.themeruby.com/">Instagram access token tutorial</a> website</p>', 'tn' ) ); ?>
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
                <option value="col-xs-6" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'col-xs-6' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('2 columns', 'tn'); ?></option>
                <option value="col-xs-4" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'col-xs-4' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('3 columns', 'tn'); ?></option>
                <option value="col-xs-3" <?php if( !empty($instance['num_column']) && $instance['num_column'] == 'col-xs-3' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('4 columns', 'tn'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('bottom_text')); ?>"><strong><?php  esc_html_e('Bottom Text:', 'tn') ?></strong>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('bottom_text')); ?>" name="<?php echo esc_attr($this->get_field_name('bottom_text')); ?>" type="text" value="<?php echo esc_html($instance['bottom_text']); ?>"/></label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'click_popup' )); ?>"><?php  esc_html_e('Popup When Click:','tn') ?></label>
            <input class="widefat" type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'click_popup' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'click_popup' )); ?>" value="checked" <?php if( !empty( $instance['click_popup'] ) ) echo 'checked="checked"'; ?>  />
        </p>

    <?php
    }
}

