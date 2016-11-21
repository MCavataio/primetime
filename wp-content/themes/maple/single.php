<?php
/**
 * This file display single page
 */
//get header
get_header();

if (have_posts()) {
    //add numbers of views to database
    tn_post_support::counter_single_views(get_the_ID());

    while (have_posts()) {
        the_post();

        //render single
        echo tn_single::render_single();

    }
}

get_footer();
