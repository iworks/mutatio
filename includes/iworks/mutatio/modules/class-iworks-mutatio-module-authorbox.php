<?php

include_once 'class-iworks-mutatio-module.php';

class iWorks_Mutatio_Module_Authorbox extends iWorks_Mutatio_Module {

	protected $module_slug      = 'authorbox';
	protected $module_group_key = 'frontend';

	public function __construct( $options ) {
		if ( $this->is_rest_request() ) {
			return;
		}
		parent::__construct( $options );
		$this->module_name = __( 'Author Box', 'mutatio' );
		/**
		 * Settings
		 */
		$this->configuration = array(
			array(
				'name'    => $this->get_field_name( 'post_type' ),
				'type'    => 'checkbox_group',
				'th'      => __( 'Post Types', 'mutatio' ),
				'options' => array(
					'post',
					'page',
				),
				'since'   => '1.0.0',
			),
		);
		$this->register_setting( $this->configuration, $this->module_group_key );
	}

	public function wp_register_script() {
	}

	public function wp_enqueue_script() {
	}
}
