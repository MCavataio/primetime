<?php
/**
 * This file display search page
 */
//get header
get_header();

//get blog options
$tn_options = array();
$tn_options['big_first'] = 0;
$tn_options['unique'] = 0;
$tn_options['sidebar_name'] = tn_util::get_theme_option('search_sidebar');
$tn_options['sidebar_position'] = tn_util::get_theme_option('search_sidebar_position');
if ('default' == tn_util::get_theme_option('search_sidebar_position')) {
    $tn_options['sidebar_position'] = tn_util::get_theme_option('site_sidebar_position');
} else {
    $tn_options['sidebar_position'] = tn_util::get_theme_option('search_sidebar_position');
}
$tn_options['post_block'] = tn_util::get_theme_option('search_layouts');

echo tn_template_parts::render_search_header();//render top heading area

if (have_posts()) {
    echo tn_layout::render_layout($tn_options);
} else {
    echo '<div id="main-content-wrap" class="row clearfix">';
    echo '<div class="search-no-result tn-container post-title"><h3>' . esc_html__('No found post of this search', 'tn') . '</h3></div>';
    echo '</div>';
}

get_footer();
