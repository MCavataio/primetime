<?php


/**
 * Class tn_counter
 * this file counter social
 */
class tn_counter {

	/**
	 * @param $url
	 * @return bool
	 * count facebook fan
	 */
	static function count_facebook( $url ) {
		if ( empty( $url ) ) {
			return false;
		};
		$tn_fb_access_token = 'CAAF5MfMU36oBAKOjOZBWjtck3gWyBMPmK14SYHZATGS3vrqFKS9DyhIyXpBUeKZBcqLlIwtUR5okoIT1P23EB5yiCK72RTytZB6y6kEnky2QaHztDP3YyBZBFMhaZAJTq4khSjWCFkuTPZAkLfbvm9KFumBXbnOffVx5GlbQIPmWg0H7YLiGpri';
		$response           = wp_remote_get( 'https://graph.facebook.com/v2.3/' . urlencode( $url ) . '?access_token=' . $tn_fb_access_token );
		if ( is_wp_error( $response ) ) {
			return false;
		};
		$data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( ! empty( $data->likes ) ) {
			return $data->likes;
		} else {
			return false;
		}
	}

	/**
	 * @param       $user
	 * @param array $api
	 * @return int
	 * count twitter follower
	 */
	static function count_twitter( $user, $api = array() ) {
		//check options
		if ( empty( $user ) || empty( $api['consumer_key'] ) || empty( $api['consumer_secret'] ) ) {
			return false;
		};

		$credentials = $api['consumer_key'] . ':' . $api['consumer_secret'];
		$to_send     = base64_encode( $credentials );
		$token       = get_option( 'tn_twitter_token' );

		// http post arguments
		if ( empty( $token ) ) {
			$args = array(
				'method'      => 'POST',
				'httpversion' => '1.1',
				'blocking'    => true,
				'headers'     => array(
					'Authorization' => 'Basic ' . $to_send,
					'Content-Type'  => 'application/x-www-form-urlencoded',
				),
				'body'        => array( 'grant_type' => 'client_credentials' )
			);
			add_filter( 'https_ssl_verify', '__return_false' );
			$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );
			$keys     = json_decode( wp_remote_retrieve_body( $response ) );
			if ( $keys ) {
				$token = $keys->access_token;
				update_option( 'tn_twitter_token', $token );
			};
		}

		$args = array(
			'httpversion' => '1.1',
			'blocking'    => true,
			'headers'     => array(
				'Authorization' => "Bearer $token"
			)
		);
		add_filter( 'https_ssl_verify', '__return_false' );
		$api_url  = "https://api.twitter.com/1.1/users/show.json?screen_name=$user";
		$response = wp_remote_get( $api_url, $args );
		if ( ! is_wp_error( $response ) ) {
			$followers = json_decode( wp_remote_retrieve_body( $response ) );
			if ( ! empty( $followers->followers_count ) ) {
				return $followers->followers_count;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/**
	 * @param $api
	 * @return array
	 * count instagram followers
	 */
	static function count_instagram( $api ) {
		//check option
		if ( empty( $api ) ) {
			return false;
		};
		$users = explode( ".", $api );
		if ( empty( $users[0] ) ) {
			return false;
		};
		$data     = array();
		$url      = 'https://api.instagram.com/v1/users/' . $users[0] . '/?access_token=' . $api;
		$response = wp_remote_get( $url, array( 'timeout' => 100 ) );
		if ( is_wp_error( $response ) || '200' != $response['response']['code'] ) {
			return false;
		};
		$response = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( empty( $response['data']['counts']['followed_by'] ) || empty( $response['data']['username'] ) ) {
			return false;
		}
		$data['count']     = $response['data']['counts']['followed_by'];
		$data['user_name'] = $response['data']['username'];
		$data['url']       = 'http://instagram.com/' . $data['user_name'];

		return $data;
	}


	/**
	 * @param $user
	 * @param $token
	 * @return bool
	 * count dribbble followers
	 */
	static function  count_dribbble( $user, $token ) {
		if ( empty( $user ) || empty( $token ) ) {
			return false;
		}
		$params   = array(
			'sslverify' => false,
			'timeout'   => 100,
		);
		$response = wp_remote_get( 'https://api.dribbble.com/v1/users/' . $user . '?access_token=' . $token, $params );
		if ( ! is_wp_error( $response ) || empty($response['response']['code']) || '200' != $response['response']['code'] ) {
			$response = json_decode( wp_remote_retrieve_body( $response ) );
			if ( ! empty( $response->followers_count ) ) {
				return $response->followers_count;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/**
	 * @param $user
	 * @param $channel
	 * @return bool
	 * count youtube Subscriber
	 */
	static function count_youtube( $user, $channel ) {
		//check
		if ( empty( $user ) && empty ( $channel ) ) {
			return false;
		}

		if ( ! empty( $user ) ) {
			$url = "https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=" . $user . "&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo";
		} else {
			$url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id=' . $channel . '&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo';
		}

		$params   = array(
			'sslverify' => false,
			'timeout'   => 100
		);
		$response = wp_remote_get( $url, $params );
		if ( is_wp_error( $response ) ) {
			return false;
		} else {
			$response = json_decode( wp_remote_retrieve_body( $response ) );
			if ( ! empty( $response->items[0]->statistics->subscriberCount ) ) {
				return $response->items[0]->statistics->subscriberCount;
			} else {
				return false;
			}
		}
	}


	/**
	 * @param $user
	 * @param $api
	 * @return bool
	 * count soundclound follower
	 */
	static function count_soundclound( $user, $api ) {
		//check
		if ( empty( $user ) || empty( $api ) ) {
			return false;
		}
		$url      = 'http://api.soundcloud.com/users/' . $user . '.json?consumer_key=' . $api;
		$response = wp_remote_get( $url, array( 'timeout' => 100 ) );
		if ( is_wp_error( $response ) || '200' != $response['response']['code'] ) {
			return false;
		} else {
			$response = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( empty( $response['followers_count'] ) || empty( $response['permalink_url'] ) ) {
				return false;
			}
			$data['count'] = esc_attr( $response['followers_count'] );
			$data['url']   = esc_url( $response['permalink_url'] );

			return $data;
		}
	}


	/**
	 * @param $user
	 * @return bool|int
	 * counter pinterest followers
	 */
	static function count_pinterest( $user ) {
		//check
		if ( empty( $user ) ) {
			return false;
		}
		$response = get_meta_tags( 'http://pinterest.com/' . $user . '/' );
		if ( ! empty( $response ) ) {
			return intval( strip_tags( $response['pinterestapp:followers'] ) );
		} else {
			return false;
		}
	}


	/**
	 * @param $user
	 * @return bool
	 * count vimeo followers
	 */
	static function count_vimeo( $user ) {
		//check
		if ( empty( $user ) ) {
			return false;
		};
		$url      = 'https://vimeo.com/api/v2/' . $user . '/info.json';
		$response = wp_remote_get( $url, array( 'timeout' => 100 ) );
		if ( is_wp_error( $response ) || 200 != $response['response']['code'] ) {
			return false;
		}
		$response = json_decode( wp_remote_retrieve_body( $response ) );
		if ( ! empty( $response->total_contacts ) ) {
			return $response->total_contacts;
		} else {
			return false;
		}
	}

}