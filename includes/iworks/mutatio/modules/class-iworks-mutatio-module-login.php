<?php

include_once 'class-iworks-mutatio-module.php';

class iWorks_Mutatio_Module_Login extends iWorks_Mutatio_Module {

	public function __construct( $options ) {
		parent::__construct( $options );
		/**
		 * Settings
		 */
		$this->configuration = array();
		$this->register_setting( $this->configuration, $this->module_group_key );
	}

}
