<?php
/**
 * Class tn_template_parts
 * This file render some part template for theme
 */
if ( ! class_exists( 'tn_template_parts' ) ) {
	class tn_template_parts {
		//HEADER TEMPLATES

		/**
		 * @return string
		 * render logo area
		 */
		static function render_logo_area() {
			$header_background_style = tn_util::get_theme_option( 'header_background_type' );
			$header_background_url   = tn_util::get_theme_option( 'header_background_url' );
			$header_parallax         = tn_util::get_theme_option( 'header_parallax' );
			$header_social           = tn_util::get_theme_option( 'header_social_bar' );

			$str               = '';
			$tn_header_class   = array();
			$tn_header_class[] = 'header-wrap';
			$container         = 'tn-container';

			if ( 1 == $header_background_style ) {
				$tn_header_class[] = 'header-background-color';
			} elseif ( 0 == $header_background_style && ! empty( $header_background_url['url'] ) ) {
				$tn_header_class[] = 'header-background-image';
				if ( 1 == $header_parallax ) {
					$tn_header_class[] = 'is-header-parallax';
				}
			}

			$tn_header_class = implode( ' ', $tn_header_class );

			$str .= '<header id="header" class=" ' . $tn_header_class . '">';

			//render header parallax background
			if ( 0 == $header_background_style && ! empty( $header_background_url['url'] ) ) {
				$str .= '<div class="header-parallax-wrap"><div id="header-image-parallax"></div></div><!--#banner parallax wrap-->';
				$str .= '<img id="background-image-url" src="' . esc_url( $header_background_url['url'] ) . '" alt="header parallax image" data-no-retina style="display:none;"/>';
			}

			$str .= '<div class="header-inner clearfix ' . $container . '">';

			$str .= '<div id="logo" class="logo-wrap" role="banner" itemscope="itemscope" itemtype="http://schema.org/Organization">';
			$str .= self::render_logo();

			if ( ! empty( $header_social ) ) {
				$header_social = tn_util::render_web_social();
				if ( ! empty( $header_social ) ) {
					$social_bar_style = tn_util::get_theme_option( 'header_social_bar_style' );
					if ( ! empty( $social_bar_style ) ) {
						$str .= '<div class="header-social is-dark-style">';
					} else {
						$str .= '<div class="header-social">';
					}
					$str .= tn_util::render_web_social();
					$str .= '</div><!--#header social -->';
				}
			}

			$str .= '</div><!--# logo wrap-->';
			$str .= '</div><!-- header inner -->';

			$str .= '</header><!--#header -->';

			return $str;
		}


		/**
		 * @return string
		 * render main navigation
		 */
		static function render_main_nav() {
			if ( ! has_nav_menu( 'tn_main_nav' ) ) {
				return false;
			}

			$sticky_nav     = tn_util::get_theme_option( 'sticky_navigation' );
			$background_nav = tn_util::get_theme_option( 'background_nav_color' );
			$tn_nav_class   = array();

			if ( ! empty( $background_nav ) ) {
				$tn_nav_class[] = 'is-nav-background';
			}

			if ( 1 == $sticky_nav ) {
				$tn_nav_class[] = 'is-sticky-nav';
			} else {
				$tn_nav_class[] = 'no-sticky-nav';
			}

			$tn_nav_class = implode( ' ', $tn_nav_class );

			$str = '';
			$str .= '<nav id="navigation" class="' . $tn_nav_class . ' clearfix">';

			$str .= '<div class="nav-wrap">';

			$str .= '<div class="tn-container nav-inner clearfix">';

			//MOBILE NAV BUTTON
			$str .= '<div class="tn-mobile-main-menu-button">';
			$str .= '<a href="#" id="tn-button-mobile-menu-open">';
			$str .= '<span class="tn-mobile-menu-button"></span>';
			$str .= '</a>';
			$str .= '</div><!-- #mobile button-->';

			//MAIN NAVIGATION
			$str .= '<div class="menu-wrap" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">';
			$str .= wp_nav_menu(
				array(
					'container'      => false,
					'theme_location' => 'tn_main_nav',
					'menu_class'     => 'main-menu',
					'depth'          => '3',
					'echo'           => false
				) );
			$str .= '</div><!--#main navigation -->';

			$str .= self::render_top_search();

			$str .= '</div><!--# nav inner -->';

			//MOBILE NAVIGATION
			$str .= '<div id="tn-mobile-nav" class="mobile-nav-wrap">';
			$str .= wp_nav_menu(
				array(
					'theme_location'  => 'tn_main_nav',
					'container_id'    => 'mobile-menu',
					'container_class' => 'tn-container',
					'menu_class'      => 'mobile-menu-inner',
					'el_class'        => 'mobile-menu-inner',
					'depth'           => '3',
					'echo'            => false
				) );
			$str .= '</div><!--#mobile menu wrap-->';

			$str .= '</div><!--#nav wrap-->';

			$str .= '</nav><!--#navigation -->';

			//render header ads
			$str .= self::render_header_ads();

			return $str;
		}


		/**
		 * @return string
		 * render topbar search
		 */
		static function render_top_search() {
			//check and return
			$search_icon = tn_util::get_theme_option( 'search_icon' );
			if ( empty( $search_icon ) ) {
				return false;
			}

			$str = '';

			$str .= '<div class="nav-search-wrap">';
			$str .= get_search_form( false );
			$str .= ' </div><!--#top search wrap -->';

			return $str;
		}


		/**
		 * @return string
		 * render site logo
		 */
		static function render_logo() {
			$logo        = tn_util::get_theme_option( 'logo' );
			$logo_retina = tn_util::get_theme_option( 'logo_retina' );
			$str         = '';

			if ( ! empty( $logo['url'] ) ) {
				if ( empty( $logo_retina['url'] ) ) {
					$str .= '<a class="logo-image" href="' . get_home_url( '/' ) . '">';
					$str .= '<img class="logo-img-data" data-no-retina src="' . esc_url( $logo['url'] ) . '" height="' . $logo['height'] . '" width="' . $logo['width'] . '" alt="' . get_bloginfo( 'name' ) . '">';
					$str .= '</a>';
				} else {
					$str .= '<a class="logo-image" href="' . get_home_url( '/' ) . '">';
					$str .= '<img class="logo-img-data" data-at2x="' . esc_url( $logo_retina['url'] ) . '" height="' . $logo['height'] . '" width="' . $logo['width'] . '" src="' . esc_url( $logo['url'] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
					$str .= '</a>';
				}

			} else {
				$str .= '<div class="logo-text">';
				$str .= '<strong><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></strong>';
				if ( get_bloginfo( 'description' ) ) {
					$str .= ' <h3 class="tagline">' . get_bloginfo( 'description' ) . '</h3>';
				}
				$str .= '</div>';

			}

			return $str;
		}


		/**
		 * @return string
		 * render header ads
		 */
		static function render_header_ads() {
			$ads_type   = tn_util::get_theme_option( 'header_ads' );
			$google_ads = tn_util::get_theme_option( 'header_google_ads' );
			$img_ads    = tn_util::get_theme_option( 'header_image_ads' );
			$url_ads    = tn_util::get_theme_option( 'header_url_ads' );

			//check & return
			if ( empty( $img_ads['url'] ) && empty( $google_ads ) ) {
				return false;
			}

			if ( empty( $url_ads ) ) {
				$url_ads = '#';
			}

			$str = '';
			$str .= '<div class="header-ads clearfix">';

			if ( ! empty( $img_ads['url'] ) && 1 != $ads_type ) {
				$str .= '<a class="ads-image" href="' . esc_url( $url_ads ) . '"  target="_blank"><img data-no-retina src="' . esc_url( $img_ads['url'] ) . '" alt="' . get_bloginfo( 'name' ) . '"></a>';
			} else {
				$str .= stripcslashes( tn_ads_support::render_google_ads( $google_ads, 'header_ads' ) );
			}
			$str .= '</div><!--#header ads wrap-->';

			return $str;
		}


		/**
		 * @param $name
		 *
		 * @return string
		 * render sidebar
		 */
		static function render_sidebar( $name ) {
			$sticky = tn_util::get_theme_option( 'sticky_sidebar' );

			ob_start();
			if ( ! empty( $sticky ) ) {
				echo '<div id="sidebar" class="sidebar-wrap col-md-4 col-sm-12 clearfix" ' . tn_util::tn_schema_makeup( 'sidebar' ) . '><div class="tn-sidebar-sticky">';
				if ( is_active_sidebar( $name ) ) {
					dynamic_sidebar( $name );
				}
				echo '</div></div><!--#close sidebar -->';
			} else {
				echo '<div id="sidebar" class="sidebar-wrap col-md-4 col-ms-12 clearfix" ' . tn_util::tn_schema_makeup( 'sidebar' ) . '>';
				if ( is_active_sidebar( $name ) ) {
					dynamic_sidebar( $name );
				}
				echo '</div><!--#close sidebar -->';
			}

			return ob_get_clean();
		}


		/**
		 * @return bool|string
		 * render top footer sidebar
		 */
		static function render_top_footer() {
			if ( is_active_sidebar( 'tn_sidebar_top_footer' ) ) {

				ob_start();

				echo '<div class="top-footer-wrap">';
				dynamic_sidebar( 'tn_sidebar_top_footer' );
				echo '</div><!--#top footer-->';

				return ob_get_clean();

			} else {
				return false;
			}
		}


		/**
		 * @param $cat_id
		 *
		 * @return string
		 * render category header
		 */
		static function render_category_header( $cat_id ) {

			//check and return
			if ( empty( $cat_id ) ) {
				return false;
			}
			$cat_name = get_cat_name( $cat_id );
			$cat_decs =  category_description($cat_id);

			$str = '';
			$str .= '<div class="page-heading-wrap tn-container">';
			$str .= '<div class="page-heading-inner">';
			$str .= '<h1 class="cate-heading-content post-title">';
			$str .= '<em>' . esc_html__( 'Category: ', 'tn' ) . '</em><strong>' . $cat_name . '</strong>';
			$str .= '</h1>';

			if(!empty($cat_decs)){
				$str .= '<div class="taxonomy-description">';
				$str .= html_entity_decode( $cat_decs );
				$str .= '</div>';
			}

			$str .= '</div><!--#cate heading inner -->';
			$str .= '</div><!--#heading category -->';

			return $str;
		}


		/**
		 * @return string
		 * render archive header
		 */
		static function render_archive_header() {
			$str = '';

			$str .= '<div class="page-heading-wrap tn-container">';
			$str .= '<div class="page-heading-inner">';
			$str .= '<h1 class="cate-heading-content post-title">';
			$str .= '<em>' . esc_html__( 'archive: ', 'tn' ) . '</em><strong>' . self::archive_title() . '</strong>';
			$str .= '</h1>';
			$str .= '</div><!--#archive heading inner -->';
			$str .= '</div><!--#archive category -->';

			return $str;
		}

		/**
		 * @return string
		 * render archive title
		 */
		static function archive_title() {

			if ( is_category() ) :
				return single_cat_title( '', false );
			elseif ( is_tag() ) :
				return single_tag_title( '', false );
			elseif ( is_author() ) :
				return get_the_author();
			elseif ( is_day() ) :
				return get_the_date();
			elseif ( is_month() ) :
				return get_the_date( 'F Y' );
			elseif ( is_year() ) :
				return get_the_date( 'Y' );
			elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
				return esc_html__( 'Asides', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
				return esc_html__( 'Galleries', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
				return esc_html__( 'Images', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
				return esc_html__( 'Videos', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
				return esc_html__( 'Quotes', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
				return esc_html__( 'Links', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
				return esc_html__( 'Statuses', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
				return esc_html__( 'Audios', 'tn' );
			elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
				return esc_html__( 'Chats', 'tn' );
			else :
				return esc_html__( 'Archives', 'tn' );
			endif;
		}


		/**
		 * @return string
		 * render search page header
		 */
		static function render_search_header() {

			$str          = '';
			$search_title = get_search_query();

			$str .= '<div class="page-heading-wrap tn-container">';
			$str .= '<div class="page-heading-inner">';
			$str .= '<h1 class="cate-heading-content post-title">';
			$str .= '<em>' . esc_html__( 'search for: ', 'tn' ) . '</em><strong>' . esc_attr( $search_title ) . '</strong>';
			$str .= '</h1>';
			$str .= '</div><!--#archive heading inner -->';
			$str .= '</div><!--#archive category -->';

			return $str;
		}

		/**
		 * @return string
		 * render author box
		 */
		static function render_author_header() {
			$str = '';
			$str .= '<div class="page-heading-wrap tn-container">';
			$str .= '<div class="page-author-inner">';
			$str .= tn_single::render_author_box( true );
			$str .= '</div><!--#author heading -->';
			$str .= '</div><!--#author category -->';

			return $str;

		}

	}
}