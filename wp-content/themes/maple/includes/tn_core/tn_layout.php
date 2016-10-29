<?php
/**
 * Class tn_layout
 * This file render layout for page

 */
if ( ! class_exists( 'tn_layout' ) ) {
	class tn_layout {
		/**
		 * @param $options
		 *
		 * @return string
		 * render page layout
		 */
		static function render_layout( $options ) {
			$main_class = array();
			$el_class   = array();
			$el_data    = '';

			switch ( $options['post_block'] ) {
				case 'grid' :
					$el_class[]   = 'grid-layout-outer';
					$el_class[]   = 'col-sm-6 col-xs-12';
					$el_class[]   = 'masonry-el';
					$main_class[] = 'is-masonry';
					$el_data      = 'data-cols = "2"';
					break;

				case 'list' :
					$el_class[] = 'list-layout-outer';
					$el_class[] = 'col-xs-12';
					break;
			};

			$main_class[] = 'tn-container'; //test version

			//check sidebar
			if ( 'none' != $options['sidebar_position'] ) {
				$main_class[] = 'is-sidebar';
				if ( 'left' == $options['sidebar_position'] ) {
					$main_class[] = 'left-sidebar';
				} else {
					$main_class[] = 'right-sidebar';
				}
			} else {
				$main_class[] = 'no-sidebar';
			}


			$main_class = implode( ' ', $main_class );

			$el_class = implode( ' ', $el_class );

			//get current page
			$flag = false; //for big first post
			if ( get_query_var( 'paged' ) == 0 ) {
				$flag = true;
			}

			$str = '';
			$str .= '<div id="main-content-wrap" class="row clearfix ' . $main_class . '">';
			if ( 'none' != $options['sidebar_position'] ) {
				$str .= '<div id="main" class="col-md-8 col-sm-12">';
			} else {
				$str .= '<div id="main" class="col-xs-12">';
			}

			if ( have_posts() ) {
				$counter = 1;

				if ( ( false == $flag && 1 == $options['big_first'] ) || ( 1 != $options['big_first'] ) ) {
					$str .= '<div class="main-content-inner">';
				}

				while ( have_posts() ) {
					the_post();

					//check unique post
					if ( ! empty( $options['unique'] ) && 1 == $options['unique'] && is_array( $GLOBALS['tn_unique_posts'] ) && in_array( get_the_ID(), $GLOBALS['tn_unique_posts'] ) ) {
						continue;
					}

					//render first post layout
					if ( ( true === $flag ) && ( 1 == $options['big_first'] ) ) {
						$str .= '<div class="first-post-wrap">';
						$str .= self::render_classic();
						$str .= '</div>';
						$str .= '<div class="main-content-inner">'; //remove outer wrap of big post.
						$flag = false;
						continue;
					}

					//render post layout
					if ( 'grid' == $options['post_block'] ) {
						//
						$str .= '<div class="' . $el_class . '" ' . $el_data . '>';
						$str .= self::render_grid();
						$str .= '</div><!--# grid col -->';

						//break line at bottom of grid
						if ( ! empty( $col_config['data'] ) && 1 < $col_config['data'] && 0 == $counter % 2 ) {
							$str .= '<div class="break-line clearfix"></div><!--#clear bottom -->';
						}
						$counter ++;

					} elseif ( 'list' == $options['post_block'] ) {
						$str .= '<div class="' . $el_class . '">';
						$str .= self::render_list();
						$str .= '</div><!--# list col -->';

					} else {
						$str .= self::render_classic();
					}

				}

				$str .= '</div><!--#main content inner-->';

				$str .= tn_util::render_pagination(); //pagination

			} //#have posts

			$str .= '</div><!--#main-->';

			//render sidebar
			if ( ! empty( $options['sidebar_position'] ) && 'none' != $options['sidebar_position'] ) {
				$str .= tn_template_parts::render_sidebar( $options['sidebar_name'] );
			}

			$str .= '</div><!--#main site wrap -->';

			return $str;
		}


		/**
		 * @param        $id
		 * @param string $layout
		 * @param        array
		 *
		 * @return string
		 * render block thumbnails
		 */
		static function render_block_thumbnail( $id, $layout = 'grid' ) {
			//check and return
			if ( empty ( $id ) ) {
				return false;
			}

			switch ( $layout ) {
				case 'grid' :
					$thumb_size = 'tn_medium_grid';
					break;
				case 'grid_overlay' :
					$thumb_size = 'tn_medium_grid_overlay';
					break;
				case 'list' :
					$thumb_size = 'tn_medium_list';
					break;
				default :
					$thumb_size = 'tn_classic';
					break;
			};

			$post_format = get_post_format( $id );

			if ( 'gallery' == $post_format && 'classic' == $layout ) {
				return tn_post_support::render_gallery( $id );
			};

			if ( ( 'video' == $post_format || 'audio' == $post_format ) && 'classic' == $layout ) {
				return tn_post_support::thumb_type( $id );
			}

			return tn_util::render_thumb( $id, $thumb_size );
		}


		/**
		 * @param array $data
		 *
		 * @return string
		 * render meta tags
		 */
		static function render_meta_tags( $data = array() ) {
			$str = '';
			if ( empty( $data ) ) {
				$data = array(
					'date'    => true,
					'author'  => true,
					'comment' => true,
				);
			}

			$str .= '<div class="meta-tags-wrap post-el">';
			if ( is_array( $data ) ) {
				foreach ( $data as $key => $val ) {
					switch ( $key ) {
						case 'date' :
							$str .= tn_util::render_date( get_the_ID() );
							break;
						case 'author' :
							$str .= tn_util::render_author( get_post() );
							break;
						case 'tag' :
							$str .= tn_util::render_tag( get_the_ID() );
							break;
						case 'view' :
							$str .= tn_util::render_view( get_the_ID() );
							break;
						case 'comment' :
							$str .= tn_util::render_comment_count( get_the_ID() );
							break;
					}
				}
			}
			$str .= '</div><!--#tags wrap -->';

			return $str;
		}


		/**
		 * @return string
		 * render grid layout
		 */
		static function render_grid() {
			$block_class    = array();
			$block_class[]  = 'post-wrap';
			$block_class[]  = 'grid-layout';
			$excerpt_length = tn_util::get_theme_option( 'excerpt_length' );


			$block_class = implode( ' ', $block_class );

			$str = '';
			$str .= '<article class="' . $block_class . ' clearfix">';

			$str .= self::render_block_thumbnail( get_the_ID(), 'grid' );
			$str .= '<div class="post-inner grid-inner">';
			$str .= tn_util::render_category_name( get_the_ID() );
			$str .= tn_util::render_title( get_the_ID(), 'small' );
			$str .= self::render_meta_tags( array( 'date' => true, 'author' => true, 'comment' => true ) );
			$str .= '</div><!--#grid inner -->';
			$str .= tn_util::render_excerpt( get_post(), $excerpt_length );

			$str .= tn_util::render_readmore( get_the_ID() );

			$str .= '<div class="post-footer">';
			$str .= tn_util::render_post_format( get_the_ID() );
			$str .= tn_util::render_share_post( get_the_ID() );
			$str .= '</div><!--#post footer-->';

			$str .= '</article><!--#post block-->';

			return $str;
		}


		/**
		 * @return string
		 * render gird overlay for carousel slider
		 */
		static function render_grid_overlay() {
			$block_class   = array();
			$block_class[] = 'post-wrap';
			$block_class[] = 'grid-overlay-layout';

			$block_class = implode( ' ', $block_class );

			$str = '';
			$str .= '<article class="' . $block_class . ' clearfix">';
			$str .= self::render_block_thumbnail( get_the_ID(), 'grid_overlay' );
			$str .= '<div class="post-inner grid-overlay-inner">';
			$str .= tn_util::render_category_name( get_the_ID() );
			$str .= tn_util::render_title( get_the_ID() );
			$str .= self::render_meta_tags( array( 'date' => true ) );
			$str .= '</div><!--#post inner -->';
			$str .= '</article><!--#post block-->';

			return $str;
		}


		/**
		 * @return string
		 * render list layout
		 */
		static function render_list() {
			$block_class    = array();
			$block_class[]  = 'post-wrap';
			$block_class[]  = 'list-layout';
			$block_class    = implode( ' ', $block_class );
			$excerpt_length = tn_util::get_theme_option( 'excerpt_length' );

			$str = '';
			$str .= '<article class="' . $block_class . ' clearfix">';

			$str .= '<div class="col-sm-6 col-xs-12 is-col-thumb">';
			$str .= self::render_block_thumbnail( get_the_ID(), 'list' );
			$str .= '</div>';

			$str .= '<div class="col-sm-6 col-xs-12 is-col-content">';
			$str .= '<div class="post-inner list-inner">';
			$str .= tn_util::render_category_name( get_the_ID() );
			$str .= tn_util::render_title( get_the_ID(), 'small' );
			$str .= self::render_meta_tags( array( 'date' => true, 'author' => true, 'comment' => true ) );
			$str .= '</div><!--#post inner -->';
			$str .= tn_util::render_excerpt( get_post(), $excerpt_length );
			$str .= tn_util::render_readmore( get_the_ID() );
			$str .= '<div class="post-footer">';
			$str .= tn_util::render_post_format( get_the_ID() );
			$str .= tn_util::render_share_post( get_the_ID() );
			$str .= '</div><!--#post footer-->';

			$str .= '</div>';
			$str .= '</article><!--#post block-->';

			return $str;
		}


		/**
		 * @return string
		 * render gird overlay for carousel slider
		 */
		static function render_classic() {
			$block_class            = array();
			$post_format            = get_post_format();
			$classic_summary_type   = tn_util::get_theme_option( 'classic_summary_type' );
			$classic_excerpt_length = tn_util::get_theme_option( 'classic_excerpt_length' );

			$block_class[] = 'post-wrap';
			$block_class[] = 'classic-layout';
			if ( ! empty( $post_format ) ) {
				$block_class[] = 'is-post-format';
			}

			$block_class = implode( ' ', $block_class );

			$str = '';
			$str .= '<article id="post-' . get_the_ID() . '" class="' . $block_class . '">';

			$str .= self::render_block_thumbnail( get_the_ID(), 'classic' );

			$str .= '<div class="post-inner classic-inner">';
			$str .= tn_util::render_category_name( get_the_ID() );
			$str .= tn_util::render_title( get_the_ID() );
			$str .= self::render_meta_tags();
			$str .= '</div><!--#post inner -->';
			$str .= '<div class="tn-break clearfix"></div>';

			//entry post
			$first_paragraph = get_post_meta( get_the_ID(), 'tn_single_first_paragraph', true );
			if ( 'default' == $first_paragraph ) {
				$first_paragraph = tn_util::get_theme_option( 'single_post_first_paragraph' );
			}

			//remove bold paragraph
			if ( 'bold-paragraph' == $first_paragraph ) {
				$first_paragraph = 'none';
			}
			$entry_class   = array();
			$entry_class[] = $first_paragraph;
			$entry_class[] = 'entry post-el';
			$entry_class   = implode( ' ', $entry_class );

			if ( ! empty( $classic_summary_type ) ) {
				$str .= '<div class="' . $entry_class . '">';
				$content = get_the_content( '' );
				$content = apply_filters( 'the_content', $content );
				$content = str_replace( ']]>', ']]&gt;', $content );

				$str .= $content;
				$str .= '</div><!--#entry-->';
			} else {
				$str .= tn_util::render_excerpt( get_post(), $classic_excerpt_length );
			}


			$str .= tn_util::render_readmore( get_the_ID(), 'medium-btn' );

			$str .= '<div class="post-footer">';
			$str .= tn_util::render_post_format( get_the_ID() );
			$str .= tn_util::render_share_post( get_the_ID() );
			$str .= '</div><!--#post footer-->';

			$str .= '</article><!--#post block-->';

			return $str;
		}

	}
}
