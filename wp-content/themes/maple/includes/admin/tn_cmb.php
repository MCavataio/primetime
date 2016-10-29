<?php
if ( ! function_exists( 'tn_meta_boxes' ) ) {
	function tn_meta_boxes() {
		//GALLERY POST
		$tn_cmb_gallery = new_cmb2_box(
			array(
				'id'           => 'tn_gallery_post',
				'title'        => esc_html__( 'Gallery Post', 'tn' ),
				'object_types' => array( 'post', ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			) );

		$tn_cmb_gallery->add_field(
			array(
				'name'         => esc_html__( 'Upload Gallery', 'tn' ),
				'desc'         => esc_html__( 'select your pictures for gallery', 'tn' ),
				'id'           => 'tn_single_custom_gallery',
				'type'         => 'file_list',
				'preview_size' => array( 100, 100 )
			) );

		$tn_cmb_gallery->add_field(
			array(
				'name'    => esc_html__( 'Gallery Type', 'tn' ),
				'desc'    => esc_html__( 'select type for gallery', 'tn' ),
				'id'      => 'tn_single_custom_gallery_type',
				'type'    => 'select',
				'options' => array(
					'slider' => esc_html__( 'Slider', 'tn' ),
					'grid'   => esc_html__( 'Grid Images', 'tn' )
				)
			) );

		//VIDEO POST
		$tn_cmb_video = new_cmb2_box(
			array(
				'id'           => 'tn_video_post',
				'title'        => esc_html__( 'Video Post', 'tn' ),
				'object_types' => array( 'post', ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			) );

		$tn_cmb_video->add_field(
			array(
				'name' => esc_html__( 'Video URL', 'tn' ),
				'desc' => esc_html__( 'Input link of video (support: Youtube, Vimeo, DailyMotion)', 'tn' ),
				'id'   => 'tn_single_custom_video',
				'type' => 'text',
			) );

		//AUDIO POST
		$tn_cmb_audio = new_cmb2_box(
			array(
				'id'           => 'tn_audio_post',
				'title'        => esc_html__( 'Audio Post', 'tn' ),
				'object_types' => array( 'post', ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			) );

		$tn_cmb_audio->add_field(
			array(
				'name' => esc_html__( 'Audio URL', 'tn' ),
				'desc' => esc_html__( 'Input link of audio (support: SoundCloud)', 'tn' ),
				'id'   => 'tn_single_custom_audio',
				'type' => 'text',
			) );

		$tn_cmb_post = new_cmb2_box(
			array(
				'id'           => 'tn_post_setting',
				'title'        => esc_html__( 'Post Settings', 'tn' ),
				'object_types' => array( 'post', ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			) );

		$tn_cmb_post->add_field(
			array(
				'id'      => 'tn_single_first_paragraph',
				'type'    => 'select',
				'name'    => esc_html__( 'First paragraph', 'tn' ),
				'desc'    => esc_html__( 'Select style for first paragraph, This option will override Theme Options -> Single Post -> First paragraph', 'tn' ),
				'options' => array(
					'default'        => esc_html__( 'Default From Theme Options', 'tn' ),
					'solid-drop-cap' => esc_html__( 'Drop cap with Bg', 'tn' ),
					'drop-cap'       => esc_html__( 'Drop cap', 'tn' ),
					'bold-paragraph' => esc_html__( 'Bold paragraph', 'tn' ),
					'big-paragraph'  => esc_html__( 'Big Italic Text', 'tn' ),
					'none'           => esc_html__( 'None', 'tn' ),
				),
				'default' => 'default'
			) );

		$tn_cmb_post->add_field(
			array(
				'id'      => 'tn_single_custom_sidebar',
				'type'    => 'select',
				'name'    => esc_html__( 'Post Sidebar', 'tn' ),
				'desc'    => esc_html__( 'Select sidebar for this post, This option will override Theme Options -> Single Post -> Default Sidebar option', 'tn' ),
				'options' => tn_init::get_sidebar_options( true ),
				'default' => 'tn_default_from_theme_options'
			) );

		$tn_cmb_post->add_field(
			array(
				'id'      => 'tn_single_sidebar_position',
				'type'    => 'select',
				'name'    => esc_html__( 'Sidebar Position', 'tn' ),
				'options' => array(
					'default' => esc_html__( 'Default From Theme Options', 'tn' ),
					'left'    => esc_html__( 'Left', 'tn' ),
					'right'   => esc_html__( 'Right', 'tn' ),
					'none'    => esc_html__( 'None', 'tn' ),
				),
				'desc'    => esc_html__( 'Select sidebar position for this post, This option will override Theme Options -> Single Post -> Default Sidebar Position option', 'tn' ),
				'default' => 'default'
			) );

		$tn_cmb_post->add_field(
			array(
				'id'      => 'tn_single_comment_box',
				'type'    => 'select',
				'name'    => esc_html__( 'Show Comment Box', 'tn' ),
				'desc'    => esc_html__( 'Enable or disable this post comments box, This option will override Theme Options -> Single Post-> Show Comment Box option', 'tn' ),
				'options' => array(
					'default' => esc_html__( 'Default From Theme Options', 'tn' ),
					'show'    => esc_html__( 'Show', 'tn' ),
					'none'    => esc_html__( 'None', 'tn' )
				),
				'default' => 'default'
			) );

		//PAGE SETTINGS
		$tn_cmb_page = new_cmb2_box(
			array(
				'id'           => 'tn_page_setting',
				'title'        => esc_html__( 'Page Settings', 'tn' ),
				'object_types' => array( 'page', ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
			) );

		$tn_cmb_page->add_field(
			array(
				'id'      => 'tn_page_title',
				'type'    => 'select',
				'name'    => esc_html__( 'Page Title', 'tn' ),
				'desc'    => esc_html__( 'Enable or disable for this page, This option will override Theme Options -> Page Settings -> Single Page -> Title option', 'tn' ),
				'options' => array(
					'default' => esc_html__( 'Default From Theme Options', 'tn' ),
					'show'    => esc_html__( 'Show', 'tn' ),
					'none'    => esc_html__( 'None', 'tn' )
				),
				'default' => 'default'
			) );

		$tn_cmb_page->add_field(
			array(
				'id'      => 'tn_page_custom_sidebar',
				'type'    => 'select',
				'name'    => esc_html__( 'Page Sidebar', 'tn' ),
				'desc'    => esc_html__( 'Select sidebar for this page, This option will override Theme Options -> Page Settings -> Single Page -> Sidebar option', 'tn' ),
				'options' => tn_init::get_sidebar_options( true ),
				'default' => 'tn_default_from_theme_options'
			) );

		$tn_cmb_page->add_field(
			array(
				'id'      => 'tn_page_sidebar_position',
				'type'    => 'select',
				'name'    => esc_html__( 'Sidebar Position', 'tn' ),
				'desc'    => esc_html__( 'Select sidebar position for this page, This option will override Theme Options -> Page Settings -> Default Page -> Default Page Sidebar Position option', 'tn' ),
				'options' => array(
					'default' => esc_html__( 'Default From Theme Options', 'tn' ),
					'left'    => esc_html__( 'Left', 'tn' ),
					'right'   => esc_html__( 'Right', 'tn' ),
					'none'    => esc_html__( 'None', 'tn' ),
				),
				'default' => 'default'
			) );

		$tn_cmb_page->add_field(
			array(
				'id'      => 'tn_page_comment_box',
				'type'    => 'select',
				'name'    => esc_html__( 'Show Comment Box', 'tn' ),
				'desc'    => esc_html__( 'Enable or disable this page comments box, This option will override Theme Options -> Page Settings -> Single Page -> Show Comment Box option', 'tn' ),
				'options' => array(
					'default' => esc_html__( 'Default From Theme Options', 'tn' ),
					'show'    => esc_html__( 'Show', 'tn' ),
					'none'    => esc_html__( 'None', 'tn' )
				),
				'default' => 'default'
			) );
	}
}


/**
 * Initialize the metabox class.
 */

if ( file_exists( get_template_directory() . '/lib/cmb/init.php' ) ) {
	require_once get_template_directory() . '/lib/cmb/init.php';
}

add_action( 'cmb2_init', 'tn_meta_boxes' );

