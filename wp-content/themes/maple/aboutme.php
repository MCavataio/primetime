<?php
/*
Template Name: About me Template
*/
get_header();

$tn_page_comment_box = get_post_meta(get_the_ID(), 'tn_page_comment_box', true);

if ('default' == $tn_page_comment_box || empty($tn_page_comment_box)) {
    $tn_page_comment_box = tn_util::get_theme_option('default_single_page_comment_box');
}

$tn_main_class = array();
$tn_main_class[] = 'no-sidebar';
$tn_main_class[] = 'tn-container'; //test version
$tn_main_class[] = 'about-width';
$tn_main_class = implode(' ', $tn_main_class);

echo '<div id="main-content-wrap" class="row clearfix ' . $tn_main_class . '">';
echo '<div id="main" class="tn-single-page col-xs-12">';

echo '<div class="about-page-inner">';

if (have_posts()) {
    while (have_posts()) : the_post();

        echo '<div class="about-heading">';
        echo tn_layout::render_block_thumbnail(get_the_ID(), 'classic');
        echo '<div  class="about-title post-title">';
        echo '<h1>' . get_the_title() . '</h1>';
        echo '</div><!--#title -->';
        echo '</div>';

        echo '<div class="entry">';

        the_content();

        wp_link_pages(array(
            'before' => '<div class="single-page-links">' . esc_html__('Pages:', 'tn'),
            'after' => '</div>',
        ));

        echo '</div><!--post entry -->';

        echo tn_single::render_single_shares(true);

    endwhile;
}

echo '</div>';

//comment box
if (!empty($tn_page_comment_box) && 'none' != $tn_page_comment_box) {
    comments_template();
}

echo '</div><!--#main-->';

echo '</div><!--#main site wrap -->';

get_footer();