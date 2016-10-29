<?php

if ( ! function_exists( 'maple_ruby_imported_demo' ) ) {
	function maple_ruby_imported_demo( $demo_active_import ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );

		//delete hello word
		wp_delete_post( 1 );

		/************************************************************************
		 * Setting Menus
		 *************************************************************************/

		$ruby_menu_array = array( 'maple' );

		if ( isset( $demo_active_import[ $current_key ]['directory'] ) && ! empty( $demo_active_import[ $current_key ]['directory'] ) && in_array( $demo_active_import[ $current_key ]['directory'], $ruby_menu_array ) ) {
			$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

			if ( isset( $main_menu->term_id ) ) {
				set_theme_mod( 'nav_menu_locations', array(
						'tn_main_nav' => $main_menu->term_id,
					)
				);
			}

		}
	}

	//setup menu
	add_action( 'wbc_importer_after_content_import', 'maple_ruby_imported_demo', 10, 2 );
}


if ( ! function_exists( 'maple_ruby_remove_default_widget' ) ) {
	function maple_ruby_remove_default_widget() {


		$sidebars_widgets['tn_sidebar_default']    = array();
		$sidebars_widgets['tn_sidebar_top_footer'] = array();
		$sidebars_widgets['tn_sidebar_footer_1']   = array();
		$sidebars_widgets['tn_sidebar_footer_2']   = array();
		$sidebars_widgets['tn_sidebar_footer_3']   = array();

		//clear social cache
		delete_transient( 'tn_footer_instagram_data' );
		delete_transient( 'tn_instagram_widget_data' );

		update_option( 'sidebars_widgets', $sidebars_widgets );

	}

	//remove widget
	add_action( 'wbc_importer_before_widget_import', 'maple_ruby_remove_default_widget', 10, 2 );
}
