<?php
//custom css & js
if ( ! function_exists( 'tn_theme_options_custom_code' ) ) {
	function tn_theme_options_custom_code() {
		return array(
			'title'  => esc_html__( 'Custom CSS', 'tn' ),
			'id'     => 'tn_theme_ops_section_custom_css',
			'icon'   => 'el el-stackoverflow',
			'desc'   => esc_html__( 'Custom CSS will be added at end of all other customizations and thus can be used to overwrite rules', 'tn' ),
			'fields' => array(
				array(
					'id'       => 'custom_css',
					'type'     => 'ace_editor',
					'title'    => esc_html__( 'CSS Code', 'tn' ),
					'subtitle' => esc_html__( 'Enter your CSS code here.', 'tn' ),
					'mode'     => 'css',
					'theme'    => 'monokai',
					'default'  => ''
				),

			),
		);
	}
}

//import & export
if ( ! function_exists( 'tn_theme_options_import' ) ) {
	function tn_theme_options_import() {

		return array(
			'title'  => esc_html__( 'Import / Export', 'tn' ),
			'id'     => 'tn_theme_ops_section_export_import',
			'desc'   => esc_html__( 'Import and Export your settings from file, text or URL.', 'tn' ),
			'icon'   => 'el el-inbox',
			'fields' => array(
				array(
					'id'         => 'tn-import-export',
					'type'       => 'import_export',
					'title'      => 'Import Export',
					'subtitle'   => 'Save and restore your Options',
					'full_width' => false,
				),
			),
		);
	}
}


