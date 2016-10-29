<?php
/**
 * Class tn_post_support
 * This file handling gallery, video and audio for post

 */
if ( ! class_exists( 'tn_post_support' ) ) {
	class tn_post_support {

		/**
		 * @param $id
		 * @return string
		 * check and render thumbnails
		 */
		static function thumb_type( $id ) {
			switch ( get_post_format( $id ) ) {
				case 'audio' :
					return self::render_audio( $id );
				case 'video' :
					return self::render_video( $id );
				default :
					return tn_util::render_thumb( $id, 'classic' );
			}
		}


		/**
		 * @param $id
		 * @return string
		 * render audio iframe
		 */
		static function render_audio( $id ) {
			$str = '';

			//check audio link
			$audio_url = get_post_meta( $id, 'tn_single_custom_audio', true );
			if ( get_post_format( $id ) != 'audio' || empty( $audio_url ) ) {
				return false;
			}
			$audio_emb = wp_oembed_get( $audio_url, array( 'height' => 230, 'width' => 900 ) );

			//render
			$str .= '<div class="thumb-wrap post-el audio">';
			$str .= $audio_emb;
			$str .= '</div><!--#thumb & audio iframe -->';

			return $str;
		}


		/**
		 * @param $id
		 * @return string
		 * render video iframe
		 */
		static function render_video( $id ) {
			$str = '';

			$video_url = get_post_meta( $id, 'tn_single_custom_video', true );
			if ( get_post_format( $id ) != 'video' || empty( $video_url ) ) {
				return false;
			}
			$server = self::detect_video_url( $video_url );

			$str .= '<div class="thumb-wrap post-el video">';
			switch ( $server ) {
				case 'youtube':
					$str .= '<iframe id="tnYoutbePlayer" width="900" height="505" src="http://www.youtube.com/embed/' . self::youtube_id( $video_url ) . '?feature=oembed&amp;wmode=opaque' . esc_attr( self::youtube_time( $video_url ) ) . '" allowfullscreen></iframe>';
					break;
				case 'vimeo':
					$str .= '<iframe  width="900" height="205" src="http://player.vimeo.com/video/' . self::vimeo_id( $video_url ) . '"></iframe>';
					break;
				case 'dailymotion':
					$str .= '<iframe width="900" height="505" src="http://www.dailymotion.com/embed/video/' . self::dailymotion_id( $video_url ) . '"></iframe>';
					break;
			}

			$str .= '</div><!--# video iframe -->';

			return $str;
		}

		/**
		 * @param $video_url
		 * @return bool|string
		 * get url of video
		 */
		static function detect_video_url( $video_url ) {
			$video_url = strtolower( $video_url );

			if ( strpos( $video_url, 'youtube.com' ) !== false or strpos( $video_url, 'youtu.be' ) !== false ) {
				return 'youtube';
			}
			if ( strpos( $video_url, 'dailymotion.com' ) !== false ) {
				return 'dailymotion';
			}
			if ( strpos( $video_url, 'vimeo.com' ) !== false ) {
				return 'vimeo';
			}

			return false;
		}


		/**
		 * @param $video_url
		 * @return mixed
		 * get youtube id
		 */
		static function youtube_id( $video_url ) {
			$s = array();
			parse_str( parse_url( $video_url, PHP_URL_QUERY ), $s );

			if ( empty( $s["v"] ) ) {
				$youtube_sl_explode = explode( '?', $video_url );

				$youtube_sl = explode( '/', $youtube_sl_explode[0] );
				if ( ! empty( $youtube_sl[3] ) ) {
					return $youtube_sl [3];
				}

				return $youtube_sl [0];
			} else {
				return $s["v"];
			}
		}


		/**
		 * @param $video_url
		 * @return string
		 * youtube time
		 */
		static function youtube_time( $video_url ) {
			$s = array();
			parse_str( parse_url( $video_url, PHP_URL_QUERY ), $s );
			if ( ! empty( $s["t"] ) ) {
				if ( strpos( $s["t"], 'm' ) ) {
					$explode_m   = explode( 'm', $s["t"] );
					$min         = trim( $explode_m[0] );
					$explode_sec = explode( 's', $explode_m[1] );
					$sec         = trim( $explode_sec[0] );

					$start_time = ( intval( $min ) * 60 ) + intval( $sec );
				} else {
					$explode_s = explode( 's', $s["t"] );
					$sec       = trim( $explode_s[0] );

					$start_time = $sec;
				}

				return '&start=' . $start_time;
			} else {
				return '';
			}
		}


		/**
		 * @param $video_url
		 * @return mixed
		 * get vimeo id
		 */
		static function vimeo_id( $video_url ) {
			sscanf( parse_url( $video_url, PHP_URL_PATH ), '/%d', $vimeo_id );

			return $vimeo_id;
		}


		/**
		 * @param $video_url
		 * @return string
		 * get dailymotion id
		 */
		static function dailymotion_id( $video_url ) {
			$id = strtok( basename( $video_url ), '_' );
			if ( strpos( $id, '#video=' ) !== false ) {
				$video_parts = explode( '#video=', $id );
				if ( ! empty( $video_parts[1] ) ) {
					return $video_parts[1];
				}
			};

			return $id;
		}


		/**
		 * @param $id
		 * @return string
		 * render classic gallery post
		 */
		static function render_gallery( $id ) {

			//check & return
			$gallery      = get_post_meta( $id, 'tn_single_custom_gallery', true );
			$gallery_type = get_post_meta( $id, 'tn_single_custom_gallery_type', true );

			if ( empty( $gallery ) ) {
				return false;
			}

			$str = '';
			//slider type
			if ( 'slider' == $gallery_type ) {
				$size = 'tn_classic_slider';
				//render slider
				$str .= '<div class="thumb-wrap post-el post-gallery is-slider">';
				$str .= '<div class="slider-loading"></div>';
				$str .= '<div class="gallery-slider slider-init">';
				foreach ( $gallery as $image_id => $url ) {
					if ( ! empty( $image_id ) ) {
						$image = wp_get_attachment_image( $image_id, $size );
						$str .= '<div class="gallery-slider-el">' . $image . '</div>';
					}
				}
				$str .= '</div><!--#gallery slider-->';

				$str .= '<div class="gallery-slider-nav slider-init">';
				foreach ( $gallery as $image_id => $url ) {
					if ( ! empty( $image_id ) ) {
						$image = wp_get_attachment_image( $image_id, $size );
						$str .= '<div>' . $image . '</div>';
					}
				}

				$str .= '</div><!--#slider gallery nav -->';

				$str .= '</div><!--#post gallery wrap-->';
			} else {

				$size = 'classic';
				//render grid
				$str .= '<div class="thumb-wrap post-el post-gallery is-grid">';
				$str .= '<div class="slider-loading"></div>';
				$str .= '<div class="gallery-grid slider-init">';
				foreach ( $gallery as $image_id => $url ) {
					if ( ! empty( $image_id ) ) {
						$image_full = wp_get_attachment_image_src( $image_id, 'full' );
						$image      = wp_get_attachment_image_src( $image_id, $size );
						$str .= '<a href="' . $image_full[0] . '"><img alt="" src="' . $image[0] . '"></a>';
					}
				}
				$str .= '</div><!--#gallery slider-->';
				$str .= '</div><!--#post gallery wrap-->';
			}

			return $str;
		}


		/**
		 * @param $singleID
		 * add number of view
		 */
		static function counter_single_views( $singleID ) {
			if ( is_single() ) {
				$count = get_post_meta( $singleID, 'tn_num_views', true );
				if ( $count == '' ) {
					delete_post_meta( $singleID, 'tn_num_views' );
					add_post_meta( $singleID, 'tn_num_views', '0' );
				} else {
					$count ++;
					update_post_meta( $singleID, 'tn_num_views', $count );
				};
			}
		}


		/**
		 * @param $post_id
		 * @return int|mixed
		 * get numbers of view
		 */
		static function get_single_views( $post_id ) {
			$count         = get_post_meta( $post_id, 'tn_num_views', true );
			$forgery_count = get_post_meta( $post_id, 'start_post_views_data', true );
			$forgery_view  = absint( tn_util::get_theme_option( 'start_views' ) );

			//forgery view
			if ( ! empty( $forgery_view ) ) {
				$forgery_data = get_post_meta( $post_id, 'start_post_views', true );
				if ( ! empty( $forgery_count ) && ( $forgery_data == $forgery_view ) ) {
					$count = $count + $forgery_count;
				} else {
					if ( $forgery_view - 100 > 0 ) {
						$val = rand( $forgery_view - 100, $forgery_view + 100 );
					} else {
						$val = rand( 0, $forgery_view + 100 );
					};
					delete_post_meta( $post_id, 'start_post_views' );
					delete_post_meta( $post_id, 'start_post_views_data' );
					add_post_meta( $post_id, 'start_post_views', $forgery_view );
					add_post_meta( $post_id, 'start_post_views_data', $val );
					$count = $count + $val;
				}
			};

			if ( '' == $count ) {
				$count = 0;
			};

			return $count;
		}
	}
}
