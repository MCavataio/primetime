<?php
/**
 * Class tn_query
 * This file handling query data for theme
 */
if ( ! class_exists( 'tn_query' ) ) {
	class tn_query {

		/**
		 * @param string $args
		 * @param string $paged
		 * @return WP_Query
		 * get custom query
		 */
		static function get_custom_query( $args = '', $paged = '' ) {
			extract( shortcode_atts(
				         array(
					         'category_ids'   => '',
					         'category_id'    => '',
					         'author_id'      => '',
					         'tags'           => '',
					         'tag_ids'        => '',
					         'posts_per_page' => '',
					         'offset'         => '',
					         'orderby'        => '',
					         'post_types'     => '',
					         'meta_key'       => '',
					         'post__not_in'   => '',
				         ), $args
			         )
			);
			$args_query = array();

			$args_query['ignore_sticky_posts'] = 1;
			$args_query['post_status']         = 'publish';
			if ( empty( $posts_per_page ) ) {
				$posts_per_page = '5';
			}
			$args_query['posts_per_page'] = $posts_per_page;

			//category query
			if ( ! empty( $category_id ) and empty( $category_ids ) ) {
				$category_ids = $category_id;
			}
			if ( ! empty( $category_ids ) ) {
				$args_query['cat'] = $category_ids;
			}

			//tags query
			if ( empty( $tag_ids ) && ! empty( $tags ) ) {
				$args_query['tag'] = $tags;
			}
			if ( ! empty( $tag_ids ) ) {
				$args_query['tag__in'] = $tag_ids;
			}

			//author query
			if ( ! empty( $author_id ) ) {
				$args_query['author'] = $author_id;
			}

			if ( ! empty( $paged ) ) {
				$args_query['paged'] = $paged;
			} else {
				$args_query['paged'] = 1;
			}
			if ( ! empty( $offset ) and $paged > 1 ) {
				$args_query['offset'] = intval( $offset ) + intval( ( $paged - 1 ) * $posts_per_page );
			} else {
				$args_query['offset'] = intval( $offset );
			}

			//meta keys
			if ( ! empty( $meta_key ) ) {
				$args_query['meta_key'] = $meta_key;
			}

			if ( ! empty( $post__not_in ) ) {
				$args_query['post__not_in'] = explode( ',', $post__not_in );
			}

			if ( empty( $orderby ) ) {
				$orderby = 'date_post';
			}
			switch ( $orderby ) {
				case 'date_post' :
					$args_query['orderby'] = 'date';
					break;
				case 'comment_count' :
					$args_query['orderby'] = 'comment_count';
					break;
				case 'post_type' :
					$args_query['orderby'] = 'type';
					break;
				case 'popular':
					$args_query['meta_key'] = 'tn_num_views';
					$args_query['orderby']  = 'meta_value_num';
					$args_query['order']    = 'DESC';
					break;
				case 'rand':
					$args_query['orderby'] = 'rand';
					break;
				case 'alphabetical_order_decs':
					$args_query['orderby'] = 'title';
					$args_query['order']   = 'DECS';
					break;
				case 'alphabetical_order_asc':
					$args_query['orderby'] = 'title';
					$args_query['order']   = 'ASC';
					break;
			};

			$data_query = new WP_Query( $args_query );

			return $data_query;
		}
	}
}
