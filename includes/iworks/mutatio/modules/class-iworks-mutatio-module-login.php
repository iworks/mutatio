<?php

include_once 'class-iworks-mutatio-module.php';

class iWorks_Mutatio_Module_Login extends iWorks_Mutatio_Module {

	public function __construct( $options ) {
		parent::__construct( $options );
	}

	public function filter_options_add_module_configuration( $configuration, $module_slug ) {
		return $configuration;
	}
}
