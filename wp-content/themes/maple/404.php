<?php
//404 page
get_header();
//open body class
?>
<div id="main-content-wrap" class="clearfix page-404" role="main">
        <div class="tn-container">
            <div class="content-404-inner">
                <div class="content-404">
                    <div class="logo-404 post-title"><h1><?php  esc_html_e('404', 'tn'); ?></h1></div>
                    <h3 class="title-404 post-title"><?php  esc_html_e('Oops! It looks like nothing was found at this location.', 'tn'); ?></h3>
                </div>
            </div><!--# 404 inner -->
        </div><!--404 wrap -->
    </div> <!--#main content -->

<?php
//get footer
get_footer();
?>
