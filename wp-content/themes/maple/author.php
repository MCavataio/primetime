<?php
/**
 * This file display author page
 */
//get header
get_header();

//get blog options
$tn_options = array();

$tn_options['big_first'] = 0;
$tn_options['unique'] = 0;
$tn_options['sidebar_name'] = tn_util::get_theme_option('author_sidebar');
$tn_options['sidebar_position'] = tn_util::get_theme_option('author_sidebar_position');
$tn_options['post_block'] = tn_util::get_theme_option('author_layouts');

if ('default' == tn_util::get_theme_option('author_sidebar_position')) {
    $tn_options['sidebar_position'] = tn_util::get_theme_option('site_sidebar_position');
} else {
    $tn_options['sidebar_position'] = tn_util::get_theme_option('author_sidebar_position');
}

echo tn_template_parts::render_author_header();//render top heading area
echo tn_layout::render_layout($tn_options);

get_footer();
