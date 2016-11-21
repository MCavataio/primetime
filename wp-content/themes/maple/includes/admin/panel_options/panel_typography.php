<?php
//typography options
if ( ! function_exists( 'tn_theme_options_typography' ) ) {
	function tn_theme_options_typography() {
		return array(
			'id'     => 'tn_theme_ops_section_typography',
			'title'  => esc_html__( 'Typography', 'tn' ),
			'icon'   => 'el el-font',
			'desc'   => esc_html__( 'Selecting a font will show a basic preview. Go to <a href="http://www.google.com/webfonts" target="_blank">google fonts directory</a> for more details. It is highly recommended that you choose fonts that have similar heights to the default fonts.<br/><br/>To restore to default font settings, click: <strong>Reset Section</strong>', 'tn' ),
			'fields' => array(

				array(
					'id'     => 'section_start_body_font',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Body font', 'tn' ),
					'indent' => true
				),
				//body font
				array(
					'id'             => 'body_font',
					'type'           => 'typography',
					'title'          => esc_html__( 'Body Text Font', 'tn' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => false,
					'letter-spacing' => false,
					'line-height'    => true,
					'all_styles'     => true,
					'units'          => 'px',
					'subtitle'       => esc_html__( 'This font of option effects almost every content on the theme', 'tn' ),
					'default'        => array(
						'font-size'   => '13px',
						'line-height' => '24px',
						'font-weight' => '400',
						'color'       => '#333',
						'google'      => true,
						'font-family' => 'Noticia Text',
					),
					'output'         => array(
						'body',
					)
				),
				array(
					'id'     => 'section_end_body_font',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				//Block font
				array(
					'id'     => 'section_start_blocks_font',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Post Elements Font', 'tn' ),
					'indent' => true
				),
				array(
					'id'             => 'post_title_font',
					'type'           => 'typography',
					'title'          => esc_html__( 'Post Title Font', 'tn' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'all_styles'     => true,
					'units'          => 'px',
					'subtitle'       => esc_html__( 'Select font for post title. This option will affect to slider, classic blog, single page...', 'tn' ),
					'default'        => array(
						'font-size'      => '18px',
						'google'         => true,
						'font-weight'    => '700',
						'letter-spacing' => '1px',
						'font-family'    => 'Lato',
						'text-transform' => 'uppercase',
					),
					'output'         => array(
						'.post-title',
						'.widget-title',
					)
				),
				//category name font
				array(
					'id'             => 'category_name_font',
					'type'           => 'typography',
					'title'          => esc_html__( 'Category Name font', 'tn' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'units'          => 'px',
					'subtitle'       => esc_html__( 'Select the font of meta tags', 'tn' ),
					'default'        => array(
						'font-size'      => '13px',
						'google'         => true,
						'font-weight'    => '400',
						'font-style'     => 'italic',
						'font-family'    => 'Noticia Text',
						'text-transform' => 'capitalize',
					),
					'output'         => array(
						'.category-name-wrap',
						'.single-tag-wrap'
					)
				),
				//meta tags font
				array(
					'id'             => 'meta_font',
					'type'           => 'typography',
					'title'          => esc_html__( 'Meta Tags', 'tn' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'all_styles'     => true,
					'units'          => 'px',
					'subtitle'       => esc_html__( 'Select the font of category name', 'tn' ),
					'default'        => array(
						'font-family'    => 'Noticia Text',
						'font-size'      => '13px',
						'google'         => true,
						'font-weight'    => '400',
						'font-style'     => 'italic',
						'text-transform' => 'capitalize',
					),
					'output'         => array(
						'.meta-tags-wrap'
					)
				),
				array(
					'id'             => 'read_more_font',
					'type'           => 'typography',
					'title'          => esc_html__( 'Read More Font', 'tn' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => false,
					'line-height'    => false,
					'all_styles'     => true,
					'units'          => 'px',
					'subtitle'       => esc_html__( 'Select the font of meta tags', 'tn' ),
					'default'        => array(
						'font-size'      => '11px',
						'google'         => true,
						'font-weight'    => '400',
						'font-family'    => 'Lato',
						'text-transform' => 'uppercase',
					),
					'output'         => array(
						'.read-more-wrap',
						'input[type="submit"]'

					)
				),
				array(
					'id'     => 'section_end_blocks_font',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_logo_font',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Logo Font', 'tn' ),
					'indent' => true
				),
				//logo font
				array(
					'id'             => 'site_logo_font',
					'type'           => 'typography',
					'title'          => esc_html__( 'Site Logo Font', 'tn' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'units'          => 'px',
					'subtitle'       => esc_html__( 'Select font for site logo.', 'tn' ),
					'default'        => array(
						'font-size'      => '60px',
						'letter-spacing' => '2px',
						'google'         => true,
						'color'          => '#333',
						'font-weight'    => '700',
						'font-family'    => 'Lato',
						'text-transform' => 'uppercase',
					),
					'output'         => array(
						'.logo-text strong'
					)
				),
				array(
					'id'     => 'section_end_logo_font',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),

			)
		);
	}
}

