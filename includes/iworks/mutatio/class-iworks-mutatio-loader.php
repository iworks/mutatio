<?php

include_once dirname( dirname( __FILE__ ) ) . '/class-iworks-mutatio.php';

class iWorks_Mutatio_Loader extends iWorks_Mutatio {

	public function __construct() {
		parent::__construct();
		add_action( 'init', array( $this, 'action_init' ) );
	}

	public function action_init() {
		$this->options->options_init();
		/**
		 * load modules
		 */
		foreach ( $this->options->get_options_by_group( 'module' ) as $module ) {
			if ( $this->options->get_option( $module['name'] ) ) {
				$file = sprintf(
					'%s/modules/class-iworks-mutatio-module-%s.php',
					dirname( __FILE__ ),
					$module['name']
				);
				if ( is_file( $file ) ) {
					include_once( $file );
					$class = sprintf( 'iWorks_Mutatio_Module_%s', ucfirst( $module['name'] ) );
					new $class( $this->options );
				} else {
					// d($file);
				}
			}
		}
	}

}

