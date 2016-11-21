<?php
/**
 * Redux Framework Maple Config File
 */

//load onclick
if ( class_exists( 'maple_ruby_one_lick_to_import' ) ) {
	add_action( 'redux/extensions/tn_theme_options/before', array(
			'maple_ruby_one_lick_to_import',
			'maple_ruby_register_extension_loader'
		), 0 );
}

require_once get_template_directory() . '/includes/admin/ruby_imported.php';



if ( ! class_exists( 'Redux' ) ) {
	return false;
}


/**-------------------------------------------------------------------------------------------------------------------------
 * remove redux sample config & notice
 */
if ( ! function_exists( 'maple_ruby_redux_remove_notice' ) ) {

	function maple_ruby_redux_remove_notice() {
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		}
	}

	add_action( 'redux/loaded', 'maple_ruby_redux_remove_notice' );
}


//load options files
require_once get_template_directory() . '/includes/admin/panel_options/panel_general.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_header.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_featured.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_blog.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_footer.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_sidebar.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_typography.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_single.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_page.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_social.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_color.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_category.php';
require_once get_template_directory() . '/includes/admin/panel_options/panel_custom.php';

// This is your option name where all the Redux data is stored.
$opt_name = 'tn_theme_options';

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

 */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	// TYPICAL -> Change these values as you need/desire
	'opt_name'             => $opt_name,
	// This is where your data is stored in the database and also becomes your global variable name.
	'display_name'         => $theme->get( 'Name' ),
	// Name that appears at the top of your panel
	'display_version'      => $theme->get( 'Version' ),
	// Version that appears at the top of your panel
	'menu_type'            => 'menu',
	//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu'       => true,
	// Show the sections below the admin menu item or not
	'menu_title'           => esc_html__( 'Theme Options', 'tn' ),
	'page_title'           => esc_html__( 'Theme Options', 'tn' ),
	// You will need to generate a Google API key to use this feature.
	// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
	'google_api_key'       => '',
	// Set it you want google fonts to update weekly. A google_api_key value is required.
	'google_update_weekly' => false,
	// Must be defined to add google fonts to the typography module
	'async_typography'     => true,
	// Use a asynchronous font on the front end or font string
	//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
	'admin_bar'            => true,
	// Show the panel pages on the admin bar
	'admin_bar_icon'       => 'dashicons-admin-generic',
	// Choose an icon for the admin bar menu
	'admin_bar_priority'   => 50,
	// Choose an priority for the admin bar menu
	'global_variable'      => '',
	// Set a different name for your global variable other than the opt_name
	'dev_mode'             => false,
	// Show the time the page took to load, etc
	'update_notice'        => false,
	// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	'customizer'           => false,
	//disable CDN
	//  'use_cdn' => false,

	// Enable basic customizer support
	//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
	//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

	// OPTIONAL -> Give you extra features
	'page_priority'        => null,
	// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_parent'          => 'themes.php',
	// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	'page_permissions'     => 'manage_options',
	// Permissions needed to access the options panel.
	'menu_icon'            => '',
	// Specify a custom URL to an icon
	'last_tab'             => '',
	// Force your panel to always open to a specific tab (by id)
	'page_icon'            => 'icon-themes',
	// Icon displayed in the admin panel next to your menu_title
	'page_slug'            => 'maple_options',
	// Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
	'save_defaults'        => true,
	// On load save the defaults to DB before user clicks save or not
	'default_show'         => false,
	// If true, shows the default value next to each field that is not the default value.
	'default_mark'         => '',
	// What to print by the field's title if the value shown is default. Suggested: *
	'show_import_export'   => true,
	// Shows the Import/Export panel when not used as a field.

	// CAREFUL -> These options are for advanced use only
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	'output_tag'           => true,
	// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	'database'             => '',
	// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	'system_info'          => false,
	// REMOVE

	//'compiler'             => true,

	// HINTS
	'hints'                => array(
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => 'lightgray',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color'   => 'light',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			),
		),
	)
);

// --> THEME CONFIGS
Redux::setArgs( $opt_name, $args );

/**
 * As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
 */

// -> START THEME SETTINGS
Redux::setSection( $opt_name, tn_theme_options_general() );

//Header
Redux::setSection( $opt_name, tn_theme_options_header() );

//Sidebar
Redux::setSection( $opt_name, tn_theme_options_sidebar() );

//Footer
Redux::setSection( $opt_name, tn_theme_options_footer() );

//Featured
Redux::setSection( $opt_name, tn_theme_options_featured() );

//Home
Redux::setSection( $opt_name, tn_theme_options_blog() );

//Single
Redux::setSection( $opt_name, tn_theme_options_post() );

//Category
Redux::setSection( $opt_name, tn_theme_options_category() );
$categories = tn_init::get_all_cate();
foreach ( $categories as $category ) {
	Redux::setSection( $opt_name, tn_one_cate_config( $category->term_id, esc_attr( $category->name ) ) );
}

//Pages
Redux::setSection( $opt_name, tn_theme_options_page() );
Redux::setSection( $opt_name, tn_default_page_config() );
Redux::setSection( $opt_name, tn_author_page_config() );
Redux::setSection( $opt_name, tn_search_page_config() );
Redux::setSection( $opt_name, tn_archive_page_config() );

//Typography
Redux::setSection( $opt_name, tn_theme_options_typography() );

//Color
Redux::setSection( $opt_name, tn_theme_options_color() );

//Social share
Redux::setSection( $opt_name, tn_theme_options_social() );
Redux::setSection( $opt_name, tn_share_post_config() );
Redux::setSection( $opt_name, tn_site_social_config() );

//Custom code
Redux::setSection( $opt_name, tn_theme_options_custom_code() );

//Import & export Settings
Redux::setSection( $opt_name, tn_theme_options_import() );


