<?php
if ( ! function_exists( 'tn_theme_options_featured' ) ) {
	function tn_theme_options_featured() {
		//featured slider setting
		return array(
			'title'  => esc_html__( 'Featured Area', 'tn' ),
			'id'     => 'tn_theme_ops_section_featured',
			'desc'   => esc_html__( 'Select options for featured area', 'tn' ),
			'icon'   => 'el el-bullhorn',
			'fields' => array(

				//featured area
				array(
					'id'     => 'section_start_header_featured',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Featured Top Area Settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'featured_style',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Featured Style', 'tn' ),
					'subtitle' => esc_html__( 'Select style for featured area. Classic Overlay Blog design will affect to gird and slider layout', 'tn' ),
					'options'  => tn_init::get_featured_layout(),
					'default'  => 'carousel'
				),
				array(
					'id'       => 'featured_cate',
					'type'     => 'select',
					'data'     => 'categories',
					'multi'    => true,
					'title'    => esc_html__( 'Categories Filter', 'tn' ),
					'subtitle' => esc_html__( 'Select categories for featured slider, you can select multi category. leave blank if you select all category.', 'tn' ),
				),
				array(
					'id'       => 'featured_tag',
					'type'     => 'select',
					'data'     => 'tags',
					'multi'    => true,
					'title'    => esc_html__( 'Tags Filter', 'tn' ),
					'subtitle' => esc_html__( 'Select tags for featured slider, you can select multi tags. Leave blank if you don\'t select any tags.', 'tn' ),
				),
				array(
					'id'       => 'featured_sort',
					'type'     => 'select',
					'title'    => esc_html__( 'Sorted By', 'tn' ),
					'subtitle' => esc_html__( 'Select sort type for featued slider', 'tn' ),
					'options'  => tn_init::orderby_array_options(),
					'default'  => 'date_post'
				),
				array(
					'id'       => 'featured_num',
					'title'    => esc_html__( 'Number of Posts', 'tn' ),
					'subtitle' => esc_html__( 'Select number of post for featured slider', 'tn' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'default'  => 6
				),
				array(
					'id'       => 'featured_offset',
					'title'    => esc_html__( 'Offset of Posts', 'tn' ),
					'subtitle' => esc_html__( 'Select number of posts to displace or pass over. beginning number is 0', 'tn' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'default'  => 0
				),
				array(
					'id'     => 'section_end_header_featured',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}