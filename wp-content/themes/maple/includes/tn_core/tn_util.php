<?php

/**
 * Class tn_util
 * this is class render elements and function for frontend

 */
if ( ! class_exists( 'tn_util' ) ) {
	class tn_util {

		/**
		 * @param $option_name
		 *
		 * @return string
		 * load value from theme options
		 */
		static function get_theme_option( $option_name ) {
			$tn_theme_options = $GLOBALS['tn_theme_options'];

			//check empty value
			if ( empty( $tn_theme_options[ $option_name ] ) ) {
				return false;
			}

			//return option valuer
			return $tn_theme_options[ $option_name ];
		}


		/**
		 * @param string $flickr_id
		 * @param int $num_images
		 * @param string $tags
		 *
		 * @return array|mixed
		 * load flickr data from flickr
		 */
		static function get_flickr_data( $flickr_id, $num_images = 9, $tags = '' ) {
			if ( empty( $flickr_id ) ) {
				return array();
			};
			$response = wp_remote_get( 'http://api.flickr.com/services/feeds/photos_public.gne?format=json&id=' . urlencode( $flickr_id ) . '&nojsoncallback=1&tags=' . urlencode( $tags ), array( 'timeout' => 100 ) );
			if ( is_wp_error( $response ) || '200' != $response['response']['code'] ) {
				return array();
			}
			$response = wp_remote_retrieve_body( $response );
			$response = str_replace( "\\'", "'", $response );
			$content  = json_decode( $response, true );
			if ( is_array( $content ) ) {
				$content = array_slice( $content['items'], 0, $num_images );
				foreach ( $content as $i => $v ) {
					$content[ $i ]['media'] = preg_replace( '/_m\.(jp?g|png|gif)$/', '_s.\\1', $v['media']['m'] );
				}

				return $content;
			} else {
				return array();
			}
		}

		/**
		 * @param $context
		 *
		 * @return bool|string
		 * schema makeup, good for search engine
		 */
		static function tn_schema_makeup( $context ) {

			$str  = '';
			$data = array();

			$tn_http = 'http';

			if ( is_ssl() ) {
				$tn_http = 'https';
			}

			switch ( $context ) {
				case 'body' :
					$data['itemscope'] = true;
					$data['itemtype']  = $tn_http . '://schema.org/WebPage';
					break;

				case 'article' :
					$data['itemscope'] = true;
					$data['itemtype']  = $tn_http . '://schema.org/NewsArticle';
					break;

				case 'menu':
					$data['role']      = 'navigation';
					$data['itemscope'] = true;
					$data['itemtype']  = $tn_http . '://schema.org/SiteNavigationElement';
					break;

				case 'header':
					$data['role']      = 'banner';
					$data['itemscope'] = true;
					$data['itemtype']  = $tn_http . '://schema.org/WPHeader';
					break;

				case 'sidebar':
					$data['role']      = 'complementary';
					$data['itemscope'] = true;
					$data['itemtype']  = $tn_http . '://schema.org/WPSideBar';
					break;

				case 'footer':
					$data['itemscope'] = true;
					$data['role']      = 'contentinfo';
					$data['itemtype']  = $tn_http . '://schema.org/WPFooter';
					break;

				case 'logo' :
					$data['itemscope'] = true;
					$data['itemtype']  = $tn_http . '://schema.org/Organization';
					break;
			};

			if ( empty( $data ) ) {
				return false;
			}

			foreach ( $data as $k => $v ) {
				if ( true === $v ) {
					$str .= ' ' . $k . ' ';
				} else {
					$str .= ' ' . $k . '="' . $v . '" ';
				}
			}

			return $str;
		}


		/**
		 * @param $id
		 * @param $name
		 *
		 * @return string
		 * render thumbnail as html
		 */
		static function render_thumb( $id, $name ) {
			$str = '';
			$str .= '<div class="thumb-wrap post-el">';
			if ( has_post_thumbnail( $id ) ) {
				$tn_thumbnail = get_the_post_thumbnail( $id, $name );
				if ( ! empty( $tn_thumbnail ) ) {
					$str .= '<a href="' . get_permalink( $id ) . '" title="' . esc_attr( strip_tags( get_the_title( $id ) ) ) . '" rel="bookmark">';
					$str .= $tn_thumbnail;
					$str .= '</a>';
				} else {
					$str .= '<div class="no-thumb"><i class="fa fa-camera"></i></div>';
				}
			} else {
				$str .= '<div class="no-thumb"><i class="fa fa-camera"></i></div>';
			}

			$str .= '</div><!--#thumb wrap-->';

			return $str;
		}


		/**
		 * @param        $id
		 * @param string $size
		 *
		 * @return string
		 * rnder post title
		 */
		static function render_title( $id, $size = 'medium' ) {
			$str = '';
			$str .= '<h3 class="post-title post-el ' . $size . '">';
			$str .= '<a href="' . get_permalink( $id ) . '" rel="bookmark" title="' . esc_attr( strip_tags( get_the_title( $id ) ) ) . '">';
			$str .= get_the_title( $id );
			$str .= '</a></h3><!--#module title -->';

			return $str;
		}

		/**
		 * @param        $id
		 * @param string $size
		 *
		 * @return string
		 * render read more button
		 */
		static function render_readmore( $id, $size = '' ) {

			$read_more_text = tn_util::get_theme_option( 'site_readmore_text' );
			$read_class     = $size;
			if ( empty( $read_more_text ) ) {
				$read_more_text = esc_html__( 'read more', 'tn' );
			}

			$str = '';
			$str .= '<div class="read-more-wrap post-el ' . $read_class . '">';
			$str .= '<a href="' . get_permalink( $id ) . '" rel="bookmark" title="' . esc_attr( strip_tags( get_the_title( $id ) ) ) . '">';
			$str .= esc_attr( $read_more_text );
			$str .= '</a></div><!--#read more button -->';

			return $str;

		}

		/**
		 * @param      $post
		 * @param int $num_of_excerpt
		 * @param bool $display_short_code
		 *
		 * @return string
		 * render excerpt as html
		 */
		static function render_excerpt( $post, $num_of_excerpt = 25, $display_short_code = false ) {
			//check & return
			if ( empty( $num_of_excerpt ) ) {
				return false;
			}

			if ( ! empty( $post->post_excerpt ) ) {
				return '<div class="excerpt post-el"><p>' . html_entity_decode( esc_html( $post->post_excerpt ) ) . '</p></div><!--#entry-->';

			} else {
				$post_content = $post->post_content;

				if ( ! $display_short_code ) {
					$post_content = preg_replace( '`\[[^\]]*\]`', '', $post->post_content );
				}
				$post_content = stripslashes( wp_filter_nohtml_kses( $post_content ) );

				return '<div class="excerpt post-el"><p>' . wp_trim_words( $post_content, $num_of_excerpt, '' ) . '</p></div><!--#entry-->';
			}
		}


		/**
		 * @param        $id
		 * @param string $only_one
		 *
		 * @return string
		 * render category tags as html
		 */
		static function render_category_name( $id, $only_one = '' ) {
			$str       = '';
			$hide_cate = tn_util::get_theme_option( 'hide_category_bar' );
			if ( ! empty( $hide_cate ) ) {
				return false;
			}
			$categories = get_the_category( $id );
			if ( $categories ) {
				$str .= '<div class="category-name-wrap post-el">';
				$str .= '<span class="bullet first-bullet"></span>';
				foreach ( $categories as $category ) {
					$str .= '<a class="cate-name" href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( strip_tags( $category->name ) ) . '">' . esc_attr( $category->cat_name ) . '</a>';
					if ( ! empty( $only_one ) ) {
						break;
					}
				}
				$str .= '<span class="bullet last-bullet"></span>';
				$str .= '</div><!--category name-->';
			}

			return $str;
		}


		/**
		 * @param $id
		 * @param string
		 *
		 * @return string
		 * render date tags
		 */
		static function render_date( $id ) {
			$str       = '';
			$date_unix = get_the_time( 'U', $id );
			$str .= '<span  class="date-tags tags-el">';
			$str .= '<time datetime="' . date( DATE_W3C, $date_unix ) . '" >' . get_the_date( '', $id ) . '</time>';
			$str .= '</span><!--#date tag-->';

			return $str;
		}


		/**
		 * @param $id
		 * @param string
		 *
		 * @return string
		 * render comment count
		 */
		static function render_comment_count( $id ) {
			if ( ! comments_open( $id ) || 0 == ( $count_comment = get_comments_number( $id ) ) ) {
				return false;
			}
			$str = '';
			$str .= '<span  class="comment-tags tags-el">';
			$str .= '<a href="' . get_comments_link( $id ) . '" >';

			if ( 1 == $count_comment ) {
				$str .= esc_html__( '1 comment', 'tn' );
			} else {
				$str .= $count_comment . ' ' . esc_html__( 'comments', 'tn' );
			}
			$str .= '</a></span><!--#comment tag -->';

			return $str;
		}


		/**
		 * @param $post
		 * @param string
		 *
		 * @return string
		 * render author tags
		 */
		static function render_author( $post ) {
			$str = '';
			$str .= '<span class="author-tags tags-el">';
			$str .= '<a href="' . get_author_posts_url( $post->post_author ) . '">';
			$str .= get_the_author_meta( 'display_name', $post->post_author );
			$str .= '</a>';
			$str .= '</span><!--#author tag-->';

			return $str;
		}


		/**
		 * @param $id
		 * @param string
		 *
		 * @return string
		 * render tag tags
		 */
		static function render_tag( $id ) {
			$str  = '';
			$tags = get_the_tags( $id );
			if ( ! empty( $tags ) ) {
				$str .= '<span class="tag-tags tags-el">';
				foreach ( $tags as $tag ) {
					$tag_link = get_tag_link( $tag->term_id );
					$str .= '<a href="' . $tag_link . '" title="' . esc_attr( strip_tags( $tag->name ) ) . '">' . esc_attr( $tag->name ) . '</a>';
				}
				$str .= '</span><!--#tags tag-->';
			}

			return $str;
		}


		/**
		 * @param $id
		 * @param string
		 *
		 * @return bool|string
		 * render view tag
		 */
		static function render_view( $id ) {
			$count_views = tn_post_support::get_single_views( $id );
			if ( ! empty( $count_views ) ) {
				$str = '';
				$str .= '<span class="view-tags tags-el">';
				if ( 1 == $count_views ) {
					$str .= '<a href="' . get_permalink( $id ) . '" title="' . strip_tags( get_the_title( $id ) ) . '">';
					$str .= '<span>' . intval( $count_views ) . ' ' . esc_html__( 'view', 'tn' ) . '</span></a>';
				} else {
					$str .= '<a href="' . get_permalink( $id ) . '" title="' . strip_tags( get_the_title( $id ) ) . '">';
					$str .= '<span>' . intval( $count_views ) . ' ' . esc_html__( 'views', 'tn' ) . '</span></a>';
				}

				$str .= '</span><!--#view tag-->';

				return $str;
			} else {
				return false;
			}
		}


		/**
		 * @param $id
		 *
		 * @return string
		 * render share post
		 */
		static function render_share_post( $id ) {

			$twitter_user = get_the_author_meta( 'twitter' );
			$image        = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'big_grid' );

			$str = '';
			$str .= '<div class="post-share-bar">';
			if ( 1 == tn_util::get_theme_option( 'share_to_facebook' ) ) {
				$str .= '<a class="share-to-social" href="http://www.facebook.com/sharer.php?u=' . urlencode( get_permalink( $id ) ) . '" onclick="window.open(this.href, \'mywin\',
\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-facebook color-facebook"></i></a>';
			}
			if ( 1 == tn_util::get_theme_option( 'share_to_twitter' ) ) {
				$str .= '<a class="share-to-social" href="https://twitter.com/intent/tweet?text=' . urlencode( strip_tags( get_the_title( $id ) ) ) . '&amp;url=' . urlencode( get_permalink( $id ) ) . '&amp;via=' . urlencode( $twitter_user ? $twitter_user : get_bloginfo( 'name' ) ) . '" onclick="window.open(this.href, \'mywin\',
\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-twitter color-twitter"></i></a>';
			}
			if ( 1 == tn_util::get_theme_option( 'share_to_google_plus' ) ) {
				$str .= ' <a class="share-to-social" href="http://plus.google.com/share?url=' . urlencode( get_permalink( $id ) ) . '" onclick="window.open(this.href, \'mywin\',
\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-google-plus color-google"></i></a>';
			}
			if ( 1 == tn_util::get_theme_option( 'share_to_pinterest' ) ) {
				$str .= '<a class="share-to-social" href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink( $id ) ) . '&amp;media=' . ( ! empty( $image[0] ) ? $image[0] : '' ) . '" onclick="window.open(this.href, \'mywin\',
\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-pinterest color-pinterest"></i></a>';
			}
			if ( 1 == tn_util::get_theme_option( 'share_to_tumblr' ) ) {
				$str .= ' <a class="share-to-social" href="http://www.tumblr.com/share/link?url=' . urlencode( get_permalink( $id ) ) . '&amp;name=' . urlencode( strip_tags( get_the_title( $id ) ) ) . '&amp;description=' . urlencode( strip_tags( get_the_title( $id ) ) ) . '" onclick="window.open(this.href, \'mywin\',
\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-tumblr color-tumblr"></i></a>';
			}
			if ( 1 == tn_util::get_theme_option( 'share_to_linkedin' ) ) {
				$str .= '  <a class="share-to-social" href="http://linkedin.com/shareArticle?mini=true&amp;url=' . urlencode( get_permalink( $id ) ) . '&amp;title=' . urlencode( strip_tags( get_the_title( $id ) ) ) . '" onclick="window.open(this.href, \'mywin\',
\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-linkedin color-linkedin"></i></a>';
			}
			if ( 1 == tn_util::get_theme_option( 'share_to_digg' ) ) {
				$str .= '<a class="share-to-social" href="http://digg.com/submit?phase=2&amp;url=' . urlencode( get_permalink( $id ) ) . '&amp;bodytext=&amp;tags=&amp;title=' . urlencode( strip_tags( get_the_title( $id ) ) ) . '" target="_blank" title="' . esc_attr__( 'Share on Digg', 'tn' ) . '" onclick="window.open(this.href, \'mywin\',
\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-digg color-digg"></i></a>';
			}

			$str .= '</div>';

			return $str;
		}


		/**
		 * @return string
		 * render page pagination as html
		 */
		static function render_pagination() {
			global $wp_query, $wp_rewrite;
			if ( is_singular() || ( $wp_query->max_num_pages < 2 ) ) {
				return false;
			}
			$str = '';

			//render pagination
			$str .= '<div class="pagination-wrap clearfix">';
			$str .= '<div class="pagination-num pagination-el">';
			$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
			$pagination = array(
				'base'      => @add_query_arg( 'paged', '%#%' ),
				'format'    => '',
				'total'     => $wp_query->max_num_pages,
				'current'   => $current,
				'prev_text' => '<i class="fa fa-angle-double-left"></i>',
				'next_text' => '<i class="fa fa-angle-double-right"></i>',
				'type'      => 'plain'
			);
			if ( $wp_rewrite->using_permalinks() ) {
				$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
			}
			if ( ! empty( $wp_query->query_vars['s'] ) ) {
				$pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
			}
			$str .= paginate_links( $pagination );
			$str .= '</div><!--#pagination number-->';
			$str .= '<div class="pagination-text pagination-el"><span>' . esc_html__( 'Page', 'tn' ) . ' ' . $pagination['current'] . esc_html__( ' of ', 'tn' ) . $pagination['total'] . '</span></div><!--#pagination text-->';
			$str .= '</div><!--#pagination-wrap-->';

			return $str;
		}


		/**
		 * @param      $social_data
		 * @param bool $new_tab
		 *
		 * @return string
		 * render social bar
		 */
		static function render_social_bar( $social_data, $new_tab = true ) {
			//check empty
			if ( empty( $social_data ) ) {
				return false;
			}

			if ( $new_tab == true ) {
				$newtab = 'target="_blank"';
			} else {
				$newtab = '';
			}

			extract( shortcode_atts(
					array(
						'url'         => '',
						'facebook'    => '',
						'twitter'     => '',
						'googleplus' => '',
						'pinterest'   => '',
						'linkedin'    => '',
						'tumblr'      => '',
						'flickr'      => '',
						'instagram'   => '',
						'skype'       => '',
						'myspace'     => '',
						'youtube'     => '',
						'rss'         => '',
						'bloglovin'   => '',
						'digg'        => '',
						'dribbble'    => '',
						'soundcloud'  => '',
						'vimeo'       => '',
						'vkontakte'   => '',

					), $social_data
				)
			);

			$str   = '';
			$check = '';

			if ( ! empty( $url ) ) {
				$check .= '<a title="website" href="' . esc_url( $url ) . '" ' . $newtab . '><i class="fa fa-link"></i></a>';
			}
			if ( ! empty( $facebook ) ) {
				$check .= '<a title="Facebook" href="' . esc_url( $facebook ) . '" ' . $newtab . '><i class="fa fa-facebook"></i></a>';
			}
			if ( ! empty( $twitter ) ) {
				$check .= '<a title="Twitter" href="' . esc_url( $twitter ) . '" ' . $newtab . '><i class="fa fa-twitter"></i></a>';
			}
			if ( ! empty( $googleplus ) ) {
				$check .= '<a title="Google+" href="' . esc_url( $googleplus ) . '" ' . $newtab . '><i class="fa fa-google-plus"></i></a>';
			}
			if ( ! empty( $pinterest ) ) {
				$check .= '<a title="Pinterest" href="' . esc_url( $pinterest ) . '" ' . $newtab . '><i class="fa fa-pinterest"></i></a>';
			}
			if ( ! empty( $linkedin ) ) {
				$check .= '<a title="LinkedIn" href="' . esc_url( $linkedin ) . '" ' . $newtab . '><i class="fa fa-linkedin"></i></a>';
			}
			if ( ! empty( $tumblr ) ) {
				$check .= '<a title="Tumblr" href="' . esc_url( $tumblr ) . '" ' . $newtab . '><i class="fa fa-tumblr"></i></a>';
			}
			if ( ! empty( $flickr ) ) {
				$check .= '<a title="Flickr" href="' . esc_url( $flickr ) . '" ' . $newtab . '><i class="fa fa-flickr"></i></a>';
			}
			if ( ! empty( $instagram ) ) {
				$check .= '<a title="Instagram" href="' . esc_url( $instagram ) . '" ' . $newtab . '><i class="fa fa-instagram"></i></a>';
			}
			if ( ! empty( $skype ) ) {
				$check .= '<a title="Skype" href="' . esc_url( $skype ) . '" ' . $newtab . '><i class="fa fa-skype"></i></a>';
			}
			if ( ! empty( $myspace ) ) {
				$check .= '<a title="myspace" href="' . esc_url( $myspace ) . '" ' . $newtab . '><i class="fa fa-users"></i></a>';
			}
			if ( ! empty( $youtube ) ) {
				$check .= '<a title="Youtube" href="' . esc_url( $youtube ) . '" ' . $newtab . '><i class="fa fa-youtube"></i></a>';
			}
			if ( ! empty( $rss ) ) {
				$check .= '<a title="Rss" href="' . esc_url( $rss ) . '" ' . $newtab . '><i class="fa fa-rss"></i></a>';
			}
			if ( ! empty( $bloglovin ) ) {
				$check .= '<a title="Bloglovin" href="' . esc_url( $bloglovin ) . '" ' . $newtab . '><i class="fa fa-heart"></i></a>';
			}
			if ( ! empty( $digg ) ) {
				$check .= '<a title="digg" href="' . esc_url( $digg ) . '" ' . $newtab . '><i class="fa fa-digg"></i></a>';
			}
			if ( ! empty( $dribbble ) ) {
				$check .= '<a title="dribbble" href="' . esc_url( $dribbble ) . '" ' . $newtab . '><i class="fa fa-dribbble"></i></a>';
			}
			if ( ! empty( $soundcloud ) ) {
				$check .= '<a title="soundcloud" href="' . esc_url( $soundcloud ) . '" ' . $newtab . '><i class="fa fa-soundcloud"></i></a>';
			}
			if ( ! empty( $vimeo ) ) {
				$check .= '<a title="Vimeo" href="' . esc_url( $vimeo ) . '" ' . $newtab . '><i class="fa fa-vimeo-square"></i></a>';
			}
			if ( ! empty( $vkontakte ) ) {
				$check .= '<a title="vkontakte" href="' . esc_url( $vkontakte ) . '" ' . $newtab . '><i class="fa fa-vk"></i></a>';
			}


			if ( ! empty( $check ) ) {
				$str .= '<div class="social-bar-wrap clearfix">';
				$str .= $check;
				$str .= '</div><!--#social icon -->';
			}

			return $str;
		}


		/**
		 * @param $author_id
		 *
		 * @return string
		 * render social by author id
		 */
		static function render_author_social( $author_id ) {
			$str                        = '';
			$social_data                = array();
			$social_data['url']         = get_the_author_meta( 'url', $author_id );
			$social_data['facebook']    = get_the_author_meta( 'facebook', $author_id );
			$social_data['twitter']     = get_the_author_meta( 'twitter', $author_id );
			$social_data['googleplus'] = get_the_author_meta( 'googleplus', $author_id );
			$social_data['pinterest']   = get_the_author_meta( 'pinterest', $author_id );
			$social_data['linkedin']    = get_the_author_meta( 'linkedin', $author_id );
			$social_data['tumblr']      = get_the_author_meta( 'tumblr', $author_id );
			$social_data['flickr']      = get_the_author_meta( 'flickr', $author_id );
			$social_data['instagram']   = get_the_author_meta( 'instagram', $author_id );
			$social_data['skype']       = get_the_author_meta( 'skype', $author_id );
			$social_data['myspace']     = get_the_author_meta( 'myspace', $author_id );
			$social_data['youtube']     = get_the_author_meta( 'youtube', $author_id );
			$social_data['rss']         = get_the_author_meta( 'rss', $author_id );
			$social_data['digg']        = get_the_author_meta( 'digg', $author_id );
			$social_data['dribbble']    = get_the_author_meta( 'dribbble', $author_id );
			$social_data['soundcloud']  = get_the_author_meta( 'soundcloud', $author_id );
			$social_data['vimeo']       = get_the_author_meta( 'vimeo', $author_id );

			return self::render_social_bar( $social_data );
		}


		/**
		 * @return array
		 * get web social data
		 */
		static function get_web_social() {
			$social_data = array();

			if ( 1 == self::get_theme_option( 'site_social' ) ) {
				$social_data['facebook']    = self::get_theme_option( 'tn_facebook' );
				$social_data['twitter']     = self::get_theme_option( 'tn_twitter' );
				$social_data['googleplus'] = self::get_theme_option( 'tn_google_plus' );
				$social_data['pinterest']   = self::get_theme_option( 'tn_pinterest' );
				$social_data['bloglovin']   = self::get_theme_option( 'tn_bloglovin' );
				$social_data['instagram']   = self::get_theme_option( 'tn_instagram' );
				$social_data['youtube']     = self::get_theme_option( 'tn_youtube' );
				$social_data['vimeo']       = self::get_theme_option( 'tn_vimeo' );
				$social_data['flickr']      = self::get_theme_option( 'tn_flickr' );
				$social_data['linkedin']    = self::get_theme_option( 'tn_linkedin' );
				$social_data['tumblr']      = self::get_theme_option( 'tn_tumblr' );
				$social_data['vkontakte']   = self::get_theme_option( 'tn_vkontakte' );
				$social_data['skype']       = self::get_theme_option( 'tn_skype' );
				$social_data['rss']         = self::get_theme_option( 'tn_rss' );
			}

			return $social_data;
		}

		/**
		 * @param bool $new_tab
		 *
		 * @return string
		 * render web social
		 */
		static function render_web_social( $new_tab = true ) {
			$social_data = self::get_web_social();

			return self::render_social_bar( $social_data, $new_tab );
		}


		/**
		 * @param $post_id
		 *
		 * @return string
		 * render post format
		 */
		static function render_post_format( $post_id ) {
			$str    = '';
			$format = get_post_format( $post_id );

			$str .= '<div class="post-format-wrap">';

			switch ( $format ) {
				case false :
					$str .= '<span class="post-format"><i class="fa fa-file-text"></i></span>';
					break;
				case 'video' :
					$str .= '<span class="post-format post-video"><i class="fa fa-play-circle-o"></i></span>';
					break;
				case  'image' :
					$str .= '<span class="post-format"><i class="fa fa-picture-o"></i></span>';
					break;
				case  'gallery' :
					$str .= '<span class="post-format"><i class="fa fa-camera"></i></span>';
					break;
				case 'quote' :
					$str .= '<span class="post-format"><i class="fa fa-quote-left"></i></span>';
					break;
				case 'aside' :
					$str .= '<span class="post-format"><i class="fa fa-file-text-o"></i></span>';
					break;
				case 'audio' :
					$str .= '<span class="post-format post-audio"><i class="fa fa-music"></i></span>';
					break;
				case 'link' :
					$str .= '<span class="post-format"><i class="fa fa-link"></i></span>';
					break;
			};

			$str .= '</div><!--#post format-->';

			return $str;
		}

	}
}
