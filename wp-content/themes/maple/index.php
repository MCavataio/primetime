<?php
/**
 * Maple created by ThemeRuby
 * This file display home blog layout
 */
//get header
get_header();

//get blog options
$tn_options = array();

$tn_options['big_first'] = tn_util::get_theme_option('big_post_first');
$tn_options['unique'] = tn_util::get_theme_option('unique_post');
$tn_options['sidebar_name'] = tn_util::get_theme_option('blog_sidebar');
$tn_options['sidebar_position'] = tn_util::get_theme_option('blog_sidebar_position');
$tn_options['post_block'] = tn_util::get_theme_option('blog_layouts');

if ('default' == tn_util::get_theme_option('blog_sidebar_position')) {
    $tn_options['sidebar_position'] = tn_util::get_theme_option('site_sidebar_position');
} else {
    $tn_options['sidebar_position'] = tn_util::get_theme_option('blog_sidebar_position');
}

echo tn_top_site::render_featured();//render featured area
echo tn_layout::render_layout($tn_options);

get_footer();
