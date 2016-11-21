<?php
//Color Set
if ( ! function_exists( 'tn_theme_options_color' ) ) {
	function tn_theme_options_color() {
		return array(
			'id'     => 'tn_theme_ops_section_color',
			'title'  => esc_html__( 'Color Settings', 'tn' ),
			'desc'   => esc_html__( 'Select color for theme. Leave blank if you want set default of theme.', 'tn' ),
			'icon'   => 'el el-brush',
			'fields' => array(

				//Theme color
				array(
					'id'     => 'section_start_theme_color',
					'type'   => 'section',
					'class'  => 'tn-section-start',
					'title'  => esc_html__( 'Main Color', 'tn' ),
					'indent' => true
				),
				array(
					'id'          => 'main_theme_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Main Theme Color', 'tn' ),
					'subtitle'    => esc_html__( 'Select main theme color.', 'tn' ),
				),
				array(
					'id'       => 'title_background_style',
					'type'     => 'switch',
					'title'    => esc_html__( 'Title Background Style', 'tn' ),
					'subtitle' => esc_html__( 'Select background style for title.', 'tn' ),
					'default'  => 0,
					'on'       => 'Light Style',
					'off'      => 'Dark Style',
				),
				array(
					'id'     => 'section_end_theme_color',
					'type'   => 'section',
					'class'  => 'tn-section-end',
					'indent' => false
				),
			)
		);
	}
}


