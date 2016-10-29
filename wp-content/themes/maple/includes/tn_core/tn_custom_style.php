<?php
/**
 * this file render dynamic css for theme
 */

//add css to header
add_action( 'wp_head', 'tn_custom_css', 99 );

/**
 * @return string
 * this file get options and create css code as string
 */
if ( ! function_exists( 'tn_custom_css' ) ) {
	function tn_custom_css() {
		//get cache
		$tn_dynamic_css_cache = get_option( 'tn_maple_dynamic_css_cache', '' );

		if ( empty( $tn_dynamic_css_cache ) ) {
			$str = '';
			$str .= '<style type="text/css" media="all">';

			/************************H TAGS FONT**********************************/
			$tn_post_title_font = tn_util::get_theme_option( 'post_title_font' );
			if ( ! empty( $tn_post_title_font['font-family'] ) ) {
				$str .= 'h1,h2,h3,h4,h5,h6 { font-family :' . esc_attr( $tn_post_title_font['font-family'] ) . ';}';
			}


			/************************MAX SITE WIDTH**********************************/
			$max_width_site = tn_util::get_theme_option( 'site_container_width' );

			if ( ! empty( $max_width_site ) && 1110 != $max_width_site ) {
				$str .= '.tn-container { max-width :' . esc_attr( $max_width_site ) . 'px;}';
			}

			/************************LOGO CUSTOM**********************************/
			$logo_width = tn_util::get_theme_option( 'logo_width' );
			if ( 400 != $logo_width ) {
				$str .= '.logo-image { max-width : ' . esc_attr( $logo_width ) . 'px;}';
			}

			//Login Padding
			$logo_margin = tn_util::get_theme_option( 'logo_padding' );
			if ( 45 != $logo_margin ) {
				$str .= '#header.header-background-color .header-inner {margin-top: ' . esc_attr( $logo_margin ) . 'px; margin-bottom: ' . esc_attr( $logo_margin ) . 'px; }';
			}


			/************************TOP HEADER BACKGROUND**********************************/

			$tn_header_background_color = tn_util::get_theme_option( 'header_background_color' );

			if ( ! empty( $tn_header_background_color ) ) {
				$str .= '.header-wrap.header-background-color { background-color : ' . esc_attr( $tn_header_background_color ) . '; }';
			}

			//top header background image
			$tn_header_background_height = tn_util::get_theme_option( 'header_background_height' );
			$is_parallax                 = tn_util::get_theme_option( 'header_parallax' );

			if ( $is_parallax == 1 ) {
				$tn_image_height = intval( $tn_header_background_height ) + 150;
			} else {
				$tn_image_height = $tn_header_background_height;
			}

			$table_header_bg_height = intval( $tn_header_background_height ) - 70;
			$tn_table_image_height  = intval( $tn_image_height ) - 70;

			$mb_header_bg_height = intval( $tn_header_background_height ) - 150;
			$tn_mb_image_height  = intval( $tn_image_height ) - 150;


			$str .= 'header .header-parallax-wrap { height: ' . esc_attr( $tn_header_background_height ) . 'px; }';
			$str .= 'header #header-image-parallax { height : ' . esc_attr( $tn_image_height ) . 'px; !important }';

			$str .= '@media only screen and (max-width: 992px) and (min-width: 768px) {';
			$str .= 'header .header-parallax-wrap { height: ' . esc_attr( $table_header_bg_height ) . 'px; }';
			$str .= 'header #header-image-parallax { height : ' . esc_attr( $tn_table_image_height ) . 'px; !important }';
			$str .= '}';

			$str .= '@media only screen and (max-width: 767px){';
			$str .= 'header .header-parallax-wrap { height: ' . esc_attr( $mb_header_bg_height ) . 'px; }';
			$str .= 'header #header-image-parallax { height : ' . esc_attr( $tn_mb_image_height ) . 'px; !important }';
			$str .= '}';

			/************************NAVIGATION BACKGROUND**********************************/

			$nav_background = tn_util::get_theme_option( 'background_nav_color' );
			$text_nav_color = tn_util::get_theme_option( 'text_nav_color' );

			if ( ! empty( $nav_background ) ) {
				$str .= '#navigation .nav-wrap { background-color :' . esc_attr( $nav_background ) . ';}';
			};

			if ( ! empty( $text_nav_color ) ) {
				$str .= '#navigation .main-menu > li > a, .nav-search-wrap { color: ' . esc_attr( $text_nav_color ) . ';}';
				$str .= '.nav-search-wrap { opacity: .7; }';
				$str .= '.tn-mobile-menu-button, .tn-mobile-menu-button:before, .tn-mobile-menu-button:after { background-color :' . esc_attr( $text_nav_color ) . ';}';
			}

			/************************MAIN THEME COLOR**********************************/
			$main_color = tn_util::get_theme_option( 'main_theme_color' );

			if ( ! empty( $main_color ) ) {
				//text color
				$str .= 'a:hover, a:focus, .post-share-bar a:hover, .post-share-bar a:focus, .tagcloud a:hover, .tagcloud a:focus, #wp-calendar tbody td#today, .social-widget-wrap .social-bar-wrap a:hover,';
				$str .= '.social-widget-wrap .social-bar-wrap a:focus, .entry a:hover, .entry a:focus, .excerpt a:hover, .excerpt a:focus, .comment-form .logged-in-as a, #navigation .main-menu > li > a:hover, #navigation .main-menu > li > a:focus, .explain-menu:hover';
				$str .= '{color : ' . esc_attr( $main_color ) . ';}';

				//background color
				$str .= '.bullet , .bullet:before, .bullet:after, .read-more-wrap a:hover, .read-more-wrap a:focus, .single-social-wrap a, input[type="submit"]:hover, input[type="submit"]:focus,';
				$str .= '#tn-back-top i:hover:before, #tn-back-top i:hover:after, .is-light-style #tn-back-top i:hover:before, .is-light-style #tn-back-top i:hover:after, .mc4wp-form button, .mc4wp-form input[type="button"], .mc4wp-form input[type="submit"]';
				$str .= '{background-color : ' . esc_attr( $main_color ) . ';}';

			}


			/************************USER CUSTOM CSS**********************************/
			$tn_custom_css = tn_util::get_theme_option( 'custom_css' );

			if ( ! empty( $tn_custom_css ) ) {
				$str .= $tn_custom_css;
			}

			$str .= '</style>';

			//save to database
			$tn_save_dynamic_css_cache = addslashes( $str );
			delete_option( 'tn_maple_dynamic_css_cache' );
			add_option( 'tn_maple_dynamic_css_cache', $tn_save_dynamic_css_cache );

			echo $str;
		} else {
			echo stripcslashes( $tn_dynamic_css_cache );
		}

	}
}

if ( ! function_exists( 'tn_delete_dynamic_css_cache' ) ) {
	function tn_delete_dynamic_css_cache() {
		delete_option( 'tn_maple_dynamic_css_cache' );
	}
}

// delete css cache
add_action( 'redux/options/tn_theme_options/saved', 'tn_delete_dynamic_css_cache' );
add_action( 'redux/options/tn_theme_options/reset', 'tn_delete_dynamic_css_cache' );
add_action( 'redux/options/tn_theme_options/section/reset', 'tn_delete_dynamic_css_cache' );