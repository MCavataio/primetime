<?php
if ( ! function_exists( 'tn_theme_options_blog' ) ) {
	function tn_theme_options_blog() {
		//blog home page setting
		return array(
			'title'  => esc_html__( 'Home Settings', 'tn' ),
			'id'     => 'tn_theme_ops_section_home',
			'desc'   => esc_html__( 'The settings below only apply to homepages that are set to "Your latest posts" in the "Wordpress Settings -> Reading" section.', 'tn' ),
			'icon'   => 'el el-laptop',
			'fields' => array(

				//first post
				array(
					'id'     => 'section_start_first_post',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'First Post At The Top Settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'big_post_first',
					'title'    => esc_html__( 'Big Post at First', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable big classic layout at first of page', 'tn' ),
					'type'     => 'switch',
					'default'  => 1
				),
				array(
					'id'     => 'section_end_first_post',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//blog layout
				array(
					'id'     => 'section_start_home_blog',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Blog Layout Settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'blog_layouts',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Blog Layout', 'tn' ),
					'subtitle' => esc_html__( 'Select the layout for this page', 'tn' ),
					'options'  => tn_init::get_block_layouts(),
					'default'  => 'grid'
				),
				array(
					'id'       => 'unique_post',
					'title'    => esc_html__( 'Unique Post', 'tn' ),
					'subtitle' => esc_html__( 'Don\'t re-display posts if those have displayed in top area. This option maybe causes layout issue if you don\'t have enough post', 'tn' ),
					'type'     => 'switch',
					'default'  => 0
				),
				array(
					'id'     => 'section_end_home_blog',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_home_sidebar',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Home Sidebar Settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'blog_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Home Page Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar for this page', 'tn' ),
					'options'  => tn_init::get_sidebar_options(),
					'default'  => 'tn_sidebar_default'
				),
				array(
					'id'       => 'blog_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Home Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar position for this page. This option will override default sidebar position setting.', 'tn' ),
					'options'  => tn_init::get_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'     => 'section_end_home_sidebar',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}