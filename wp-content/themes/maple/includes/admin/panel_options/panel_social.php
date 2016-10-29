<?php
//Social
if ( ! function_exists( 'tn_theme_options_social' ) ) {
	function tn_theme_options_social() {
		return array(
			'title' => esc_html__( 'Shares & Social', 'tn' ),
			'icon'  => 'el el-instagram',
			'id'    => 'tn_theme_ops_section_social_media',
			'desc'  => '',
		);
	}
}


//Share bar config
if ( ! function_exists( 'tn_share_post_config' ) ) {
	function tn_share_post_config() {
		return array(
			'title'      => esc_html__( 'Shares To Social', 'tn' ),
			'id'         => 'tn_theme_ops_section_share_social',
			'icon'       => 'el el-share',
			'subsection' => true,
			'desc'       => esc_html__( 'These are options for setting up the sites social and share post to social. To add author social, go to the Users -> Your Profile', 'tn' ),
			'fields'     => array(
				//Share bar
				array(
					'id'     => 'section_start_share_post_settings',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Share Post Settings', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'share_to_facebook',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share On Facebook', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable share on Facebook, This default of option is enable', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_to_twitter',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share On Twitter', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable share on Twitter, This default of option is enable', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_to_google_plus',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share On Google Plus', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable share on Google +, This default of option is enable', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_to_pinterest',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share On Pinterest', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable share on Pinsterest, This default of option is enable', 'tn' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'       => 'share_to_linkedin',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share On LinkedIn', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable share on LinkedIn, This default of option is disable', 'tn' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'       => 'share_to_tumblr',
					'type'     => 'switch',
					'title'    => esc_html__( 'Share On Tumblr', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable share on Tumblr, This default of option is disable', 'tn' ),
					'switch'   => true,
					'default'  => 0
				),
				array(
					'id'     => 'section_end_share_post_settings',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}

//Site social
if ( ! function_exists( 'tn_site_social_config' ) ) {
	function tn_site_social_config() {
		return array(
			'title'      => esc_html__( 'Site Social Profile', 'tn' ),
			'icon'       => 'el el-delicious',
			'id'         => 'tn_theme_ops_section_social_profile',
			'subsection' => true,
			'desc'       => esc_html__( 'These are options for setting up the sites social and share post to social. To add author social, go to the Users -> Your Profile', 'tn' ),
			'fields'     => array(
				//Social Profile
				array(
					'id'     => 'section_start_social_profile',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Site Social Profile', 'tn' ),
					'indent' => true
				),
				array(
					'id'       => 'site_social',
					'type'     => 'switch',
					'title'    => esc_html__( 'Social', 'tn' ),
					'subtitle' => esc_html__( 'Enable or disable sites social', 'tn' ),
					'default'  => 1,
				),
				array(
					'id'       => 'tn_facebook',
					'type'     => 'text',
					'required' => array( 'site_social', '=', '1' ),
					'validate' => 'url',
					'title'    => esc_html__( 'Facebook URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_twitter',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Twitter URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_google_plus',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Google+ URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_pinterest',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Pinterest URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_bloglovin',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Bloglovin URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_instagram',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Instagram URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_youtube',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Youtube URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_vimeo',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Vimeo URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_linkedin',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'LinkedIN URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_tumblr',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Tumblr URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_vkontakte',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'VKontakte URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_flickr',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Flickr URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_skype',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Skype URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'       => 'tn_rss',
					'type'     => 'text',
					'validate' => 'url',
					'required' => array( 'site_social', '=', '1' ),
					'title'    => esc_html__( 'Rss URL ', 'tn' ),
					'subtitle' => esc_html__( 'The URL to your account page', 'tn' )
				),
				array(
					'id'     => 'section_end_social_profile',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}