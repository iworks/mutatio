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
		$post_types         = get_post_types( array( 'public' => true ), 'objects' );
		$post_types_options = array();
		foreach ( $post_types as $key => $post_type ) {
			$post_types_options[ $key ] = $post_type->labels->singular_name;
		}
		$this->configuration = array(
			array(
				'name'    => $this->get_field_name( 'post_type' ),
				'type'    => 'checkbox_group',
				'th'      => __( 'Post Types', 'mutatio' ),
				'options' => $post_types_options,
				'since'   => '1.0.0',
				'default' => array( 'post' ),
			),
		);
		$this->register_setting( $this->configuration, $this->module_group_key );
	}

	public function wp_register_script() {
	}

	public function wp_enqueue_script() {
	}
}
