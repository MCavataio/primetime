<?php
//Twitter Tweet widgets
add_action('widgets_init','tn_register_twitter_widget');

function tn_register_twitter_widget() {
    register_widget('tn_twitter');
}


class tn_twitter extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname'   => 'widget-twitter', 'description' => esc_html__( '[Sidebar Widget] Show latest tweets in sidebar', 'tn' ));
		parent::__construct( 'tn-twitter-widget', esc_html__( '[SIDEBAR] - Twitter', 'tn' ), $widget_ops );
	}

    //Show widget
    function widget( $args, $instance ) {
        extract( $args );

	    $title                   = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
	    $options['twitter_user'] = ( ! empty( $instance['twitter_user'] ) ) ? $instance['twitter_user'] : '';
	    $options['num_tweets']   = ( ! empty( $instance['num_tweets'] ) ) ? $instance['num_tweets'] : 5;

        echo $before_widget;

        if (!empty($title)) echo $before_title . esc_attr($title) . $after_title;
        ?>
        <ul class="twitter-widget-inner">
            <?php if (function_exists('getTweets')) :

                $tweets_data = getTweets($options['num_tweets'], $options['twitter_user']);
                if (!empty($tweets_data) && is_array($tweets_data)) :
                    foreach ($tweets_data as $tweet) :
                        $tweet['text'] = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"$1\" class=\"twitter-link\">$1</a>", $tweet['text']);
                        $tweet['text'] = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $tweet['text']);
                        $tweet['text'] = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i", "<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $tweet['text']);
                        $tweet['text'] = preg_replace('/([\.|\,|\:|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $tweet['text']);
                        $tweet['text'] = str_replace('RT', ' ', $tweet['text']);

	                    $time = strtotime( $tweet['created_at'] );
	                    if ( ( abs( time() - $time ) ) < 86400 ) {
		                    $h_time = sprintf( esc_html__( '%s ago', 'tn' ), human_time_diff( $time ) );
	                    } else {
		                    $h_time = date( 'M j, Y', $time );
	                    }
                        ?>

	                    <li class="twitter-content">
		                    <p><?php echo do_shortcode( $tweet['text'] ); ?></p>
		                    <em class="twitter-timestamp"><?php echo esc_attr( $h_time ) ?></em>
	                    </li>

                    <?php endforeach; ?>
                <?php
                else : echo '<li><span class="tn-issue">' . esc_html__('Configuration error or no data.', 'tn') . '</span></li>';
                endif; ?>
            <?php else :   esc_html_e('Please install plugin name "oAuth Twitter Feed for Developers', 'tn'); ?>
            <?php endif; ?>

        </ul>

            <!--twitter feed -->
        <?php
        echo $after_widget;
    }

    //update widget
    function update( $new_instance, $old_instance ) {
	    $instance = $old_instance;
	    delete_transient( 'tn_tweet_feed' );
	    $instance['title']        = strip_tags( $new_instance['title'] );
	    $instance['twitter_user'] = strip_tags( $new_instance['twitter_user'] );
	    $instance['num_tweets']   = absint( strip_tags( $new_instance['num_tweets'] ) );
	    return $instance;
    }

    //from options
    function form( $instance ) {

	    $defaults = array(
		    'title'        => esc_html__( 'Latest Tweets', 'tn' ),
		    'twitter_user' => '',
		    'num_tweets'   => 5
	    );
	    $instance = wp_parse_args( (array) $instance, $defaults );
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><strong><?php  esc_html_e('Title:', 'tn');?></strong></label>
            <input type="text" class="widefat"  id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'twitter_user' )); ?>"><strong><?php  esc_html_e('Twitter Name:', 'tn');?></strong></label>
            <input type="text" class="widefat"  id="<?php echo esc_attr($this->get_field_id( 'twitter_user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter_user' )); ?>" value="<?php echo esc_attr($instance['twitter_user']); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'num_tweets' )); ?>"><strong><?php  esc_html_e('Number of Tweets:', 'tn');?></strong></label>
            <input type="text" class="widefat"  id="<?php echo esc_attr($this->get_field_id( 'num_tweets' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'num_tweets' )); ?>" value="<?php echo esc_attr($instance['num_tweets']); ?>"/>
        </p>
        <p><a href="http://dev.twitter.com/apps" target="_blank"><?php  esc_html_e('Create your Twitter App', 'tn'); ?></a> and install <a href="https://wordpress.org/plugins/oauth-twitter-feed-for-developers/"> "oAuth Twitter Feed for Developers"</a> Plugin</p>

    <?php
    }
}
