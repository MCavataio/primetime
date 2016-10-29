<?php
//Pages
if ( ! function_exists( 'tn_theme_options_page' ) ) {
	function tn_theme_options_page() {

		return array(
			'id'    => 'tn_theme_ops_section_pages',
			'title' => esc_html__( 'Page Settings', 'tn' ),
			'desc'  => esc_html__( 'Select options for Pages', 'tn' ),
			'icon'  => 'el el-gift',
		);
	}
}

//default page
if ( ! function_exists( 'tn_default_page_config' ) ) {
	function tn_default_page_config() {
		return array(
			'title'      => esc_html__( 'single page', 'tn' ),
			'id'         => 'tn_theme_ops_section_single_page',
			'desc'       => esc_html__( 'Select options for Pages', 'tn' ),
			'subsection' => true,
			'icon'       => 'el el-icon-file-edit-alt',
			'fields'     => array(

				//default page settings
				array(
					'id'     => 'section_start_single_page',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'single page settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'default_single_page_title',
					'type'     => 'switch',
					'title'    => esc_html__( 'Single page title', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable page title', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'default_single_page_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Single page sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar for default page', 'tn' ),
					'default'  => 'tn_sidebar_default',
					'options'  => tn_init::get_sidebar_options(),
				),
				array(
					'id'       => 'default_single_page_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Single Page Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar position for default page. This option will override default sidebar position setting.', 'tn' ),
					'options'  => tn_init::get_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'       => 'default_single_page_comment_box',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Comment Box', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable the comments on the pages, Default this option is enable', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_page',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			),
		);
	}
}


//Author page
if ( ! function_exists( 'tn_author_page_config' ) ) {
	function tn_author_page_config() {
		return array(
			'title'      => esc_html__( 'author page', 'tn' ),
			'id'         => 'tn_theme_ops_section_author_page',
			'desc'       => esc_html__( 'Select options for author page', 'tn' ),
			'subsection' => true,
			'icon'       => 'el el-icon-file-edit-alt',
			'fields'     => array(
				array(
					'id'     => 'section_start_author_page',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Author Page settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'author_layouts',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Author page layout', 'tn' ),
					'subtitle' => esc_html__( 'Select the layout for this page', 'tn' ),
					'options'  => tn_init::get_block_layouts(),
					'default'  => 'grid'
				),
				array(
					'id'       => 'author_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Author Page Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar for this page', 'tn' ),
					'options'  => tn_init::get_sidebar_options(),
					'default'  => 'tn_sidebar_default'
				),
				array(
					'id'       => 'author_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Author Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar position for this page. This option will override default sidebar position setting.', 'tn' ),
					'options'  => tn_init::get_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'     => 'section_end_author_page',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),

			)
		);
	}
}


//Search page
if ( ! function_exists( 'tn_search_page_config' ) ) {
	function tn_search_page_config() {
		return array(
			'title'      => esc_html__( 'Search page', 'tn' ),
			'desc'       => esc_html__( 'Select options for search page', 'tn' ),
			'id'         => 'tn_theme_ops_section_search_page',
			'subsection' => true,
			'icon'       => 'el el-icon-file-edit-alt',
			'fields'     => array(
				array(
					'id'     => 'section_start_search_page',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Search Page settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'search_layouts',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Search page layout', 'tn' ),
					'subtitle' => esc_html__( 'Select the layout for this page', 'tn' ),
					'options'  => tn_init::get_block_layouts(),
					'default'  => 'grid'
				),
				array(
					'id'       => 'search_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Search Page Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar for this page', 'tn' ),
					'options'  => tn_init::get_sidebar_options(),
					'default'  => 'tn_sidebar_default'
				),
				array(
					'id'       => 'search_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Search Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar position for this page. This option will override default sidebar position setting.', 'tn' ),
					'options'  => tn_init::get_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'     => 'section_end_search_page',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}


//Archive page
if ( ! function_exists( 'tn_archive_page_config' ) ) {
	function tn_archive_page_config() {
		return array(
			'title'      => esc_html__( 'Archive page', 'tn' ),
			'desc'       => esc_html__( 'Select options for archive page', 'tn' ),
			'id'         => 'tn_theme_ops_section_archive_page',
			'subsection' => true,
			'icon'       => 'el el-icon-file-edit-alt',
			'fields'     => array(
				array(
					'id'     => 'section_start_archive_page',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Archive Page settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'archive_layouts',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Archive page Layout', 'tn' ),
					'subtitle' => esc_html__( 'Select the layout for this page', 'tn' ),
					'options'  => tn_init::get_block_layouts(),
					'default'  => 'grid'
				),
				array(
					'id'       => 'archive_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Archive Page Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar for this page', 'tn' ),
					'options'  => tn_init::get_sidebar_options(),
					'default'  => 'tn_sidebar_default'
				),
				array(
					'id'       => 'archive_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Archive Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar position for this page. This option will override default sidebar position setting.', 'tn' ),
					'options'  => tn_init::get_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'     => 'section_end_archive_page',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}
