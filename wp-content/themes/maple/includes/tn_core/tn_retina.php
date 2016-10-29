<?php
/**
 * this file support retina feature
 */
if ( ! class_exists( 'tn_retina' ) ) {
	class tn_retina {

		//save retina options to database
		static function save_retina_option() {
			global $tn_theme_options;

			if ( ! empty( $tn_theme_options['retina_support'] ) ) {
				$retina_support = $tn_theme_options['retina_support'];
			} else {
				$retina_support = false;
			};

			delete_option( 'tn_retina_support_option' );
			add_option( 'tn_retina_support_option', $retina_support );
		}


		//retina attachment meta data
		static function retina_attachment_meta( $metadata, $attachment_id ) {
			foreach ( $metadata as $key => $value ) {
				if ( is_array( $value ) ) {
					foreach ( $value as $image => $attr ) {
						if ( is_array( $attr ) && ! empty( $attr['width'] ) && ! empty( $attr['height'] ) ) {
							self::create_retina_image( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
						};
					};
				};
			};

			return $metadata;
		}


		//create retina images
		static function create_retina_image( $file, $width, $height, $crop = false ) {
			if ( $width || $height ) {
				$resized_file = wp_get_image_editor( $file );
				if ( ! is_wp_error( $resized_file ) ) {
					$filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );

					$resized_file->resize( $width * 1.5, $height * 1.5, $crop ); //Create *1.5 size for faster load and reduce memory.
					$resized_file->save( $filename );

					$info = $resized_file->get_size();

					return array(
						'file'   => wp_basename( $filename ),
						'width'  => $info['width'],
						'height' => $info['height'],
					);
				};
			};

			return false;
		}


		//delete retina image
		static function delete_retina_image( $attachment_id ) {
			$meta       = wp_get_attachment_metadata( $attachment_id );
			$upload_dir = wp_upload_dir();
			if ( empty( $meta['file'] ) ) {
				return false;
			}
			$path = pathinfo( $meta['file'] );
			if ( is_array( $meta ) ) {
				foreach ( $meta as $key => $value ) {
					if ( 'sizes' === $key ) {
						foreach ( $value as $sizes => $size ) {
							$original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
							$retina_filename   = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
							if ( file_exists( $retina_filename ) ) {
								unlink( $retina_filename );
							};
						};
					};
				};
			};
		}

	}
}


//add filter
if ( get_option( 'tn_retina_support_option', false ) ) {
	add_filter( 'wp_generate_attachment_metadata', array( 'tn_retina', 'retina_attachment_meta' ), 10, 2 );
};
add_filter( 'delete_attachment', array( 'tn_retina', 'delete_retina_image' ) );

//save retina options for backend
add_action( 'redux/options/tn_theme_options/saved', array( 'tn_retina', 'save_retina_option' ) );
add_action( 'redux/options/tn_theme_options/reset', array( 'tn_retina', 'save_retina_option' ) );
add_action( 'redux/options/tn_theme_options/section/reset', array( 'tn_retina', 'save_retina_option' ) );