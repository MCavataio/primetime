<?php
if ( ! function_exists( 'tn_theme_options_header' ) ) {
	function tn_theme_options_header() {
		//header settings
		return array(
			'title'  => esc_html__( 'Header Settings', 'tn' ),
			'id'     => 'tn_theme_ops_section_header',
			'desc'   => esc_html__( 'Select options for site header', 'tn' ),
			'icon'   => 'el el-road',
			'fields' => array(

				//header style
				array(
					'id'     => 'section_start_header_style',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Logo Area Setting', 'tn' ),
					'indent' => true
				),
				//top header background type
				array(
					'id'       => 'header_background_type',
					'type'     => 'switch',
					'title'    => esc_html__( 'Top Header Background Type', 'tn' ),
					'subtitle' => esc_html__( 'Select background type for top header, Header ads will not display when you select image background type.', 'tn' ),
					'default'  => 1,
					'on'       => 'Color',
					'off'      => 'Image',
				),
				array(
					'id'          => 'header_background_color',
					'required'    => array( 'header_background_type', '=', '1' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'default'     => '#ffffff',
					'title'       => esc_html__( 'Top header background color', 'tn' ),
					'subtitle'    => esc_html__( 'Select background color for top header', 'tn' ),
				),
				array(
					'id'       => 'header_background_url',
					'type'     => 'media',
					'required' => array( 'header_background_type', '=', '0' ),
					'title'    => esc_html__( 'Top Header Background Image', 'tn' ),
					'subtitle' => esc_html__( 'Upload background for logo area. We recommended image size have at least 1366px width and less than 500px height', 'tn' )
				),
				array(
					'id'       => 'header_background_height',
					'type'     => 'text',
					'class'    => 'small-text',
					'required' => array( 'header_background_type', '=', '0' ),
					'validate' => 'numeric',
					'title'    => esc_html__( 'Background Height', 'tn' ),
					'default'  => 350,
					'subtitle' => esc_html__( 'Height of header background, default is 350px. (Set this value < height of image for parallax animation.)', 'tn' )
				),
				array(
					'id'       => 'header_parallax',
					'type'     => 'switch',
					'required' => array( 'header_background_type', '=', '0' ),
					'title'    => esc_html__( 'Parallax when scrolling', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable parallax animation when scrolling', 'tn' ),
					'default'  => 1
				),
				array(
					'id'       => 'header_social_bar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Social Bar', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable social icon in header. This options will not work in same logo & menu mode.', 'tn' ),
					'default'  => 1
				),
				array(
					'id'       => 'header_social_bar_style',
					'type'     => 'switch',
					'required' => array( 'header_social_bar', '=', '1' ),
					'title'    => esc_html__( 'Social Color', 'tn' ),
					'subtitle' => esc_html__( 'Select color for header social bar.', 'tn' ),
					'default'  => 1,
					'on'       => 'Dark',
					'off'      => 'Light',
				),
				array(
					'id'     => 'section_end_header_style',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//site logo settings
				array(
					'id'     => 'section_start_site_logo',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'logo settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'logo',
					'type'     => 'media',
					'title'    => esc_html__( 'Header logo', 'tn' ),
					'subtitle' => esc_html__( 'Upload your logo, recommended size is (360*160)px, allowed extensions are .jpg, .png and .gif', 'tn' )
				),
				array(
					'id'       => 'logo_retina',
					'type'     => 'media',
					'title'    => esc_html__( 'Header logo Retina', 'tn' ),
					'subtitle' => esc_html__( 'Upload your retina logo, (x2 size of your logo), allowed extensions are .jpg, .png and .gif', 'tn' )
				),
				array(
					'id'       => 'logo_width',
					'title'    => esc_html__( 'Max width of logo', 'tn' ),
					'subtitle' => esc_html__( 'Select max width value (px) for logo image. This option only effect to image logo.', 'tn' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'default'  => 400
				),
				array(
					'id'       => 'logo_padding',
					'title'    => esc_html__( 'Top & Bottom Logo Padding', 'tn' ),
					'subtitle' => esc_html__( 'Select padding (px) for logo. This option will not work when set background header image, but you can set height of header in "Background Height" option', 'tn' ),
					'type'     => 'text',
					'class'    => 'small-text',
					'validate' => 'numeric',
					'default'  => 45
				),
				array(
					'id'     => 'section_end_site_logo',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//  Main Navigation
				array(
					'id'     => 'section_start_main_navigation',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Navigation settings', 'tn' ),
					'indent' => true
				),
				//NAVIGATION FONT
				array(
					'id'             => 'main_menu_font',
					'type'           => 'typography',
					'title'          => esc_html__( 'Navigation Font', 'tn' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'units'          => 'px',
					'subtitle'       => esc_html__( 'Select the font of main navigation. You can set Height for menu by set <strong>Line Height</strong> value.', 'tn' ),
					'default'        => array(
						'font-size'      => '13px',
						'letter-spacing' => '1px',
						'google'         => true,
						'font-weight'    => '700',
						'font-family'    => 'Lato',
						'text-transform' => 'uppercase',
					),
					'output'         => array(
						'#navigation'
					)
				),
				array(
					'id'          => 'background_nav_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Navigation Color', 'tn' ),
					'subtitle'    => esc_html__( 'Select background color for navigation.', 'tn' ),
				),
				array(
					'id'          => 'text_nav_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Navigation Text Color', 'tn' ),
					'subtitle'    => esc_html__( 'Select color for navigation text.', 'tn' ),
				),
				array(
					'id'       => 'sticky_navigation',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sticky Navigation', 'tn' ),
					'subtitle' => esc_html__( 'This makes navigation float at the top when the user scrolls up below the fold - essentially making navigation menu always visible.', 'tn' ),
					'default'  => 1
				),
				array(
					'id'       => 'search_icon',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Search Icon', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable search icon in navigation.', 'tn' ),
					'default'  => 1
				),
				array(
					'id'     => 'section_end_main_navigation',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_header_ads',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Header Ads Settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'header_ads',
					'type'     => 'switch',
					'title'    => esc_html__( 'Google Ads/Custom Ads', 'tn' ),
					'subtitle' => esc_html__( 'Select type of ads at top header. This option only available in Top Header', 'tn' ),
					'default'  => 1,
					'on'       => 'Google Ads',
					'off'      => 'Custom Ads',
				),
				array(
					'id'       => 'header_google_ads',
					'type'     => 'textarea',
					'validate' => 'js',
					'required' => array( 'header_ads', '=', '1' ),
					'title'    => esc_html__( 'Google Ads Code', 'tn' ),
					'subtitle' => esc_html__( 'Paste in your entire Google ads Code here, The Theme support Ads Responsive', 'tn' ),
				),
				array(
					'id'       => 'header_image_ads',
					'type'     => 'media',
					'required' => array( 'header_ads', '=', '0' ),
					'title'    => esc_html__( 'Ads Image ', 'tn' ),
					'subtitle' => esc_html__( 'Enter the image URL', 'tn' ),
				),
				array(
					'id'       => 'header_url_ads',
					'type'     => 'text',
					'required' => array( 'header_ads', '=', '0' ),
					'title'    => esc_html__( 'Ads Url ', 'tn' ),
					'subtitle' => esc_html__( 'Enter the custom Ads Url', 'tn' ),
					'validate' => 'url',
					'default'  => '',
				),
				array(
					'id'     => 'section_end_header_ads',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}