<?php
/**
 * This file display category layout
 */

//get header
get_header();

global $wp_query;

//get blog options
$tn_cate_id = $wp_query->get_queried_object_id();
$tn_options = array();
$tn_options['post_block'] = tn_util::get_theme_option('category_layout_' . $tn_cate_id);
$tn_options['sidebar_name'] = tn_util::get_theme_option('category_sidebar_' . $tn_cate_id);
$tn_options['sidebar_position'] = tn_util::get_theme_option('category_sidebar_position_' . $tn_cate_id);
$tn_options['big_first'] = tn_util::get_theme_option('category_post_first_' . $tn_cate_id);

echo tn_template_parts::render_category_header($tn_cate_id);
echo tn_layout::render_layout($tn_options);

//get footer
get_footer();
