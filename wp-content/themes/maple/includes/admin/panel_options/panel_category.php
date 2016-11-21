<?php
if ( ! function_exists( 'tn_theme_options_category' ) ) {
	function tn_theme_options_category() {
		return array(
			'id'    => 'tn_theme_ops_section_categories',
			'title' => esc_html__( 'Categories', 'tn' ),
			'desc'  => esc_html__( 'Select options for categories', 'tn' ),
			'icon'  => 'el el-folder-open',
		);
	}
}

//Category Options
if ( ! function_exists( 'tn_one_cate_config' ) ) {
	function tn_one_cate_config( $cate_id, $cate_name ) {
		return array(
			'title'      => $cate_name,
			'id'         => 'tn_theme_options_category_el_' . $cate_id,
			'desc'       => esc_html__( 'Select options for this category.', 'tn' ),
			'icon'       => 'el el-cog-alt',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'     => 'section_start_' . $cate_id,
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => $cate_name . esc_html__( ' Category Page Setting', 'tn' ),
					'indent' => true
				),
				//category layout
				array(
					'id'       => 'category_layout_' . $cate_id,
					'type'     => 'image_select',
					'title'    => $cate_name . ' ' . esc_html__( ' Category Layout', 'tn' ),
					'subtitle' => esc_html__( 'Select the layout for this category', 'tn' ),
					'options'  => tn_init::get_block_layouts(),
					'default'  => 'grid',
				),
				array(
					'id'       => 'category_post_first_' . $cate_id,
					'title'    => esc_html__( 'Big Post at First', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable big classic layout at first of page', 'tn' ),
					'type'     => 'switch',
					'default'  => 0
				),
				//category sidebar
				array(
					'id'       => 'category_sidebar_' . $cate_id,
					'type'     => 'select',
					'title'    => $cate_name . ' ' . esc_html__( 'Category Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar for this category', 'tn' ),
					'default'  => 'tn_sidebar_default',
					'options'  => tn_init::get_sidebar_options()
				),
				//category sidebar position
				array(
					'id'       => 'category_sidebar_position_' . $cate_id,
					'type'     => 'image_select',
					'title'    => $cate_name . ' ' . esc_html__( 'Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar position for this category. This option will override default sidebar position setting.', 'tn' ),
					'options'  => tn_init::get_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'     => 'section_end_category_' . $cate_id,
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				)
			)
		);
	}
};
