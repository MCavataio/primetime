<?php
/**
 * Plugin Name: Maple Ruby Shortcodes
 * Plugin URI: http://themeruby.com/
 * Description: display shortcodes for maple theme
 * Version: 1.0
 * Author: Theme Ruby
 * Author URI: http://themeruby.com/
 * @package   maple-ruby-shortcodes
 * @copyright Copyright (c) 2016, Theme Ruby
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class maple_ruby_shortcodes {

	/**
	 * register shortcodes
	 */
	function __construct() {

		// Plugin Folder URL
		if ( ! defined( 'RUBY_SHORTCODES_PLUGIN_URL' ) ) {
			define( 'RUBY_SHORTCODES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'ruby_shortcode_enqueue_scripts' ), 1 );

		//add shortcodes
		add_shortcode( 'button', array( $this, 'ruby_button' ) );
		add_shortcode( 'dropcap', array( $this, 'ruby_dropcap' ) );
		add_shortcode( 'accordion', array( $this, 'ruby_accordion_group' ) );
		add_shortcode( 'accordion-item', array( $this, 'ruby_accordion_item' ) );
		add_shortcode( 'row', array( $this, 'ruby_row' ) );
		add_shortcode( 'column', array( $this, 'ruby_column' ) );

	}


	/**-------------------------------------------------------------------------------------------------------------------------
	 *
	 * load css
	 */
	static function ruby_shortcode_enqueue_scripts() {

		wp_enqueue_style( 'ruby-shortcodes-styles', RUBY_SHORTCODES_PLUGIN_URL . 'ruby-shortcodes-style.css', array(), '1.0', 'all' );
		wp_enqueue_script( 'ruby-shortcodes-scripts', RUBY_SHORTCODES_PLUGIN_URL . 'ruby-shortcodes-script.js', array( 'jquery' ), '1.0', true );

	}

	/**-------------------------------------------------------------------------------------------------------------------------
	 * @param null $content
	 *
	 * @return string
	 */
	static function shortcodes_helper( $content = null ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
		$content = preg_replace( '#<br \/>#', '', $content );

		return trim( $content );
	}


	static function ruby_button( $attrs, $content = null ) {
		extract( shortcode_atts( array(
			'type'   => '',
			'color'  => '',
			'target' => '',
			'link'   => ''
		), $attrs ) );

		$classes      = array();
		$style_inline = '';
		$target       = '';
		$str          = '';

		$classes[] = 'btn btn-shortcode';
		if ( ! empty( $type ) ) {
			$classes[] = 'is-' . strip_tags( $type );
		} else {
			$classes[] = 'is-default';
		}

		if ( ! empty( $color ) ) {
			$style_inline = 'style="background-color: ' . strip_tags( $color ) . '"';
		}

		if ( ! empty( $link ) ) {
			$link = esc_url( $link );
		} else {
			$link = '#';
		}

		if ( ! empty( $target ) ) {
			$target = 'target="blank"';
		}

		$classes = implode( ' ', $classes );

		$str .= '<a class="' . $classes . '" ' . $style_inline . ' ' . $target . ' href="' . $link . '">';
		$str .= esc_attr( $content );
		$str .= '</a>';

		return $str;

	}

	static function ruby_dropcap( $attrs, $content = null ) {
		extract( shortcode_atts( array(
			'type' => '',
		), $attrs ) );

		$classes   = array();
		$classes[] = 'dropcap-shortcode';

		if ( empty( $type ) ) {
			$classes[] = 'is-default';
		} else {
			$classes[] = 'is-' . esc_attr( $type );
		}

		$classes = implode( ' ', $classes );

		return '<span class="' . esc_attr( $classes ) . '">' . $content . '</span>';
	}


	static function ruby_accordion_group( $attrs, $content = null ) {
		return '<div class="accordion-shortcode">' . self::shortcodes_helper( $content ) . ' </div>';
	}


	static function ruby_accordion_item( $attrs, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
		), $attrs ) );

		if ( empty( $title ) ) {
			$title = '';
		}

		$str = '';
		$str .= '<h3 class="accordion-item-title">' . $title . '</h3>';
		$str .= '<div class="accordion-item-content accordion-hide">' . self::shortcodes_helper( $content ) . '</div>';

		return $str;

	}

	static function ruby_row( $attrs, $content = null ) {

		return '<div class="row-shortcode row clearfix">' . self::shortcodes_helper( $content ) . '</div>';

	}

	static function ruby_column( $attrs, $content = null ) {

		extract( shortcode_atts( array(
			'width' => ''
		), $attrs ) );

		if ( empty( $width ) ) {
			$width = '100%';
		}

		switch ( $width ) {
			case '50%'  :
				return '<div class="col-shortcode col-sm-6 col-sx-12">' . self::shortcodes_helper( $content ) . '</div>';
			case '33%'  :
				return '<div class="col-shortcode col-sm-4 col-sx-12">' . self::shortcodes_helper( $content ) . '</div>';
			case '66%' :
				return '<div class="col-shortcode col-sm-8 col-sx-12">' . self::shortcodes_helper( $content ) . '</div>';
			case '25%' :
				return '<div class="col-shortcode col-sm-3 col-sx-12">' . self::shortcodes_helper( $content ) . '</div>';
			default :
				return '<div class="col-shortcode col-xs-12">' . self::shortcodes_helper( $content ) . '</div>';
		}
	}

}

new maple_ruby_shortcodes();