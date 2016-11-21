<?php

/**-------------------------------------------------------------------------------------------------------------------------
 * add tinymce to wysywyg
 */
if ( ! function_exists( 'ruby_add_tinymce' ) ) {

	function ruby_add_tinymce() {
		global $typenow;

		if ( 'post' != $typenow && 'page' != $typenow ) {
			return false;
		}

		add_filter( 'mce_buttons', 'maple_ruby_tinymce_add_button' );
		add_filter( 'mce_external_plugins', 'maple_ruby_tinymce_plugin' );

	}

	add_action( 'admin_head', 'ruby_add_tinymce' );
}

if ( ! function_exists( 'maple_ruby_tinymce_plugin' ) ) {
	function maple_ruby_tinymce_plugin( $plugin_array ) {

		$plugin_array['maple_ruby_shortcode'] = get_template_directory_uri() . '/includes/admin/tinymce/tinymce_script.js';

		return $plugin_array;
	}
}

if ( ! function_exists( 'maple_ruby_tinymce_add_button' ) ) {
	function maple_ruby_tinymce_add_button( $buttons ) {

		array_push( $buttons, 'ruby_button_key' );

		return $buttons;
	}
}
