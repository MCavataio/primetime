<?php
/**
 * Maple functions and definitions
 * @package Maple
 */

//define theme info
define( 'TN_THEME_VERSION', '2.5' );

//load core
require_once get_template_directory() . '/includes/tn_core/tn_init.php';

//load custom field
require_once get_template_directory() . '/includes/admin/tn_cmb.php';


//load TGM Plugin Activation
require_once get_template_directory() . '/includes/admin/tn_plugins.php';

//include custom tinymce
require_once get_template_directory() . '/includes/admin/tinymce/tinymce_action.php';

//Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}


/**
 * load theme text domain
 */
load_theme_textdomain( 'tn', get_template_directory() . '/languages' );


//Load Redux theme settings.
if ( ! class_exists( 'ReduxFramework' ) && file_exists( get_template_directory() . '/lib/ReduxFramework/ReduxCore/framework.php' ) ) {
	require_once get_template_directory() . '/lib/ReduxFramework/ReduxCore/framework.php';
}

//get redux config
require_once get_template_directory() . '/includes/admin/tn_redux.php' ;

/**
 * load tn core file
 */
require_once locate_template( '/includes/tn_core/tn_util.php' );
require_once locate_template( '/includes/tn_core/tn_query.php' );
require_once locate_template( '/includes/tn_core/tn_counter.php' );
require_once locate_template( '/includes/tn_core/tn_custom_style.php' );
require_once locate_template( '/includes/tn_core/tn_post_support.php' );
require_once locate_template( '/includes/tn_core/tn_ads_support.php' );
require_once locate_template( '/includes/tn_core/tn_template_parts.php' );
require_once locate_template( '/includes/tn_core/tn_top_site.php' );
require_once locate_template( '/includes/tn_core/tn_layout.php' );
require_once locate_template( '/includes/tn_core/tn_single.php' );

require_once locate_template( '/includes/tn_core/tn_retina.php' );


/**
 * load custom widget
 */
require_once locate_template( '/includes/widgets/tn_post_widget.php' );
require_once locate_template( '/includes/widgets/tn_flickr_widget.php' );
require_once locate_template( '/includes/widgets/tn_about_widget.php' );
require_once locate_template( '/includes/widgets/tn_ads_widget.php' );
require_once locate_template( '/includes/widgets/tn_fb_widget.php' );
require_once locate_template( '/includes/widgets/tn_instagram_widget.php' );
require_once locate_template( '/includes/widgets/tn_social_widget.php' );
require_once locate_template( '/includes/widgets/tn_twitter_widget.php' );


/**
 * footer widgets
 */
require_once locate_template( '/includes/widgets/tn_footer_instagram.php' );
require_once locate_template( '/includes/widgets/tn_footer_social_counter.php' );

/**
 * Register frontend script
 */
if ( ! function_exists( 'tn_register_frontend_script' ) ) {
	function tn_register_frontend_script() {
		//load css code
		wp_enqueue_style( 'tn-extends-lib-style', get_template_directory_uri() . '/lib/extends_script/extends-style.min.css', array(), TN_THEME_VERSION, 'all' );
		wp_enqueue_style( 'tn-style', get_template_directory_uri() . '/assets/css/tn_style.css', array( 'tn-extends-lib-style' ), TN_THEME_VERSION, 'all' );
		wp_enqueue_style( 'tn-responsive-style', get_template_directory_uri() . '/assets/css/tn_responsive.css', array(
				'tn-extends-lib-style',
				'tn-style'
			), TN_THEME_VERSION, 'all' );
		wp_enqueue_style( 'tn-default', get_stylesheet_uri(), array(
				'tn-extends-lib-style',
				'tn-style',
				'tn-responsive-style'
			), TN_THEME_VERSION );

		//Load comment script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'tn-extends-lib', get_template_directory_uri() . '/lib/extends_script/extends-script.min.js', array( 'jquery' ), TN_THEME_VERSION, true );

		//check & enable retina lib
		$retina_support = tn_util::get_theme_option( 'retina_support' );
		if ( ! empty( $retina_support ) ) {
			wp_enqueue_script( 'tn-retina-lib', get_template_directory_uri() . '/lib/extends_script/retina.min.js', array( 'jquery' ), '1.3.0', true );
		}

		wp_enqueue_script( 'tn-script', get_template_directory_uri() . '/assets/js/tn_script.js', array(
			'jquery',
			'tn-extends-lib'
		), TN_THEME_VERSION, true );
	}

	if ( ! is_admin() ) {
		add_action( 'wp_enqueue_scripts', 'tn_register_frontend_script' );
	}
}

/**
 * Register backend script
 */
if ( ! function_exists( 'tn_register_admin_script' ) ) {
	function tn_register_admin_script( $hook ) {

		//load css
		wp_register_style( 'tn-admin-style', get_template_directory_uri() . '/includes/admin/assets/css/tn_admin_style.css', array(), TN_THEME_VERSION, 'all' );
		wp_enqueue_style( 'tn-admin-style' );

		//load js code
		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_enqueue_script( 'tn-admin-script', get_template_directory_uri() . '/includes/admin/assets/js/tn_admin.js', array( 'jquery' ), TN_THEME_VERSION, true );
		}
	}

	if ( is_admin() ) {
		add_action( 'admin_enqueue_scripts', 'tn_register_admin_script' );
	}
}

/**
 * Register custom redux framework css
 */
if ( ! function_exists( 'tn_register_redux' ) ) {
	function tn_register_redux() {
		wp_register_style( 'tn-redux-css', get_template_directory_uri() . '/includes/admin/assets/css/tn_custom_redux.css', array( 'redux-admin-css' ), TN_THEME_VERSION, 'all' );
		wp_enqueue_style( 'tn-redux-css' );
	}

	if ( is_admin() ) {
		add_action( 'redux/page/tn_theme_options/enqueue', 'tn_register_redux' );
	}
}


/**
 * add theme support
 */
// Default RSS feed links
add_theme_support( 'automatic-feed-links' );

//Add support tag title
add_theme_support( 'title-tag' );

// Html5 support
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widgets' ) );

// Post Formats
add_theme_support( 'post-formats', array( 'gallery', 'image', 'audio', 'video' ) );

// Allow shortcodes in widget text
add_filter( 'widget_text', 'do_shortcode' );


/**
 * resize thumbnail image
 */
add_theme_support( 'post-thumbnails' );
add_image_size( 'tn_classic', 1000, 0, array( 'center', 'center' ) );
add_image_size( 'tn_classic_slider', 1000, 570, array( 'center', 'center' ) );
add_image_size( 'tn_medium_grid', 400, 0, array( 'center', 'center' ) );
add_image_size( 'tn_medium_grid_overlay', 625, 480, array( 'center', 'center' ) );
add_image_size( 'tn_medium_list', 400, 560, array( 'center', 'center' ) );
add_image_size( 'tn_small', 90, 70, array( 'center', 'center' ) );


/**
 * @return array
 * add author information
 */
if ( ! function_exists( 'tn_modify_contact_methods' ) ) {
	function tn_modify_contact_methods() {
		return array(
			'facebook'   => esc_html__( 'Facebook', 'tn' ),
			'twitter'    => esc_html__( 'Twitter', 'tn' ),
			'googleplus' => esc_html__( 'Google Plus', 'tn' ),
			'pinterest'  => esc_html__( 'Pinterest', 'tn' ),
			'linkedin'   => esc_html__( 'Linkedin', 'tn' ),
			'tumblr'     => esc_html__( 'Tumblr', 'tn' ),
			'flickr'     => esc_html__( 'Flickr', 'tn' ),
			'instagram'  => esc_html__( 'Instagram', 'tn' ),
			'skype'      => esc_html__( 'Skype', 'tn' ),
			'myspace'    => esc_html__( 'Myspace', 'tn' ),
			'youtube'    => esc_html__( 'Youtube', 'tn' ),
			'rss'        => esc_html__( 'Rss', 'tn' ),
			'digg'       => esc_html__( 'Digg', 'tn' ),
			'dribbble'   => esc_html__( 'Dribbble', 'tn' ),
			'soundcloud' => esc_html__( 'Soundcloud', 'tn' ),
			'vimeo'      => esc_html__( 'Vimeo', 'tn' ),
		);
	}

	add_filter( 'user_contactmethods', 'tn_modify_contact_methods' );
}


/**
 * register main navigation
 */
register_nav_menu( 'tn_main_nav', esc_html__( 'Main Menu', 'tn' ) );


/**
 * register theme sidebar
 */

//Get multi sidebar
if ( get_option( 'tn_custom_multi_sidebars', false ) ) {
	$current_sidebar = get_option( 'tn_custom_multi_sidebars', '' );
	if ( is_array( $current_sidebar ) ) {
		foreach ( $current_sidebar as $sidebar ) {
			register_sidebar(
				array(
					'name'          => $sidebar['name'],
					'id'            => $sidebar['id'],
					'before_widget' => '<aside class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<div class="widget-title"><h3>',
					'after_title'   => '</h3></div>'
				) ); //#foreach
		}
	}
}

register_sidebar(
	array(
		'name'          => esc_html__( 'Full Width Top Footer', 'tn' ),
		'id'            => 'tn_sidebar_top_footer',
		'description'   => esc_html__( 'Full width area at top of footer area. Only allow {TOP FOOTER WIDGET] & custom html widgets.', 'tn' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-title"><div class="widget-title-inner"><h3>',
		'after_title'   => '</h3></div></div>'
	) );

register_sidebar(
	array(
		'name'          => esc_html__( 'Footer 1', 'tn' ),
		'id'            => 'tn_sidebar_footer_1',
		'description'   => esc_html__( 'One of column of footer area', 'tn' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>'
	) );

register_sidebar(
	array(
		'name'          => esc_html__( 'Footer 2', 'tn' ),
		'id'            => 'tn_sidebar_footer_2',
		'description'   => esc_html__( 'One of column of footer area', 'tn' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-title"><h3>',
		'after_title'   => '</h3></div>'
	) );

register_sidebar(
	array(
		'name'          => esc_html__( 'Footer 3', 'tn' ),
		'id'            => 'tn_sidebar_footer_3',
		'description'   => esc_html__( 'One of column of footer area', 'tn' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-title"><div class="widget-title-inner"><h3>',
		'after_title'   => '</h3></div></div>'
	) );


/**
 * add meta tags to header
 */
if ( ! function_exists( 'tn_opengraph_meta' ) ) {

	function tn_opengraph_meta() {
		global $post;

		//check enable for theme options
		$open_graph = tn_util::get_theme_option( 'open_graph' );
		if ( ! is_singular() || empty( $open_graph ) ) {
			return false;
		}

		echo '<meta property="og:title" content="' . get_the_title() . '"/>';
		echo '<meta property="og:type" content="article"/>';
		echo '<meta property="og:url" content="' . get_permalink() . '"/>';
		echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '"/>';
		echo '<meta property="og:description" content="' . strip_tags( tn_util::render_excerpt( $post, 55, false ) ) . '"/>';
		if ( has_post_thumbnail( $post->ID ) ) {
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'landscape_medium' );
			echo '<meta property="og:image" content="' . esc_url( $thumbnail_src[0] ) . '"/>';
		} else {
			//load logo when no image found.
			$logo = tn_util::get_theme_option( 'header_logo' );
			if ( ! empty( $logo['url'] ) ) {
				echo '<meta property="og:image" content="' . esc_url( $logo['url'] ) . '"/>';
			}
		}
	}

	add_action( 'wp_head', 'tn_opengraph_meta' );
}


/**
 * remove search page result
 */
if ( ! function_exists( 'tn_filter_search' ) ) {

	function tn_filter_search() {
		global $wp_post_types;
		$wp_post_types['page']->exclude_from_search = true;
	}

	add_action( 'init', 'tn_filter_search' );
}


/**
 * render wp_title for old version
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {

	if ( ! function_exists( 'tn_site_title' ) ) {
		function tn_site_title( $title, $sep ) {
			global $paged, $page;

			if ( is_feed() ) {
				return $title;
			}

			// Add the site name.
			$title .= get_bloginfo( 'name' );

			// Add the site description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) {
				$title = "$title $sep $site_description";
			}

			// Add a page number if necessary.
			if ( $paged >= 2 || $page >= 2 ) {
				$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'tn' ), max( $paged, $page ) );
			}

			return $title;
		}
	}

	add_filter( 'wp_title', 'tn_site_title', 10, 2 );

}


/**
 * load html5.js for ie8
 */
if ( ! function_exists( 'tn_ie_html5_shim' ) ) {
	function tn_ie_html5_shim() {
		echo '<!--[if lt IE 9]>';
		echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<![endif]-->';
	}

	add_action( 'wp_head', 'tn_ie_html5_shim', 0 );
}


/**
 * add google analytics to header
 */
if ( ! function_exists( 'tn_analytics_code' ) ) {
	function tn_analytics_code() {
		$tn_analytics = tn_util::get_theme_option( 'google_analytics' );
		echo html_entity_decode( stripcslashes( $tn_analytics ) );
	}

	add_action( 'wp_head', 'tn_analytics_code', 20 );
}


/**
 * add meta tags to header
 */
if ( ! function_exists( 'tn_wp_header' ) ) {
	function tn_wp_header() {
		//get theme options
		$favicon    = tn_util::get_theme_option( 'site_favicon' );
		$apple_icon = tn_util::get_theme_option( 'apple_touch_ion' );
		$metro_icon = tn_util::get_theme_option( 'metro_icon' );
		$site_meta  = tn_util::get_theme_option( 'site_meta' );

		//Add favicon
		if ( ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) && ! empty( $favicon['url'] ) ) {
			echo '<link rel="shortcut icon" href="' . esc_url( $favicon['url'] ) . '" type="image/x-icon" />';
		}

		if ( ! empty( $apple_icon['url'] ) ) {
			echo '<link rel="apple-touch-icon" href="' . esc_url( $apple_icon['url'] ) . '" />';
		}

		if ( ! empty( $metro_icon['url'] ) ) {
			echo '<meta name="msapplication-TileColor" content="#ffffff">';
			echo '<meta name="msapplication-TileImage" content="' . esc_url( $metro_icon['url'] ) . '" />';
		}

		if ( ! empty( $site_meta ) ) {
			echo '<meta name="description" content="' . get_bloginfo( 'description' ) . '">';
		}
	}

	add_action( 'wp_head', 'tn_wp_header', 10 );
}


/**
 * add span wrap for category number in widget
 */
if ( ! function_exists( 'tn_category_post_count' ) ) {
	function tn_category_post_count( $str ) {
		$pos = strpos( $str, '</a> (' );
		if ( false != $pos ) {
			$str = str_replace( '</a> (', '<span class="number-post">', $str );
			$str = str_replace( ')', '</span></a>', $str );
		}

		return $str;
	}

	add_filter( 'wp_list_categories', 'tn_category_post_count' );
};


//add span wrap for archives number in widget
if ( ! function_exists( 'tn_archives_post_count' ) ) {
	function tn_archives_post_count( $str ) {
		$pos = strpos( $str, '</a>&nbsp;(' );
		if ( false != $pos ) {
			$str = str_replace( '</a>&nbsp;(', '<span class="number-post">', $str );
			$str = str_replace( ')', '</span></a>', $str );
		}

		return $str;
	}

	add_filter( 'get_archives_link', 'tn_archives_post_count' );
}


/**
 * add options to javascript
 */
if ( ! function_exists( 'tn_script_options' ) ) {
	function tn_script_options() {
		//get theme options
		$tn_to_top                 = tn_util::get_theme_option( 'site_back_to_top' );
		$tn_to_top_mobile          = intval( tn_util::get_theme_option( 'site_back_to_top_mobile' ) );
		$site_smooth_scroll        = tn_util::get_theme_option( 'site_smooth_scroll' );
		$site_smooth_display       = tn_util::get_theme_option( 'site_smooth_display' );
		$site_smooth_display_style = tn_util::get_theme_option( 'site_smooth_display_style' );
		$single_image_popup        = tn_util::get_theme_option( 'single_post_popup_image' );
		$sticky_navigation         = tn_util::get_theme_option( 'sticky_navigation' );
		$sticky_sidebar            = tn_util::get_theme_option( 'sticky_sidebar' );

		//move to js script
		wp_localize_script( 'tn-script', 'tn_to_top', strval( $tn_to_top ) );
		wp_localize_script( 'tn-script', 'tn_to_top_mobile', strval( $tn_to_top_mobile ) );
		wp_localize_script( 'tn-script', 'site_smooth_scroll', strval( $site_smooth_scroll ) );
		wp_localize_script( 'tn-script', 'site_smooth_display', strval( $site_smooth_display ) );
		wp_localize_script( 'tn-script', 'site_smooth_display_style', $site_smooth_display_style );
		wp_localize_script( 'tn-script', 'tn_single_image_popup', strval( $single_image_popup ) );
		wp_localize_script( 'tn-script', 'tn_sticky_navigation', strval( $sticky_navigation ) );
		wp_localize_script( 'tn-script', 'tn_sidebar_sticky_enable', strval( $sticky_sidebar ) );
	}
}
add_action( 'wp_footer', 'tn_script_options', 10 );


/**
 * change html construction of default gallery
 */
if ( ! function_exists( 'tn_single_gallery' ) ) {
	function tn_single_gallery( $output, $attr ) {
		global $post;

		//check and return
		$enable_grid = tn_util::get_theme_option( 'single post_gallery grid' );
		if ( empty( $enable_grid ) ) {
			return $output;
		}

		static $instance = 0;
		$instance ++;

		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		extract( shortcode_atts(
			array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => 'div',
				'icontag'    => 'div',
				'captiontag' => 'div',
				'columns'    => 3,
				'size'       => 'square_medium',
				'include'    => '',
				'exclude'    => ''
			), $attr ) );

		$id = intval( $id );
		if ( 'RAND' == $order ) {
			$orderby = 'none';
		}

		if ( ! empty( $include ) ) {
			$include      = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts(
				array(
					'include'        => $include,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby
				) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $exclude ) ) {
			$exclude     = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'exclude'        => $exclude,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby
				) );
		} else {
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby
				) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			}

			return $output;
		}

		$captiontag = tag_escape( $captiontag );

		if ( empty( $columns ) ) {
			$columns = 4;
		} //fix empty
		$column_class = 'gallery-col-' . intval( $columns );

		$output = '<div id="gallery-' . $id . '" class="clearfix single-gallery" data-cols = "' . intval( $columns ) . '">';
		foreach ( $attachments as $id => $attachment ) {

			$image_attributes = wp_get_attachment_image_src( $id, $size );
			$image_full       = wp_get_attachment_image_src( $id, 'full' );

			if ( $image_attributes ) {
				$output .= '<a href="' . esc_url( $image_full[0] ) . '" class="' . $column_class . '" title="' . wptexturize( $attachment->post_excerpt ) . '">';
				$output .= '<img src="' . esc_url( $image_attributes[0] ) . '" width="' . esc_attr( $image_attributes[1] ) . '" height="' . esc_attr( $image_attributes[2] ) . '" alt="' . esc_attr( strip_tags( $attachment->post_excerpt ) ) . '">';
				if ( ! empty( $attachment->post_excerpt ) ) {
					$output .= '<' . $captiontag . ' class="gallery-caption">' . esc_attr( strip_tags( $attachment->post_excerpt ) ) . '</' . $captiontag . '>';
				}
				$output .= '</a>';
			}
		}

		$output .= '</div><!--#tn default gallery-->';

		return $output;
	}

	add_filter( 'post_gallery', 'tn_single_gallery', 10, 2 );
}

/**-------------------------------------------------------------------------------------------------------------------------
 * redirect to active plugin
 */
if ( ! function_exists( 'maple_ruby_after_theme_active' ) ) {
	function maple_ruby_after_theme_active() {

		global $pagenow;

		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

			$ruby_first_active = get_option( 'maple_ruby_first_active_theme', '' );
			if ( ! empty( $ruby_first_active ) ) {
				update_option( 'maple_ruby_first_active_theme', '1' );
			} else {
				add_option( 'maple_ruby_first_active_theme', '1' );
			}

			//redirect
			wp_redirect( admin_url( 'admin.php?page=maple-default-plugins' ) );
			exit;
		}
	}

	add_action( 'after_switch_theme', 'maple_ruby_after_theme_active' );
}






