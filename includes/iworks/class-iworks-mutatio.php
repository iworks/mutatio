<?php

abstract class iWorks_Mutatio {

	/**
	 * PLUGIN_VERSION
	 *
	 * @since 1.0.0
	 */
	protected $version = 'PLUGIN_VERSION';

	protected $configuration = array();

	protected $url;

	protected $debug = false;

	protected $root = '';

	/**
	 * iWorks Options object
	 *
	 * @since 1.0.0
	 */
	protected $options;


	public function __construct() {
		$file        = dirname( dirname( __FILE__ ) );
		$this->url   = rtrim( plugin_dir_url( $file ), '/' );
		$this->root  = rtrim( plugin_dir_path( $file ), '/' );
		$this->debug = defined( 'WP_DEBUG' ) && WP_DEBUG;
		/**
		 * End of line
		 */
		$this->eol = $this->debug ? PHP_EOL : '';
		/**
		 * set options
		 */
		$this->options = get_iworks_mutatio_options();
	}


	protected function get_svg_content( $image ) {
		$path = sprintf(
			'%s/assets/images/%s.svg',
			$this->root,
			$image
		);
		if ( is_file( $path ) ) {
			return file_get_contents( $path );
		}
		return null;
	}

	protected function get_image_url( $image ) {
		return add_query_arg(
			'version',
			$this->version,
			sprintf(
				'%s/assets/images/%s',
				$this->url,
				$image
			)
		);
	}

	protected function log_message( $mesage, $header = false ) {
		if ( ! $this->debug ) {
			return;
		}
		if ( ! empty( $header ) ) {
			$mesage = sprintf(
				'%s%s%s',
				$header,
				PHP_EOL,
				$mesage
			);
		}
		error_log( $mesage );
	}
}

