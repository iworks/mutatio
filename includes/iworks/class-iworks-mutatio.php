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

	public function __construct() {
		$file        = dirname( dirname( __FILE__ ) );
		$this->url   = rtrim( plugin_dir_url( $file ), '/' );
		$this->root  = rtrim( plugin_dir_path( $file ), '/' );
		$this->debug = defined( 'WP_DEBUG' ) && WP_DEBUG;
		/**
		 * End of line
		 */
		$this->eol = $this->debug ? PHP_EOL : '';
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
}

