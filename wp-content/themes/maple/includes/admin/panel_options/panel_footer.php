<?php
if ( ! function_exists( 'tn_theme_options_footer' ) ) {
	function tn_theme_options_footer() {
		//footer setting
		return array(
			'title'  => esc_html__( 'Footer Settings', 'tn' ),
			'id'     => 'tn_theme_ops_section_footer',
			'desc'   => esc_html__( 'The footer uses sidebars to show information. . To add content to the footer head go to the widgets section and drag widget to the Footer 1, Footer 2 and Footer 3 sidebars.', 'tn' ),
			'icon'   => 'el el-align-justify',
			'fields' => array(

				array(
					'id'     => 'section_start_copyright',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Footer Sidebars & Copyright Settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'site_copyright',
					'type'     => 'textarea',
					'title'    => esc_html__( 'footer copyright text', 'tn' ),
					'subtitle' => esc_html__( 'Enter footer copyright text and HTML is allowed (a tag).', 'tn' ),
					'default'  => '',
				),
				//Social media link
				array(
					'id'       => 'site_copyright_social',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Social Link', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable social media Link', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'site_copyright_social_newtab',
					'type'     => 'switch',
					'title'    => esc_html__( 'Open in newtab', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable open social links in newtab', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'     => 'section_end_copyright',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_back_to_top',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'back to top', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'site_back_to_top',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show To Top Button', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable back to top button', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'site_back_to_top_mobile',
					'type'     => 'switch',
					'required' => array( 'site_back_to_top', '=', '1' ),
					'title'    => esc_html__( 'Enable On Mobile', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable back to top button on touch device', 'tn' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'     => 'section_end_general_back_to_top',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}


