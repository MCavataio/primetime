<?php
//post options
if ( ! function_exists( 'tn_theme_options_post' ) ) {
	function tn_theme_options_post() {
		//get sidebar setting
		$sidebar_options = tn_init::get_sidebar_options();

		return array(
			'title'  => esc_html__( 'Single Settings', 'tn' ),
			'id'     => 'tn_theme_ops_section_single_post',
			'desc'   => esc_html__( 'Select options for single post page', 'tn' ),
			'icon'   => 'el el-book',
			'fields' => array(

				// Single Post Design
				array(
					'id'     => 'section_start_single_options',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Single post design', 'tn' ),
					'indent' => true
				),
				//LAYOUT SETTING
				array(
					'id'       => 'single_post_first_paragraph',
					'type'     => 'select',
					'title'    => esc_html__( 'First paragraph', 'tn' ),
					'subtitle' => esc_html__( 'Select style for first paragraph', 'tn' ),
					'options'  => array(
						'solid-drop-cap' => esc_html__( 'Drop cap with Bg', 'tn' ),
						'drop-cap'       => esc_html__( 'Drop cap', 'tn' ),
						'bold-paragraph' => esc_html__( 'Bold paragraph', 'tn' ),
						'big-paragraph'  => esc_html__( 'Big Italic Text', 'tn' ),
						'none'           => esc_html__( 'None', 'tn' ),

					),
					'default'  => 'solid-drop-cap'
				),
				array(
					'id'       => 'single_post_popup_image',
					'title'    => esc_html__( 'Popup Images When Clicks', 'tn' ),
					'subtitle' => esc_html__( 'Popup when click on images, this options will affect to images when like of image has been set "media file".', 'tn' ),
					'type'     => 'switch',
					'default'  => 1
				),
				array(
					'id'       => 'single post_gallery grid',
					'title'    => esc_html__( 'Enable Popup For Single Gallery', 'tn' ),
					'subtitle' => esc_html__( 'Change default post gallery post in single content into maple gallery grid with popup, Disable it if you want to use 3rd plugin to display gallery', 'tn' ),
					'type'     => 'switch',
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_options',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//SINGLE SIDEBAR
				array(
					'id'     => 'section_start_single_sidebar',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Single post sidebar settings', 'tn' ),
					'indent' => true
				),
				//default sidebar
				array(
					'id'       => 'single_default_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Default Post Sidebar', 'tn' ),
					'subtitle' => esc_html__( 'Select sidebar for single post page', 'tn' ),
					'options'  => $sidebar_options,
					'default'  => 'tn_sidebar_default'
				),
				//default sidebar position
				array(
					'id'       => 'single_default_sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Default Sidebar Position', 'tn' ),
					'subtitle' => esc_html__( 'Select Position sidebar for single post page, this option will override default sidebar position setting.', 'tn' ),
					'options'  => tn_init::get_sidebar_position(),
					'default'  => 'default'
				),
				array(
					'id'     => 'section_end_single_sidebar',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//Single Comment box
				array(
					'id'     => 'section_start_single_box',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Comment box setting', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'single_comment_box',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Comment Box', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable the comments on the pages, Default this option is disable', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_author_box',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Author Box', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable the author box', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_navigation_box',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Next and Pre Posts', 'tn' ),
					'subtitle' => esc_html__( 'Show or hide `next` and `previous` posts', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_single_box',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//Related box
				array(
					'id'     => 'section_start_single_related_box',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Navigation box settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'single_related_box',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Related Box', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable the related posts on the single post page', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'single_related_where',
					'type'     => 'select',
					'required' => array( 'single_related_box', '=', '1' ),
					'title'    => esc_html__( 'Display Related Posts', 'tn' ),
					'subtitle' => esc_html__( 'What posts should be displayed', 'tn' ),
					'options'  => array(
						'all'        => esc_html__( 'Same tags & categories', 'tn' ),
						'tags'       => esc_html__( 'Same tags', 'tn' ),
						'categories' => esc_html__( 'Same categories', 'tn' ),
					),
					'default'  => 'all'
				),
				array(
					'id'     => 'section_end_single_related_box',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//SOCIAL SETTING
				array(
					'id'     => 'section_start_single_social',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Social Settings', 'tn' ),
					'indent' => true
				),
				//bottom shares
				array(
					'id'       => 'single_share_social',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share On Social Bar', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable share on social bar at bottom of single content.', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				//like tweet g+
				array(
					'id'       => 'social_like_post',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Post LIKE/TWEET/G+', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable the post like/tweet/g+ on post', 'tn' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'     => 'section_end_single_social',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			),
		);
	}
}
