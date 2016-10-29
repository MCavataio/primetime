<?php

// TGM Plugin Activation
require_once get_template_directory() . '/lib/class/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'tn_register_required_plugins' );
function tn_register_required_plugins() {

	$plugins = array(
		array(
			'name'               => 'Envato Market',
			'slug'               => 'envato-market',
			'source'             => get_template_directory() . '/plugins/envato-market.zip',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'               => 'Maple Ruby Import Demo',
			'slug'               => 'maple-ruby-import',
			'source'             => get_template_directory() . '/plugins/maple-ruby-import.zip',
			'required'           => true,
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'               => 'Maple Ruby Shortcodes',
			'slug'               => 'maple-ruby-shortcodes',
			'source'             => get_template_directory() . '/plugins/maple-ruby-shortcodes.zip',
			'required'           => true,
			'version'            => '1.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'     => 'oAuth Twitter Feed for Developers',
			'slug'     => 'oauth-twitter-feed-for-developers',
			'required' => true,
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => 'MailChimp for WordPress',
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       => 'tn',
		'default_path' => '',
		'menu'         => 'maple-default-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'tgmpa' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'tgmpa' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'tgmpa' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'tgmpa' ),
			'notice_can_install_required'     => _n_noop( 'Maple the following plugin: %1$s.', 'Maple requires the following plugins: %1$s.', 'tgmpa' ),
			'notice_can_install_recommended'  => _n_noop( 'Maple recommends the following plugin: %1$s.', 'Maple recommends the following plugins: %1$s.', 'tgmpa' ),
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ),
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ),
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ),
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ),
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with Maple: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with Maple: %1$s.', 'tgmpa' ),
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'tgmpa' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'tgmpa' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'tgmpa' ),
			'nag_type'                        => 'updated'
		)
	);

	tgmpa( $plugins, $config );
}