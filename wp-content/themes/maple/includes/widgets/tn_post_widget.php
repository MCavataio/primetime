<?php
//posts widget
add_action( 'widgets_init', 'tn_register_block_post_widget' );

function tn_register_block_post_widget() {
	register_widget( 'tn_block_post_widget' );
}


class tn_block_post_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'post-widget', 'description' => '[Sidebar Widget] Display posts' );
		parent::__construct( 'block-post-widget', esc_html__( '[SIDEBAR] - Posts widget', 'tn' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$options                   = array();
		$title                     = ( !empty( $instance['title'] ) ) ? esc_attr( $instance['title'] ) : '';
		$options['posts_per_page'] = ( !empty( $instance['posts_per_page'] ) ) ? $instance['posts_per_page'] : 4;
		$options['orderby']        = ( !empty( $instance['orderby'] ) ) ? $instance['orderby'] : 'date_post';
		$options['category_id']    = ( !empty( $instance['cate'] ) ) ? $instance['cate'] : 0;
		$options['category_ids']   = ( !empty( $instance['cates'] ) ) ? $instance['cates'] : '';
		$options['tags']           = ( !empty( $instance['tags'] ) ) ? $instance['tags'] : '';
		$options['offset']         = ( !empty( $instance['offset'] ) ) ? $instance['offset'] : 0;
		$style                     = ( !empty( $instance['style'] ) ) ? $instance['style'] : 'style1';


        $str = '';

        $post_data = tn_query::get_custom_query($options);

        //display widget
        echo $before_widget;

        if (!empty($title)){
            echo $before_title . esc_attr($title) . $after_title;
        }

        if ($post_data->have_posts()) {
            $str .= '<div class="post-widget-inner">';

            if ('style1' == $style) {
                while ($post_data->have_posts()) {
                    $post_data->the_post();

                    $str .= '<div class="post-widget-el">';
                    $str .= '<div class="post-widget-thumb">';
                    $str .= tn_util::render_thumb(get_the_ID(), 'tn_small');
                    $str .= '</div><!--#post widget thumb -->';
                    $str .= tn_util::render_title(get_the_ID(), 'mini');
                    $str .= tn_layout::render_meta_tags(array('date' => true));
                    $str .= '</div><!--#post widget el-->';
                };

            } else {
                $counter = 1;
                while ($post_data->have_posts()) {
                    $post_data->the_post();
                    $str .= '<div class="post-widget-el style-2">';
                    $str .= '<div class="post-widget-num meta-tags-wrap"><span>';
                    $str .= $counter;
                    $str .= '</span></div><!--#post widget counter -->';
                    $str .= tn_util::render_title(get_the_ID(), 'small');
                    $str .= '</div><!--#post widget el-->';

                    $counter++;
                }
            }

            $str .= '</div><!--#post widget inner -->';
            wp_reset_postdata();
        }

        echo $str;

        echo $after_widget;
    }
    //update
    function update($new_instance, $old_instance)
    {
	    $instance                   = $old_instance;
	    $instance['title']          = strip_tags( $new_instance['title'] );
	    $instance['style']          = strip_tags( $new_instance['style'] );
	    $instance['cate']           = strip_tags( $new_instance['cate'] );
	    $instance['cates']          = strip_tags( $new_instance['cates'] );
	    $instance['tags']           = strip_tags( $new_instance['tags'] );
	    $instance['posts_per_page'] = absint( strip_tags( $new_instance['posts_per_page'] ) );
	    $instance['offset']         = absint( strip_tags( $new_instance['offest'] ) );
	    $instance['orderby']        = strip_tags( $new_instance['orderby'] );

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => esc_html__('latest post','tn') ,'style' =>'',  'orderby' => 'date_post', 'posts_per_page' => 4, 'cate' => '', 'cates' => '', 'tags' => '', 'offset' => 0);
        $instance = wp_parse_args((array)$instance, $defaults); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php  esc_html_e('Title:','tn') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php if(!empty($instance['title'])) echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'style' )); ?>"><?php  esc_html_e('Style:', 'tn'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'style' )); ?>" >
                <option value="style1" <?php if( !empty($instance['style']) && $instance['style'] == 'style1' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Style 1', 'tn'); ?></option>
                <option value="style2" <?php if( !empty($instance['style']) && $instance['style'] == 'style2' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Style 2', 'tn'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cate')); ?>"><strong><?php  esc_html_e('Category Filter:', 'tn'); ?></strong></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('cate')); ?>" name="<?php echo esc_attr($this->get_field_name('cate')); ?>">
                <option value='all' <?php if ($instance['cate'] == 'all') echo 'selected="selected"'; ?>><?php  esc_html_e('All Categories', 'tn'); ?></option>
                <?php $categories = get_categories('type=post'); foreach ($categories as $category) { ?><option  value='<?php echo esc_attr($category->term_id); ?>' <?php if ($instance['cate'] == $category->term_id) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option><?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'cates' )); ?>"><?php  esc_html_e('Multiple Category Filter (optional, Input category ids, Separate category ids with comma. e.g. 1,2):','tn') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'cates' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'cates' )); ?>" value="<?php if( !empty($instance['cates']) ) echo esc_attr($instance['cates']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>"><?php  esc_html_e('Tags (optional, Separate tags with comma. e.g. tag1,tag2):','tn') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tags' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tags' )); ?>" value="<?php if( !empty($instance['tags']) ) echo esc_attr($instance['tags']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'posts_per_page' )); ?>"><?php  esc_html_e('Limit Post Number (optional, default is 4):','tn') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'posts_per_page' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'posts_per_page' )); ?>" value="<?php if( !empty($instance['posts_per_page']) ) echo esc_attr($instance['posts_per_page']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'offset' )); ?>"><?php  esc_html_e('Post Offset (optional, default is 0):','tn') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'offset' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'offest' )); ?>" value="<?php if( !empty($instance['offset']) ) echo esc_attr($instance['offset']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php  esc_html_e('Order By:', 'tn'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" >
                <option value="date_post" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'date' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Latest Post', 'tn'); ?></option>
                <option value="comment_count" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'comment_count' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Popular Post by Comments', 'tn'); ?></option>
                <option value="popular" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'popular' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Popular Post by Views', 'tn'); ?></option>
                <option value="post_type" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'post_type' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Post Type', 'tn'); ?></option>
                <option value="rand" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'rand' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Random Post', 'tn'); ?></option>
                <option value="author" <?php if( !empty($instance['author']) && $instance['orderby'] == 'author' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('Author', 'tn'); ?></option>
                <option value="alphabetical_order_asc" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'alphabetical_order_asc' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('alphabetical A->Z Posts', 'tn'); ?></option>
                <option value="alphabetical_order_decs" <?php if( !empty($instance['orderby']) && $instance['orderby'] == 'alphabetical_order_decs' ) echo "selected=\"selected\""; else echo ""; ?>><?php  esc_html_e('alphabetical Z->A Posts', 'tn'); ?></option>
            </select>
        </p>
    <?php
    }
}

?>