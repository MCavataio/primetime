<?php
/**
 * Class tn_top_site
 * This file display top site area
 */
if (!class_exists('tn_top_site')) {
    class tn_top_site
    {

        /**
         * @return bool|string|void
         * render featured area
         */
        static function render_featured()
        {
            $featured = tn_util::get_theme_option('featured_style');
            if ('none' == $featured) return false;

            //get posts database
            $featured_data = self::get_featured_data();

            if ($featured_data->have_posts()) {
                //set unique post
                $tn_unique = tn_util::get_theme_option('unique_post');
                if (1 == $tn_unique) {
                    foreach ($featured_data->posts as $tn_single) $GLOBALS['tn_unique_posts'][] = $tn_single->ID;
                }

                $str = '';
                $str .= '<div class="featured-area">';
                $str .= '<div class="block-carousel-wrap">';
                $str .= '<div class="slider-loading"></div>';
                $str .= '<div id="carousel-slider" class="block-featured-inner slider-init">';

                while ($featured_data->have_posts()) {
                    $featured_data->the_post();
                    $str .= tn_layout::render_grid_overlay();
                }
                $str .= '</div><!--#bock carousel wrap-->';
                $str .= '</div><!--#bock carousel inner-->';
                $str .= '</div><!--#featured area-->';

                wp_reset_postdata();

                return $str;

            } else {
                return false;
            }
        }


        /**
         * @return WP_Query
         * get post data
         */
        static function get_featured_data()
        {
            //get options
            $option = array();
            $categories = tn_util::get_theme_option('featured_cate');
            if (is_array($categories)) {
                $option['category_ids'] = implode(',', $categories);
            }
            $tags = tn_util::get_theme_option('featured_tag');

            if (is_array($tags)) {
                $option['tag_ids'] = $tags;
            }

            $option['orderby'] = tn_util::get_theme_option('featured_sort');
            $option['posts_per_page'] = tn_util::get_theme_option('featured_num');
            $option['offset'] = tn_util::get_theme_option('featured_offset');
            $option['meta_key'] = '_thumbnail_id';

            $data_query = tn_query::get_custom_query($option);

            return $data_query;

        }


    }
}
