<?php
/*
 * This page display single page
 */
$tn_single_id = get_the_ID();
$tn_page_title = get_post_meta($tn_single_id, 'tn_page_title', true);
$tn_sidebar_name = get_post_meta($tn_single_id, 'tn_page_custom_sidebar', true);
$tn_sidebar_position = get_post_meta($tn_single_id, 'tn_page_sidebar_position', true);
$tn_page_comment_box = get_post_meta($tn_single_id, 'tn_page_comment_box', true);


if ('default' == $tn_page_title || empty($tn_page_title)) {
    $tn_page_title = tn_util::get_theme_option('default_single_page_title');
}

if ('tn_default_from_theme_options' == $tn_sidebar_name || empty($tn_sidebar_name)) {
    $tn_sidebar_name = tn_util::get_theme_option('default_single_page_sidebar');
}

if ('default' == $tn_sidebar_position || empty($tn_sidebar_position)) {
    $tn_sidebar_position = tn_util::get_theme_option('default_single_page_sidebar_position');
}

if ('default' == $tn_page_comment_box || empty($tn_page_comment_box)) {
    $tn_page_comment_box = tn_util::get_theme_option('default_single_page_comment_box');
}

get_header();

$tn_main_class = array();

//check sidebar
if ('none' != $tn_sidebar_position) {
    $tn_main_class[] = 'is-sidebar';
    if ('left' == $tn_sidebar_position) {
        $tn_main_class[] = 'left-sidebar';
    } else {
        $tn_main_class[] = 'right-sidebar';
    }
} else {
    $tn_main_class[] = 'no-sidebar';
}

$tn_main_class[] = 'tn-container'; //test version

$tn_main_class = implode(' ', $tn_main_class);


echo '<div id="main-content-wrap" class="row clearfix ' . $tn_main_class . '">';

if ('none' != $tn_sidebar_position) {
    echo '<div id="main" class="tn-single-page col-md-8 col-sm-12">';
} else {
    echo '<div id="main" class="tn-single-page col-xs-12">';
}

echo '<div class="main-page-inner">';

if (have_posts()) {
    while (have_posts()) : the_post();

        if (!empty($tn_page_title) && 'none' != $tn_page_title) {
            echo '<div class="page-title-wrap post-title">';
            echo '<h1 class="tn-page-title">' . get_the_title() . '</h1>';
            echo '</div><!--#page title -->';
        }

        echo '<div class="entry clearfix">';

        the_content();

        wp_link_pages(array(
            'before' => '<div class="single-page-links">' . esc_html__('Pages:', 'tn'),
            'after' => '</div>',
        ));

        echo '</div><!--post entry -->';

    endwhile;
}

echo '</div>';

//comment box
if ('none' != $tn_page_comment_box || !empty($tn_page_comment_box)) {
    comments_template();
}

echo '</div><!--#main-->';

//render sidebar
if ( ! empty( $tn_sidebar_name ) && 'none' != $tn_sidebar_position ) {
	echo tn_template_parts::render_sidebar( $tn_sidebar_name );
}

echo '</div><!--#main site wrap -->';

get_footer();