<?php
/**
 * Class tn_init
 * this is class load some option for backend, theme options and multi sidebar

 */
if ( ! class_exists( 'tn_init' ) ) {
	class tn_init {
		/**
		 * @return array
		 * sort config
		 */
		static function orderby_array_options() {
			return array(
				'date_post'               => esc_html__( 'Latest Post', 'tn' ),
				'comment_count'           => esc_html__( 'Popular Comment', 'tn' ),
				'popular'                 => esc_html__( 'Popular View', 'tn' ),
				'post_type'               => esc_html__( 'Post Type', 'tn' ),
				'rand'                    => esc_html__( 'Random', 'tn' ),
				'author'                  => esc_html__( 'Author', 'tn' ),
				'alphabetical_order_decs' => esc_html__( 'Title DECS', 'tn' ),
				'alphabetical_order_asc'  => esc_html__( 'Title ACS', 'tn' ),
			);
		}


		/**
		 * @param bool $default
		 * @return array
		 * sidebar config
		 */
		static function get_sidebar_position( $default = true ) {
			$sidebar = array(
				'none'  => array(
					'alt'   => 'none sidebar',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/none.png',
					'title' => esc_html__( 'None', 'tn' )
				),
				'left'  => array(
					'alt'   => 'left sidebar',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/left-sidebar.png',
					'title' => esc_html__( 'Left', 'tn' )
				),
				'right' => array(
					'alt'   => 'right sidebar',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/right-sidebar.png',
					'title' => esc_html__( 'Right', 'tn' )
				)
			);

			//load default setting
			if ( $default ) {
				$sidebar['default'] = array(
					'alt'   => 'Default',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/default.png',
					'title' => esc_html__( 'Default', 'tn' )
				);
			}

			return $sidebar;
		}


		/**
		 * @return array
		 * return category config
		 */
		static function get_all_cate() {
			$categories = get_categories( array(
				                              'hide_empty' => 0,
			                              ) );

			return $categories;
		}

		/**
		 * @param string $display_default
		 *
		 * @return array
		 * multi sidebar config
		 */
		static function get_sidebar_options( $display_default = '' ) {
			$sidebar_options = array();
			$custom_sidebars = get_option( 'tn_custom_multi_sidebars', '' );

			//add default sidebar
			if ( $display_default === true ) {
				$sidebar_options['tn_default_from_theme_options'] = esc_html__( 'Default From Theme Options', 'tn' );
			}

			//handle sidebar option
			if ( ! empty( $custom_sidebars ) ) {
				foreach ( $custom_sidebars as $sidebar ) {
					$sidebar_options[ $sidebar['id'] ] = $sidebar['name'];
				}
			};

			return $sidebar_options;
		}


		/**
		 * save sidebar to database
		 */
		static function save_custom_sidebars() {
			global $tn_theme_options;
			$multi_sidebar = get_option( 'tn_custom_multi_sidebars', '' );
			$data          = array();

			//add default sidebar
			$data[] = array(
				'id'   => 'tn_sidebar_default',
				'name' => esc_html__( 'Default Sidebar', 'tn' ),
			);

			if ( ! empty( $tn_theme_options['tn_sidebar_multi'] ) && is_array( $tn_theme_options['tn_sidebar_multi'] ) ) {
				foreach ( $tn_theme_options['tn_sidebar_multi'] as $sidebar ) {
					array_push( $data, array(
						'id'   => 'tn_sidebar_multi_' . self::name_to_id( $sidebar ),
						'name' => strip_tags( $sidebar ),
					) );
				}
			}

			//save to database
			if ( ! empty( $multi_sidebar ) ) {
				update_option( 'tn_custom_multi_sidebars', $data );
			} else {
				add_option( 'tn_custom_multi_sidebars', $data );
			}
		}

		/**
		 * @return array
		 * blog layout config
		 */
		static function get_block_layouts() {
			return array(
				'grid'    => array(
					'alt'   => 'grid layout',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/grid-layout.png',
					'title' => esc_html__( 'Grid Layout', 'tn' )
				),
				'list'    => array(
					'alt'   => 'list posts block',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/list-layout.png',
					'title' => esc_html__( 'List Layout', 'tn' )
				),
				'classic' => array(
					'alt'   => 'default classic layout',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/classic-layout.png',
					'title' => esc_html__( 'Classic Layout', 'tn' )
				),
			);
		}


		/**
		 * @return array
		 * get featured layout config
		 */
		static function get_featured_layout() {
			return array(
				'none'     => array(
					'alt'   => 'none',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/featured-none.png',
					'title' => esc_html__( 'None', 'tn' )
				),
				'carousel' => array(
					'alt'   => 'carousel slider',
					'img'   => get_template_directory_uri() . '/includes/admin/assets/images/featured-carousel.png',
					'title' => esc_html__( 'Carousel Slider', 'tn' )
				),
			);
		}


		/**
		 * @param $name
		 * @return mixed
		 * create unique id from name
		 */
		static function name_to_id($name)
		{
			$name = strtolower(strip_tags($name));
			$id = str_replace(array(' ', ',', '.', '"', "'", '/', "\\", '+', '=', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`', '<', '>', '?', '[', ']', '{', '}', '|', ':',), '', $name);
			return $id;
		}
	}
}


// save multi sidebar actions
add_action( 'after_switch_theme', array( 'tn_init', 'save_custom_sidebars' ) );
add_action( 'redux/options/tn_theme_options/saved', array( 'tn_init', 'save_custom_sidebars' ) );
add_action( 'redux/options/tn_theme_options/reset', array( 'tn_init', 'save_custom_sidebars' ) );
add_action( 'redux/options/tn_theme_options/section/reset', array( 'tn_init', 'save_custom_sidebars' ) );
