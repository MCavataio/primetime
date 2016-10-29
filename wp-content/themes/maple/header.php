<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php
$tn_has_featured = tn_util::get_theme_option('featured_style');
$title_bg_style = tn_util::get_theme_option('title_background_style');

$tn_body_class = array();
$tn_body_class[] = 'tn-body';
$tn_body_class[] = 'tn-background';

if ('none' == $tn_has_featured) {
    $tn_body_class[] = 'none-featured-area';
}

if(!empty($title_bg_style)) $tn_body_class[] = 'is-light-style';

?>
<head>
    <!--meta tag-->
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (!function_exists('_wp_render_title_tag')) : ?>
        <title><?php wp_title('|', true, 'right'); ?></title>
    <?php endif; ?>

    <!--add feeds, pingback and stuff-->
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <?php wp_head(); ?>

</head><!--#header-->

<!-- #head site-->
<body <?php body_class($tn_body_class); echo ' ' . tn_util::tn_schema_makeup('body') ?>>
    <div id="tn-site-wrap" class="clearfix"><!--start site wrap-->

    <?php
    //logo is above menu
    echo tn_template_parts::render_logo_area();
    echo tn_template_parts::render_main_nav();
    ?>
