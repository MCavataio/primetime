<?php
add_action( 'widgets_init', 'tn_register_footer_social_counter' );

function tn_register_footer_social_counter() {
	register_widget( 'tn_footer_social_count' );
}


class tn_footer_social_count extends WP_Widget {


	function __construct() {
		$widget_ops = array('classname'   => 'social-footer-counter','description' => esc_html__( '[Footer Widget] Show Social Counter', 'tn'));
		parent::__construct( 'social-footer-counter', esc_html__( '[TOP FOOTER] - Social Counter', 'tn' ), $widget_ops );
	}

	//Show widget
	function widget( $args, $instance ) {
		extract( $args );

		$facebook_page                  = ( ! empty( $instance['facebook_page'] ) ) ? $instance['facebook_page'] : '';
		$youtube_user                   = ( ! empty( $instance['youtube_user'] ) ) ? $instance['youtube_user'] : '';
		$youtube_channel                = ( ! empty( $instance['youtube_channel'] ) ) ? $instance['youtube_channel'] : '';
		$dribbble_user                  = ( ! empty( $instance['dribbble_user'] ) ) ? $instance['dribbble_user'] : '';
		$dribbble_token                  = ( ! empty( $instance['dribbble_token'] ) ) ? $instance['dribbble_token'] : '';
		$soundcloud_user                = ( ! empty( $instance['soundcloud_user'] ) ) ? $instance['soundcloud_user'] : '';
		$soundcloud_api                 = ( ! empty( $instance['soundcloud_api'] ) ) ? $instance['soundcloud_api'] : '';
		$instagram_api                  = ( ! empty( $instance['instagram_api'] ) ) ? $instance['instagram_api'] : '';
		$twitter_user                   = ( ! empty( $instance['twitter_user'] ) ) ? $instance['twitter_user'] : '';
		$twitter_api['consumer_key']    = ( ! empty( $instance['consumer_key'] ) ) ? $instance['consumer_key'] : '';
		$twitter_api['consumer_secret'] = ( ! empty( $instance['consumer_secret'] ) ) ? $instance['consumer_secret'] : '';
		$pinterest_user                 = ( ! empty( $instance['pinterest_user'] ) ) ? $instance['pinterest_user'] : '';
		$vimeo_user                     = ( ! empty( $instance['vimeo_user'] ) ) ? $instance['vimeo_user'] : '';

		echo $before_widget;
        ?>
        <div class="footer-social-counter">
            <div class="tn-container">

            <?php
            //facebook counter
            if ( ! empty( $facebook_page ) ) :
	            $option['facebook_page'] = $facebook_page;
	            $facebook_count          = $this->get_counter_data( 'facebook_page', $option );
                ?>
                <div class="counter-element">
	                <a target="_blank" href="http://facebook.com/<?php echo urlencode($facebook_page); ?>" class="facebook" title="facebook"><i class="fa fa-facebook"></i>
	                    <span class="num-count"><?php echo esc_attr($this->Show_over_100k($facebook_count)); ?></span>
	                </a>
                    <div class="text-count"><a target="_blank" href="http://facebook.com/<?php echo urlencode($facebook_page); ?>" class="facebook" title="facebook"><?php  esc_html_e('followers', 'tn'); ?></a></div>
                </div><!--facebook like count -->
            <?php  endif;

            //twitter counter
            if ( ! empty( $twitter_user ) ) :
	            $option['twitter_user'] = $twitter_user;
	            $option['twitter_api']  = $twitter_api;
	            $twitter_count          = $this->get_counter_data( 'twitter', $option );
                ?>
                <div class="counter-element">
                    <a target="_blank" href="http://twitter.com/<?php echo urlencode($twitter_user); ?>" class="twitter" title="twitter"><i class="fa fa-twitter"></i>
                        <span class="num-count"><?php echo esc_attr($this->Show_over_100k($twitter_count)); ?></span>
                    </a>
                    <div class="text-count"><a target="_blank" href="http://twitter.com/<?php echo urlencode($twitter_user); ?>" class="twitter" title="twitter"><?php  esc_html_e('followers', 'tn'); ?></a></div>
                </div><!--twitter follower count -->
            <?php endif;


            if ( ! empty( $pinterest_user ) ) :
	            $option['pinterest_user'] = $pinterest_user;
	            $pinterest_count  = $this->get_counter_data( 'pinterest', $option );
	            ?>
	            <div class="counter-element">
		            <a target="_blank" href="http://pinterest.com/<?php echo urlencode($pinterest_user); ?>" class="pinterest" title="pinterest"><i class="fa fa-pinterest"></i>
			            <span class="num-count"><?php echo esc_attr($this->Show_over_100k($pinterest_count)); ?></span>
		            </a>
		            <div class="text-count"><a target="_blank" href="http://pinterest.com/<?php echo urlencode($pinterest_user); ?>" class="twitter" title="pinterest"><?php  esc_html_e('followers', 'tn'); ?></a></div>
	            </div><!--pinterest follower count -->
            <?php endif;

            //instgarm counter
            if (!empty($instagram_api)):
                $option['instagram_api'] = $instagram_api;
                $data_instagram = $this->get_counter_data('instagram', $option);
	            if ( empty( $data_instagram ) ) {
		            $data_instagram = array(
			            'count'     => 0,
			            'user_name' => '',
			            'url'       => '',
		            );
	            };
                ?>
                <div class="counter-element">
                    <a target="_blank" href="<?php echo esc_url($data_instagram['url']) ?>" title="instagram"><i class="fa fa-instagram"></i>
                        <span class="num-count"><?php echo esc_attr($this->Show_over_100k($data_instagram['count'])); ?></span>
                    </a>
                    <div class="text-count"><a target="_blank" href="<?php echo esc_url($data_instagram['url']) ?>" title="instagram"><?php  esc_html_e('Followers', 'tn'); ?></a></div>
                </div><!--instagram follower count -->
            <?php endif;

            //youtube counter
            if ( ! empty( $youtube_user ) || !empty($youtube_channel) ) :
	            $option['youtube_user'] = $youtube_user;
	            $option['youtube_channel'] = $youtube_channel;
	            $youtube_count          = $this->get_counter_data( 'youtube', $option );
                ?>
                <div class="counter-element color-youtube">
                    <a target="_blank" href="http://www.youtube.com/user/<?php echo esc_attr($youtube_user); ?>" title="<?php  esc_html_e('Youtube', 'tn'); ?>">
                        <i class="fa fa-youtube"></i>
                        <span class="num-count"><?php echo esc_attr($this->Show_over_100k($youtube_count)); ?></span>
                    </a>
                    <div class="text-count">
                        <a target="_blank" href="http://www.youtube.com/user/<?php echo esc_attr($youtube_user); ?>" title="<?php  esc_html_e('Youtube', 'tn'); ?>"><?php  esc_html_e('Subscribers', 'tn'); ?></a>
                    </div>
                </div><!--youtube subscribers count -->
            <?php endif;

            //soundcloud counter
            if ( ! empty( $soundcloud_user ) && ! empty( $soundcloud_api ) ):
	            $option['soundcloud_user'] = $soundcloud_user;
	            $option['soundcloud_api']  = $soundcloud_api;
	            $soundcloud_data           = $this->get_counter_data( 'soundcloud', $option );
	            if ( empty( $soundcloud_data ) ) {
		            $soundcloud_data = array(
			            'url'   => '',
			            'count' => ''
		            );
	            }
                ?>
                <div class="counter-element">
                    <a target="_blank" href="<?php echo esc_url($soundcloud_data['url']); ?>" title="<?php  esc_html_e('soundclound', 'tn'); ?>"><i class="fa fa-soundcloud"></i>
                        <span class="num-count"><?php echo esc_attr($this->Show_over_100k($soundcloud_data['count'])); ?></span>
                    </a>
                    <div class="text-count"><a target="_blank" href="<?php echo esc_url($soundcloud_data['url']); ?>" title="<?php  esc_html_e('soundclound', 'tn'); ?>"><?php  esc_html_e('Followers', 'tn'); ?></a></div>
                </div><!--soundcloud follower count -->
            <?php endif;

            //vimeo counter
            if ( ! empty( $vimeo_user ) ) :
	            $option['vimeo_user'] = $vimeo_user;
	            $vimeo_count          = $this->get_counter_data( 'vimeo', $option );
	            ?>
	            <div class="counter-element">
		            <a target="_blank" href="https://vimeo.com/<?php echo esc_attr($vimeo_user); ?>" title="vimeo"><i class="fa fa-vimeo"></i>
			            <span class="num-count"><?php echo esc_attr($this->Show_over_100k($vimeo_count)); ?></span>
		            </a>
		            <div class="text-count">
			            <a target="_blank" href="https://vimeo.com/<?php echo esc_attr($vimeo_user); ?>" title="vimeo"><?php  esc_html_e('Followers', 'tn'); ?></a>
		            </div>
	            </div><!--vimeo follower count -->
            <?php endif;

            //dribbble counter
            if ( ! empty( $dribbble_user ) || !empty($dribbble_token) ) :
	            $option['dribbble_user'] = $dribbble_user;
	            $option['dribbble_token'] = $dribbble_token;
	            $dribbble_count          = $this->get_counter_data( 'dribbble', $option );
	            ?>
	            <div class="counter-element color-dribbble">
		            <a target="_blank" href="http://dribbble.com/<?php echo esc_attr($dribbble_user); ?>" title="<?php  esc_html_e('dribbble', 'tn'); ?>">
			            <i class="fa fa-dribbble"></i>
			            <span class="num-count"><?php echo esc_attr($this->Show_over_100k($dribbble_count)); ?></span>
		            </a>
		            <div class="text-count">
			            <a target="_blank" href="http://dribbble.com/<?php echo esc_attr($dribbble_user); ?>" title="<?php  esc_html_e('dribbble', 'tn'); ?>"><?php  esc_html_e('Followers', 'tn'); ?></a>
		            </div>
	            </div><!--dribbble follower count -->
            <?php endif; ?>

            </div><!--#tn-container -->
        </div><!-- #social count wrap -->

        <?php
        echo $after_widget;
    }

	function Show_over_100k( $number ) {
		$number = intval( $number );
		if ( $number > 100000 ) {
			$number = round( $number / 1000, 1 ) . 'k';
		}

		return $number;
	}

	//get Count and save to cache.
	function get_counter_data( $social = '', $option = array() ) {
		$cache_data_name = 'tn_counter_' . $social;
		$cache           = get_transient( $cache_data_name );

		if ( false === $cache ) {
			$data        = '';
			$cache_hours = 6;
			switch ( $social ) {
				case 'facebook_page' :
					$data = tn_counter::count_facebook( $option['facebook_page'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
				case 'twitter' :
					$data = tn_counter::count_twitter( $option['twitter_user'], $option['twitter_api'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
				case 'instagram' :
					$data = tn_counter::count_instagram( $option['instagram_api'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
				case 'youtube' :
					$data = tn_counter::count_youtube( $option['youtube_user'], $option['youtube_channel'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
				case 'dribbble' :
					$data = tn_counter::count_dribbble( $option['dribbble_user'],$option['dribbble_token'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
				case 'pinterest' :
					$data = tn_counter::count_pinterest( $option['pinterest_user'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
				case 'soundcloud' :
					$data = tn_counter::count_soundclound( $option['soundcloud_user'], $option['soundcloud_api'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
				case 'vimeo' :
					$data = tn_counter::count_vimeo( $option['vimeo_user'] );
					set_transient( $cache_data_name, $data, 60 * 60 * $cache_hours );
					break;
			}

			return $data;
		} else {
			return $cache;
		}
	}


	//update widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//remove cache
		delete_transient( 'tn_counter_facebook_page' );
		delete_transient( 'tn_counter_twitter' );
		delete_transient( 'tn_counter_pinterest' );
		delete_transient( 'tn_counter_instagram' );
		delete_transient( 'tn_counter_youtube' );
		delete_transient( 'tn_counter_soundcloud' );
		delete_transient( 'tn_counter_vimeo' );
		delete_transient( 'tn_counter_dribbble' );

		$instance['facebook_page']   = strip_tags( $new_instance['facebook_page'] );
		$instance['twitter_user']    = strip_tags( $new_instance['twitter_user'] );
		$instance['consumer_key']    = strip_tags( $new_instance['consumer_key'] );
		$instance['consumer_secret'] = strip_tags( $new_instance['consumer_secret'] );
		$instance['youtube_user']    = strip_tags( $new_instance['youtube_user'] );
		$instance['youtube_channel'] = strip_tags( $new_instance['youtube_channel'] );
		$instance['dribbble_user']   = strip_tags( $new_instance['dribbble_user'] );
		$instance['dribbble_token']   = strip_tags( $new_instance['dribbble_token'] );
		$instance['soundcloud_user'] = strip_tags( $new_instance['soundcloud_user'] );
		$instance['soundcloud_api']  = strip_tags( $new_instance['soundcloud_api'] );
		$instance['instagram_api']   = strip_tags( $new_instance['instagram_api'] );
		$instance['pinterest_user']  = strip_tags( $new_instance['pinterest_user'] );
		$instance['vimeo_user']      = strip_tags( $new_instance['vimeo_user'] );

		return $instance;
	}

    //form setting
    function form( $instance ) {

	    $defaults = array(
		    'youtube_user'    => '',
		    'youtube_channel' => '',
		    'dribbble_user'   => '',
		    'dribbble_token'   => '',
		    'twitter_user'    => '',
		    'facebook_page'   => '',
		    'soundcloud_user' => '',
		    'soundcloud_api'  => '',
		    'pinterest_user'  => '',
		    'instagram_api'   => '',
		    'consumer_key'    => '',
		    'consumer_secret' => '',
		    'vimeo_user'      => ''

	    );
	    $instance = wp_parse_args( (array) $instance, $defaults ); ?>
	    <!--facebook -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'facebook_page' )); ?>"><strong><?php  esc_html_e('Facebook Page Name:', 'tn');?></strong></label>
            <input type="text" class="widefat"   id="<?php echo esc_attr($this->get_field_id( 'facebook_page' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'facebook_page' )); ?>" value="<?php echo esc_attr($instance['facebook_page']); ?>" />
        </p>
	    <!--twitter -->
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'twitter_user' )); ?>"><strong><?php  esc_html_e('Twitter Name:', 'tn');?></strong></label>
		    <input type="text"  class="widefat"  id="<?php echo esc_attr($this->get_field_id( 'twitter_user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter_user' )); ?>" value="<?php echo esc_attr($instance['twitter_user']); ?>"/>
	    </p>
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'consumer_key' )); ?>"><?php  esc_html_e('Twitter Consumer Key:', 'tn') ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'consumer_key' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'consumer_key' )); ?>" value="<?php echo esc_attr($instance['consumer_key']); ?>" />
	    </p>
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'consumer_secret' )); ?>"><?php  esc_html_e('Twitter Consumer Secret:', 'tn') ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'consumer_secret' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'consumer_secret' )); ?>" value="<?php echo esc_attr($instance['consumer_secret']); ?>" />
	    </p>
	    <p><a href="http://dev.twitter.com/apps" target="_blank"><?php  esc_html_e('Generate your Twitter App', 'tn'); ?></a></p>
	    <!--pinterest -->
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'pinterest_user' )); ?>"><strong><?php  esc_html_e('Pinterest User Name:','tn');?></strong> </label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pinterest_user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pinterest_user' )); ?>" value="<?php echo esc_attr($instance['pinterest_user']); ?>"/>
	    </p>
	    <!--instagram -->
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'instagram_api' )); ?>"><strong><?php  esc_html_e('Instagram Access Token Key:','tn') ?></strong> </label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'instagram_api' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram_api' )); ?>" value="<?php echo esc_textarea($instance['instagram_api']); ?>"/>
	    </p>
	    <p><a target="_blank" href="http://www.pinceladasdaweb.com.br/instagram/access-token/"><?php  esc_html_e('Instagram access token generator','tn') ?></a></p>
	    <!--youtube -->
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'youtube_user' )); ?>"><strong><?php  esc_html_e('Youtube User Name:', 'tn');?></strong></label>
		    <input type="text"  class="widefat" id="<?php echo esc_attr($this->get_field_id( 'youtube_user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube_user' )); ?>" value="<?php echo esc_attr($instance['youtube_user']); ?>"/>
	    </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'youtube_channel' )); ?>"><strong><?php  esc_html_e('Youtube Channel ID:', 'tn');?></strong></label>
            <input type="text"  class="widefat" id="<?php echo esc_attr($this->get_field_id( 'youtube_channel' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube_channel' )); ?>" value="<?php echo esc_attr($instance['youtube_channel']); ?>"/>
        </p>
		<p><?php  esc_html_e('Use channel ID if you can not enough subscriber to create username for channel. Make sure leave blank user name when input channel ID.','tn') ?></p>
	    <!--sound cloud-->
	    <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'soundcloud_user' )); ?>"><strong><?php  esc_html_e('SoundCloud User Name:','tn');?></strong> </label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'soundcloud_user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'soundcloud_user' )); ?>" value="<?php echo esc_attr($instance['soundcloud_user']); ?>"/>
		</p>
	    <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'soundcloud_api' )); ?>"><?php  esc_html_e('Soundcloud API Key(Client ID) :','tn') ?> </label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'soundcloud_api' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'soundcloud_api' )); ?>" value="<?php echo esc_attr($instance['soundcloud_api']); ?>"/>
        </p>
	    <p><a target="_blank" href="http://soundcloud.com/you/apps/"><?php  esc_html_e('Generate your soundcloud app','tn') ?></a></p>
	    <!--vimeo -->
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'vimeo_user' )); ?>"><strong><?php  esc_html_e('Vimeo User Name:','tn');?></strong> </label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'vimeo_user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'vimeo_user' )); ?>" value="<?php echo esc_attr($instance['vimeo_user']); ?>"/>
	    </p>
	    <!--dribbble -->
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'dribbble_user' )); ?>"><strong><?php  esc_html_e('Dribbble User Name:', 'tn');?></strong></label>
		    <input type="text"  class="widefat" id="<?php echo esc_attr($this->get_field_id( 'dribbble_user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'dribbble_user' )); ?>" value="<?php echo esc_attr($instance['dribbble_user']); ?>" />
	    </p>
	    <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'dribbble_token' )); ?>"><strong><?php  esc_html_e('Dribbble Token (Client Access Token):', 'tn');?></strong></label>
		    <input type="text"  class="widefat" id="<?php echo esc_attr($this->get_field_id( 'dribbble_token' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'dribbble_token' )); ?>" value="<?php echo esc_attr($instance['dribbble_token']); ?>" />
	    </p>
	    <p><a target="_blank" href="https://dribbble.com/account/applications/new"><?php  esc_html_e('Generate your dribbble app','tn') ?></a></p>
    <?php
    }
} 