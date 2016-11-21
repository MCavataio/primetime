<?php
/**
 * Class tn_single
 * This file render single post layout
 */
if ( ! class_exists( 'tn_single' ) ) {
	class tn_single {
		/**
		 * @return string
		 * render single classic layout
		 */
		static function render_single() {
			$str = '';

			$str .= self::open_wrap();

			//render single header
			$str .= '<article class="' . implode( ' ', get_post_class( 'single-el' ) ) . '" ' . tn_util::tn_schema_makeup( 'article' ) . '>';

			$str .= '<div class="single-heading post-inner">';
			$str .= tn_util::render_category_name( get_the_ID() );
			$str .= self::render_title();
			$str .= tn_layout::render_meta_tags(
				array(
					'date'    => true,
					'author'  => true,
					'comment' => true,
					'view'    => true,
				) );
			$str .= '</div><!--#single heading-->';
			$str .= self::render_single_shares();

			//remove featured in attachment page
			if ( ! is_attachment() ) {
				$str .= self::render_single_thumbnail();
			}

			//render entry elements
			$str .= self::render_post_entry();
			$str .= self::render_tag_box();
			$str .= self::render_like();
			$str .= '<div class="single-footer">';
			$str .= tn_util::render_post_format( get_the_ID() );
			$str .= self::render_single_shares( true );
			$str .= '</div>';

			$str .= self::single_schema_makeup();

			$str .= '</article><!--#single article -->';

			$str .= self::render_single_nav();
			$str .= self::render_author_box();
			$str .= self::render_related();
			$str .= self::render_comment_box();

			$str .= '</div><!--#single classic layout wrap -->';

			//render sidebar
			$str .= self::render_sidebar();

			$str .= '</div><!--# single main wrap -->';

			return $str;
		}


		/**
		 * @return string
		 * render single title
		 */
		static function render_title() {
			$str = '';
			$str .= '<div class="post-title post-el single-title">';
			$str .= '<h1>';
			$str .= get_the_title();
			$str .= '</h1>';
			$str .= '</div><!--#single title -->';

			return $str;
		}


		/**
		 * @return string
		 * render single thumbnail
		 */
		static function render_single_thumbnail() {
			$id          = get_the_ID();
			$post_format = get_post_format();


			if ( 'gallery' == $post_format ) {
				return tn_post_support::render_gallery( $id );
			};

			if ( ( 'video' == $post_format || 'audio' == $post_format ) ) {
				return tn_post_support::thumb_type( $id );
			}

			return self::render_thumb( $id );
		}

		/**
		 * @param $id
		 * @return string
		 * render thumbnail as html
		 */
		static function render_thumb( $id ) {
			$name = 'classic';
			$str  = '';
			$str .= '<div class="thumb-wrap post-el">';
			if ( has_post_thumbnail( $id ) ) {
				$tn_thumbnail = get_the_post_thumbnail( $id, $name );
				if ( ! empty( $tn_thumbnail ) ) {
					$str .= $tn_thumbnail;
				} else {
					$str .= '<div class="no-thumb"><i class="fa fa-camera"></i></div>';
				}
			} else {
				$str .= '<div class="no-thumb"><i class="fa fa-camera"></i></div>';
			}
			$str .= '</div><!--#single thumb wrap-->';

			return $str;
		}


		/**
		 * @return string
		 * render post entry
		 */
		static function render_post_entry() {
			$first_paragraph = get_post_meta( get_the_ID(), 'tn_single_first_paragraph', true );

			if ( 'default' == $first_paragraph ) {
				$first_paragraph = tn_util::get_theme_option( 'single_post_first_paragraph' );
			}

			$class   = array();
			$class[] = 'entry';
			$class[] = $first_paragraph;

			$class = implode( ' ', $class );

			$str = '';
			$str .= '<div class="' . $class . '">';

			$content = get_the_content();
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );

			$pagination = wp_link_pages(
				array(
					'before'      => '<div class="single-page-links">' . esc_html__( 'Pages:', 'tn' ),
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'echo'        => 0
				) );

			$str .= $content;
			$str .= $pagination;

			$str .= '</div><!--#entry -->';

			return $str;
		}


		/**
		 * @return string
		 * render social like fb,twitter,g+ button
		 */
		static function render_like() {
			//check & return
			$check = tn_util::get_theme_option( 'social_like_post' );
			if ( ! is_singular() || empty( $check ) ) {
				return false;
			};

			$twitter_user = get_the_author_meta( 'twitter' );
			$str          = '';
			$str .= '<div class="like-wrap">';
			$str .= '<ul>';
			//twitter
			$str .= '<li class="like-el twitter-like">';
			$str .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . get_permalink() . '" data-text="' . esc_attr( get_the_title() ) . '" data-via="' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '" data-lang="en">tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			$str .= '</li>';
			//facebook
			$str .= '<li class="like-el facebook-like">';
			$str .= '<iframe src="http://www.facebook.com/plugins/like.php?href=' . get_permalink() . '&amp;layout=button_count&amp;show_faces=false&amp;width=105&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:105px; height:21px; background-color:transparent;"></iframe>';
			$str .= '</li>';
			//google
			$str .= '<li  class="like-el google-like">';
			$str .= '
                <div class="g-plusone" data-size="medium" data-href="' . get_permalink() . '"></div>
                <script type="text/javascript">
                    (function() {
                        var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
                        po.src = "https://apis.google.com/js/plusone.js";
                        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
                    })();
                </script>
                ';
			$str .= '</li>';
			$str .= '</ul>';
			$str .= '</div>';

			return $str;
		}


		/**
		 * @param bool
		 * @return string
		 * render single author box
		 */
		static function render_author_box() {
			//check author box enable
			$author_box = tn_util::get_theme_option( 'single_author_box' );
			if ( empty( $author_box ) ) {
				return false;
			}

			$author_id     = get_the_author_meta( 'ID' );
			$author_social = tn_util::render_author_social( $author_id );
			$author_decs   = get_the_author_meta( 'description' );

			//render author box
			$str = '';
			$str .= '<div id="single-author-box" class="author-box clearfix single-el">';

			$str .= '<div class="author-thumb">';
			$str .= get_avatar( get_the_author_meta( 'user_email' ), 105, '', get_the_author_meta( 'display_name' ) );
			$str .= '</div>';

			$str .= '<div class="author-title widget-title"><h3><a href="' . get_author_posts_url( $author_id ) . '">' . get_the_author_meta( 'display_name' ) . '</a></h3></div>';

			//author desc
			if ( ! empty( $author_decs ) ) {
				$str .= '<div class="author-description">' . $author_decs . '</div>';
			}

			if ( ! empty( $author_social ) ) {
				$str .= '<div class="author-box-footer">';
				$str .= '<div class="author-social">' . $author_social . '</div><!--author-social-->';
				$str .= '</div>';
			}
			$str .= '</div><!--#author box -->';

			return $str;
		}

		/**
		 * @return bool|string
		 * render single comment box
		 */
		static function render_comment_box() {
			//single post
			$comment_box = get_post_meta( get_the_ID(), 'tn_single_comment_box', true );

			if ( 'none' == $comment_box ) {
				return false;
			}

			if ( 'default' == $comment_box || empty( $comment_box ) ) {
				$comment_box = tn_util::get_theme_option( 'single_comment_box' );
			}
			if ( empty( $comment_box ) ) {
				return false;
			}

			//render comment box
			if ( comments_open() || get_comments_number() ) {
				ob_start();
				comments_template();

				return ob_get_clean();

			} else {
				return false;
			}
		}


		/**
		 * @return string
		 * render single next prev pagination
		 */
		static function render_single_nav() {
			//check & return
			$nav_box = tn_util::get_theme_option( 'single_navigation_box' );
			if ( ! is_singular() || empty( $nav_box ) ) {
				return false;
			}


			$previous = get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return false;
			}

			$str = '';
			$str .= ' <div class="single-nav clearfix single-el row" role="navigation">';


			if ( null != $previous ) {
				$str .= '<div class="col-sm-6 col-xs-12 nav-left">';
				$str .= '<div class="nav-arrow fa fa-angle-left"></div>';
				$str .= '<div class="nav-sub-title">' . esc_html__( 'previous story', 'tn' ) . '</div>';
				$str .= tn_util::render_title( $previous->ID, 'small' );
				$str .= '</div><!--# left nav -->';
			}

			if ( null != $next ) {
				$str .= '<div class="col-sm-6 col-xs-12 nav-right">';
				$str .= '<div class="nav-arrow fa fa-angle-right"></div>';
				$str .= '<div class="nav-sub-title">' . esc_html__( 'next story', 'tn' ) . '</div>';
				$str .= tn_util::render_title( $next->ID, 'small' );
				$str .= '</div><!--# right nav -->';
			}


			$str .= '</div><!--#nav wrap -->';

			return $str;
		}


		/**
		 * @return bool|string
		 * render single tags box
		 */
		static function render_tag_box() {
			$tags = get_the_tags();
			if ( ! empty( $tags ) ) {
				$str = '';
				$str .= '<div class="single-tag-wrap">';
				foreach ( $tags as $tag ) {
					$tag_link = get_tag_link( $tag->term_id );
					$str .= '<a href="' . esc_url( $tag_link ) . '" title="' . esc_attr( strip_tags( $tag->name ) ) . '">' . esc_attr( $tag->name ) . '</a>';
				}
				$str .= '</div>';

				return $str;
			} else {
				return false;
			}
		}


		/**
		 * @return string
		 * render related posts
		 */
		static function render_related() {

			//check enable related box
			$related = tn_util::get_theme_option( 'single_related_box' );
			if ( empty( $related ) ) {
				return false;
			}

			//query related
			$related_where   = tn_util::get_theme_option( 'single_related_where' );
			$categories_data = get_the_category();
			$tags_data       = get_the_tags();
			$category_ids    = '';
			$tags            = '';
			$options         = array();
			$query_data      = '';

			//get string category id
			foreach ( $categories_data as $category ) {
				$category_ids .= $category->term_id . ',';
			}

			$category_ids = substr( $category_ids, 0, - 1 );

			//get string tags
			if ( ! empty( $tags_data ) ) {
				foreach ( $tags_data as $tag ) {
					$tags .= $tag->slug . ',';
				}
				$tags = substr( $tags, 0, - 1 );
			} else {

				//set same category if tags not found
				$related_where = 'categories';
			}

			//get number of related
			$options['posts_per_page'] = 3;
			$options['post__not_in']   = get_the_ID();

			switch ( $related_where ) {

				//case all
				case 'all' : {
					$options['tags'] = $tags;
					$query_data      = tn_query::get_custom_query( $options )->posts;

					//check not enough post by tags
					$count = count( $query_data );

					if ( $count < $options['posts_per_page'] ) {

						//reset query options
						foreach ( $query_data as $post_related ) {
							$options['post__not_in'] .= ',' . $post_related->ID;
						}
						$options['category_ids'] = $category_ids;
						unset( $options['tags'] );
						$options['posts_per_page'] = $options['posts_per_page'] - $count;
						$query_data_more           = tn_query::get_custom_query( $options )->posts;

						//add categories related to tags related
						if ( ! empty( $query_data_more ) ) {
							foreach ( $query_data_more as $data ) {
								$query_data[] = $data;
							}
						}
					};

					break;
				}

				case 'tags' : {
					$options['tags'] = $tags;
					$query_data      = tn_query::get_custom_query( $options )->posts;
					break;
				}

				case 'categories' : {
					$options['category_ids'] = $category_ids;
					$query_data              = tn_query::get_custom_query( $options )->posts;
					break;
				}

			};

			//render related posts
			$str = '';
			if ( ! empty( $query_data ) ) {
				$str .= '<div class="related-wrap single-el clearfix">';
				$str .= '<div class="related-heading"><h3>' . esc_html__( 'you might also like', 'tn' ) . '</h3></div><!-- title bar -->';
				$str .= '<div class="related-content-wrap row">';
				foreach ( $query_data as $post_data ) {

					$str .= '<div class="related-el col-sm-4 col-xs-12">';
					$str .= tn_util::render_thumb( $post_data->ID, 'tn_medium_grid_overlay' );
					$str .= tn_util::render_title( $post_data->ID, 'mini' );
					$str .= '<div class="meta-tags-wrap post-el">';
					$str .= tn_util::render_date( $post_data->ID );
					$str .= '</div><!--#tags wrap -->';

					$str .= '</div><!--#related el-->';

				}
				$str .= '</div><!--# relate content -->';
				$str .= '</div><!--# related wrap -->';
			}

			return $str;
		}


		/**
		 * @param bool $footer
		 * @return bool|string
		 * render single share
		 */
		static function render_single_shares( $footer = false ) {
			//check & return
			$share_bar = tn_util::get_theme_option( 'single_share_social' );
			if ( empty( $share_bar ) ) {
				return false;
			}

			$str = '';
			if ( ! $footer ) {
				$str .= '<div class="single-social-wrap">';
			} else {
				$str .= '<div class="single-footer-social-wrap">';
			}
			$str .= tn_util::render_share_post( get_the_ID() );
			$str .= '</div><!--#single share box-->';

			return $str;
		}

		/**
		 * @return string
		 * render single wrap div tag
		 */
		static function open_wrap() {
			$str        = '';
			$main_class = array();

			//sidebar position
			$sidebar_position = get_post_meta( get_the_ID(), 'tn_single_sidebar_position', true );

			if ( is_sticky() ) {
				$sidebar_position = 'none';
			}

			if ( 'default' == $sidebar_position || empty( $sidebar_position ) ) {
				$sidebar_position = tn_util::get_theme_option( 'single_default_sidebar_position' );
				if ( 'default' == $sidebar_position ) {
					$sidebar_position = tn_util::get_theme_option( 'site_sidebar_position' );
				}
			};

			//check sidebar
			if ( 'none' != $sidebar_position ) {
				$main_class[] = 'is-sidebar';
				if ( 'left' == $sidebar_position ) {
					$main_class[] = 'left-sidebar';
				} else {
					$main_class[] = 'right-sidebar';
				}
			} else {
				$main_class[] = 'no-sidebar';
			}

			$main_class[] = 'tn-container';

			$main_class = implode( ' ', $main_class );

			$str .= '<div id="main-content-wrap" class="row clearfix ' . $main_class . '">';

			if ( 'none' != $sidebar_position ) {
				$str .= '<div id="main" class="col-md-8 col-sm-12">';
			} else {
				$str .= '<div id="main" class="col-xs-12">';
			}

			return $str;

		}


		/**
		 * @return string
		 * render sidebar for single post
		 */
		static function render_sidebar() {
			//sidebar position
			$sidebar_position = get_post_meta( get_the_ID(), 'tn_single_sidebar_position', true );

			if ( is_sticky() ) {
				$sidebar_position = 'none';
			}

			if ( 'default' == $sidebar_position || empty( $sidebar_position ) ) {
				$sidebar_position = tn_util::get_theme_option( 'single_default_sidebar_position' );
				if ( 'default' == $sidebar_position ) {
					$sidebar_position = tn_util::get_theme_option( 'site_sidebar_position' );
				}
			}

			//render sidebar
			if ( ! empty( $sidebar_position ) && 'none' != $sidebar_position ) {

				//single sidebar name
				$sidebar_name = get_post_meta( get_the_ID(), 'tn_single_custom_sidebar', true );
				if ( 'tn_default_from_theme_options' == $sidebar_name || empty( $sidebar_name ) ) {
					$sidebar_name = tn_util::get_theme_option( 'single_default_sidebar' );
				}

				return tn_template_parts::render_sidebar( $sidebar_name );

			} else {
				return false;
			}
		}


		/**-------------------------------------------------------------------------------------------------------------------------
		 * render single schema makeup
		 */
		static function single_schema_makeup() {
			if ( ! is_single() ) {
				return false;
			};

			$tn_http = 'http';
			if ( is_ssl() ) {
				$tn_http = 'https';
			}

			$tn_publisher = get_bloginfo( 'name' );
			if ( ! empty( $tn_publisher ) ) {
				$tn_publisher = get_the_author_meta( 'display_name' );
			}

			//publisher logo
			$tn_logo = tn_util::get_theme_option( 'logo' );

			if ( ! empty( $tn_logo['url'] ) ) {
				$tn_publisher_logo = esc_url( $tn_logo['url'] );
			}

			$tn_post_date   = get_the_time( 'U' );
			$tn_post_update = get_the_modified_time( 'U' );

			$tn_full_image_attachment = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

			$str = '';
			$str .= '<meta itemscope itemprop="mainEntityOfPage"  itemType="' . $tn_http . '://schema.org/WebPage" itemid="' . get_permalink() . '"/>';

			//headline
			$str .= '<meta itemprop="headline " content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';

			//author
			$str .= '<span style="display: none;" itemprop="author" itemscope itemtype="' . $tn_http . '://schema.org/Person">';
			$str .= '<meta itemprop="name" content="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '">';
			$str .= '</span>';

			//image
			$str .= '<span style="display: none;" itemprop="image" itemscope itemtype="' . $tn_http . '://schema.org/ImageObject">';
			$str .= '<meta itemprop="url" content="' . $tn_full_image_attachment[0] . '">';
			$str .= '<meta itemprop="width" content="' . $tn_full_image_attachment[1] . '">';
			$str .= '<meta itemprop="height" content="' . $tn_full_image_attachment[2] . '">';
			$str .= '</span>';

			//publisher
			$str .= '<span style="display: none;" itemprop="publisher" itemscope itemtype="' . $tn_http . '://schema.org/Organization">';
			$str .= '<span style="display: none;" itemprop="logo" itemscope itemtype="' . $tn_http . '://schema.org/ImageObject">';
			if ( ! empty( $tn_publisher_logo ) ) {
				$str .= '<meta itemprop="url" content="' . $tn_publisher_logo . '">';
			}
			$str .= '</span>';
			$str .= '<meta itemprop="name" content="' . $tn_publisher . '">';
			$str .= '</span>';

			$str .= '<meta itemprop="datePublished" content="' . date( DATE_W3C, $tn_post_date ) . '"/>';
			$str .= '<meta itemprop="dateModified" content="' . date( DATE_W3C, $tn_post_update ) . '"/>';


			return $str;

		}

	}
}