<?php
/**
 * this is general setting config
 */
if ( ! function_exists( 'tn_theme_options_general' ) ) {
	function tn_theme_options_general() {
		return array(
			'title'  => esc_html__( 'General Settings', 'tn' ),
			'id'     => 'tn_theme_ops_section_general',
			'desc'   => esc_html__( 'Select options for general setting', 'tn' ),
			'icon'   => 'el el-icon-globe',
			'fields' => array(

				//site background
				array(
					'id'     => 'section_start_site_bg',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Site Background Settings', 'tn' ),
					'indent' => true,
				),
				array(
					'id'            => 'site_container_width',
					'type'          => 'slider',
					'title'         => esc_html__( 'Max width of Content', 'tn' ),
					'subtitle'      => esc_html__( 'Controls the overall site width. In px, ex: 1080px. default value is 1110px', 'tn' ),
					'default'       => 1110,
					'min'           => 960,
					'max'           => 1200,
					'step'          => 10,
					'display_value' => 'text',
				),
				array(
					'id'          => 'site_background',
					'type'        => 'background',
					'transparent' => false,
					'title'       => esc_html__( 'Site Background', 'tn' ),
					'subtitle'    => esc_html__( 'Site background with image, color, etc', 'tn' ),
					'default'     => array(
						'background-color'      => '#f7f7f7',
						'background-size'       => 'cover',
						'background-attachment' => 'fixed',
						'background-position'   => 'center center',
						'background-repeat'     => 'no-repeat'
					),
					'output'      => array( 'body' ),
				),
				array(
					'id'     => 'section_end_site_bg',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_smooth_style',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Smooth Style Settings', 'tn' ),
					'indent' => true,
				),
				//smooth scroll
				array(
					'id'       => 'site_smooth_scroll',
					'type'     => 'switch',
					'title'    => esc_html__( 'Smooth Scroll', 'tn' ),
					'subtitle' => esc_html__( 'Smooth scrolling with the mouse wheel in all browsers', 'tn' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'site_smooth_display',
					'type'     => 'switch',
					'title'    => esc_html__( 'Smooth Display', 'tn' ),
					'subtitle' => esc_html__( 'Add animation to display images when scrolling down a page', 'tn' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'site_smooth_display_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Animation Style', 'tn' ),
					'required' => array( 'site_smooth_display', '=', '1' ),
					'subtitle' => esc_html__( 'Select animation style for display images when scrolling down', 'tn' ),
					'options'  => array(
						'tn-zoom'   => esc_html__( 'Zoom In', 'tn' ),
						'tn-fade'   => esc_html__( 'Fade In', 'tn' ),
						'tn-bottom' => esc_html__( 'Fade Form Bottom', 'tn' )
					),
					'default'  => 'tn-zoom'
				),
				array(
					'id'     => 'section_end_smooth_style',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false,
				),
				array(
					'id'     => 'section_start_miscellaneous',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Miscellaneous Settings', 'tn' ),
					'indent' => true,
				),
				array(
					'id'       => 'site_favicon',
					'type'     => 'media',
					'title'    => esc_html__( 'Site favicon', 'tn' ),
					'subtitle' => esc_html__( 'Upload a favicon image (18x18)px. That option will don\'t affect in WORDPRESS 4.3. Use default site icon feature of Wordpress.', 'tn' )
				),
				array(
					'id'       => 'apple_touch_ion',
					'type'     => 'media',
					'title'    => esc_html__( 'iOS Bookmarklet Icon', 'tn' ),
					'subtitle' => esc_html__( 'Upload icon for the Apple touch (72 x 72px), allowed extensions are .jpg, .png, .gif', 'tn' ),
					'desc'     => esc_html__( '72 x 72px', 'tn' )
				),
				array(
					'id'       => 'metro_icon',
					'type'     => 'media',
					'title'    => esc_html__( 'Metro UI Bookmartlet Icon', 'tn' ),
					'subtitle' => esc_html__( 'Upload icon for the Metro interface (144 x 144px), allowed extensions are .jpg, .png, .gif', 'tn' ),
					'desc'     => esc_html__( '144 x 144px', 'tn' )
				),
				//retina support
				array(
					'id'       => 'retina_support',
					'type'     => 'switch',
					'title'    => esc_html__( 'Retina Support', 'tn' ),
					'subtitle' => esc_html__( 'Enable this option if you want show higher quality images on high resolution screens.', 'tn' ),
					'desc'     => html_entity_decode( esc_html__( 'Please <a href="https://wordpress.org/plugins/regenerate-thumbnails/">regenerate</a> your thumbnails if you change any of this setting!', 'tn' ) ),
					'default'  => 0,
				),
				array(
					'id'       => 'start_views',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Post Views Forgery', 'tn' ),
					'subtitle' => esc_html__( 'Random specify value to add to number of views for each post', 'tn' ),
					'desc'     => esc_html__( 'Input your value ie: 1000 . The theme random select around(+/-500) that value to add to real number of article views', 'tn' ),
					'default'  => 0
				),
				array(
					'id'       => 'hide_category_bar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Hide Category Bar', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable category bar', 'tn' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'excerpt_length',
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Excerpt length', 'tn' ),
					'subtitle' => esc_html__( 'Select length of excerpt.', 'tn' ),
					'default'  => 20
				),
				array(
					'id'       => 'classic_summary_type',
					'title'    => esc_html__( 'Classic Summary Types', 'tn' ),
					'subtitle' => esc_html__( 'Select summary type for classic layouts', 'tn' ),
					'type'     => 'switch',
					'default'  => 1,
					'on'       => 'Use Read More Tag',
					'off'      => 'Use Excerpt',
				),
				array(
					'id'       => 'classic_excerpt_length',
					'type'     => 'text',
					'title'    => esc_html__( 'Classic excerpt length', 'tn' ),
					'subtitle' => esc_html__( 'Select length of excerpt for all classic blocks, leave blank or set is 0 if you want disable excerpt', 'tn' ),
					'required' => array( 'classic_summary_type', '=', 0 ),
					'class'    => 'small-text',
					'validate' => 'numeric',
					'default'  => 100
				),
				array(
					'id'       => 'site_readmore_text',
					'type'     => 'text',
					'validate' => 'text',
					'title'    => esc_html__( 'Read More - Text', 'tn' ),
					'subtitle' => esc_html__( 'Input text for read more button. Default is "Read More"', 'tn' ),
					'default'  => 'continue reading',
				),
				array(
					'id'     => 'section_end_miscellaneous',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false,
				),
				array(
					'id'     => 'section_start_google_analytics',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Seo & Analytics Settings', 'tn' ),
					'indent' => true,
				),
				//meta description
				array(
					'id'       => 'site_meta',
					'type'     => 'switch',
					'title'    => esc_html__( 'Enable Meta Description', 'tn' ),
					'subtitle' => esc_html__( 'You can disable the meta description tag when using the SEO plugin like Yoast. Default for this option is enable', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				//open graph
				array(
					'id'       => 'open_graph',
					'type'     => 'switch',
					'title'    => esc_html__( 'Open Graph', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable open graph. disable it if you use open graph plugin for SEO', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				//google analytics
				array(
					'id'       => 'google_analytics',
					'type'     => 'textarea',
					'validate' => 'js',
					'title'    => esc_html__( 'Google Analytics Code', 'tn' ),
					'subtitle' => esc_html__( 'Enter your Google Analytics Code or other tracking code. The code must including script tag', 'tn' ),
					'default'  => '',
				),
				array(
					'id'     => 'section_end_google_analytics',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false,
				),
			)
		);
	}
}
