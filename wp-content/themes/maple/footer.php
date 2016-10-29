<?php
//Display footer
$tn_copyright = tn_util::get_theme_option('site_copyright');
$tn_footer_social = tn_util::get_theme_option('site_copyright_social');
if(!empty($tn_footer_social)){
    $social_newtab = tn_util::get_theme_option('site_copyright_social_newtab');
    $tn_footer_social_data =  tn_util::render_web_social($social_newtab);
}
?>
<footer id="footer" class="footer-wrap">
    <?php echo tn_template_parts::render_top_footer(); ?>

        <?php if(is_active_sidebar('tn_sidebar_footer_1') || is_active_sidebar('tn_sidebar_footer_2') || is_active_sidebar('tn_sidebar_footer_3'))  : ?>
        <div class="row footer-area tn-container">

            <?php if (is_active_sidebar('tn_sidebar_footer_1')) : ?>
                <div class="sidebar-footer sidebar-wrap col-md-4 col-sm-12" role="complementary">
                    <?php dynamic_sidebar('tn_sidebar_footer_1'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('tn_sidebar_footer_2')) : ?>
                <div class="sidebar-footer sidebar-wrap col-md-4 col-sm-12" role="complementary">
                    <?php dynamic_sidebar('tn_sidebar_footer_2'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('tn_sidebar_footer_3')) : ?>
                <div class="sidebar-footer sidebar-wrap col-md-4 col-sm-12" role="complementary">
                    <?php dynamic_sidebar('tn_sidebar_footer_3'); ?>
                </div>
            <?php endif; ?>

        </div><!--#footer area-->
    <?php endif; ?>

    <div id="footer-copyright">
        <?php if (!empty($tn_copyright) || !empty($tn_footer_social_data)) : ?>
            <div class="copyright-inner tn-container">
                <?php if (!empty($tn_copyright)) : ?>
                    <div class="copyright copyright-el">
                        <?php echo wp_kses($tn_copyright, array('a' => array('href' => array()), 'i' => array('class' => array()), 'span' => array('class' => array()))); ?>
                    </div><!--copy right -->
                <?php endif; ?>

                <?php if (!empty($tn_footer_social_data)): ?>
                    <div class="copyright-social copyright-el">
                        <?php echo $tn_footer_social_data //social bar ?>
                    </div><!--#footer social -->
                <?php endif; ?>
            </div><!--#copyright inner -->
        <?php endif; ?>
    </div>
    <!--#copyright wrap -->

</footer><!--#footer -->

</div><!--#tn-main-site-wrap -->
<?php wp_footer(); ?>
</body>
</html>