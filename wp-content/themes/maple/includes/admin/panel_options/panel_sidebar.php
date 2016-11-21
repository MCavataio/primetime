<?php
//Sidebar & Widget
if ( ! function_exists( 'tn_theme_options_sidebar' ) ) {
	function tn_theme_options_sidebar() {
		return array(
			'id'     => 'tn_theme_ops_section_sidebar',
			'title'  => esc_html__( 'Sidebar Settings', 'tn' ),
			'desc'   => esc_html__( 'Select options for sidebars', 'tn' ),
			'icon'   => 'el el-briefcase',
			'fields' => array(
				array(
					'id'     => 'section_start_sidebar_general',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Sidebar General Setting', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'site_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Specify the sidebar to use by default. This can be overridden per-page or per-post basis when creating a page or post.', 'tn' ),
					'options'  => tn_init::get_sidebar_position( false ),
					'default'  => 'right'
				),
				array(
					'id'       => 'tn_sidebar_multi',
					'type'     => 'multi_text',
					'class'    => 'medium-text',
					'title'    => esc_html__( 'Custom Multi Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Create or remove an existing sidebar, don\'t forget input name for your sidebar.', 'tn' ),
					'desc'     => esc_html__( 'Click "Create Sidebar" and input name to create sidebar', 'tn' ),
					'add_text' => esc_html__( 'Create Sidebar', 'tn' ),
					'default'  => array()
				),
				array(
					'id'       => 'sticky_sidebar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sticky Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Making sidebar permanently visible when scrolling up and down. Useful when a sidebar is too tall or too short compared to the rest of the content', 'tn' ),
					'default'  => 0
				),
				array(
					'id'     => 'section_end_sidebar_general',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}
