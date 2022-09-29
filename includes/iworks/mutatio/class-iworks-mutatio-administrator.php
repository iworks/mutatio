<?php

include_once dirname( dirname( __FILE__ ) ) . '/class-iworks-mutatio.php';

class iWorks_Mutatio_Administrator extends iWorks_Mutatio {

	public function __construct() {
		parent::__construct();
		add_action( 'admin_menu', array( $this, 'action_admin_menu_add' ) );
	}

	/**
	 * main page of plugin
	 *
	 * @since 1.0.0
	 */
	public function admin_main_page() {
	}

	/**
	 * add plugin menu
	 *
	 * @since 1.0.0
	 */
	public function action_admin_menu_add() {
		add_menu_page(
			__( 'Mutatio', 'mutatio' ),
			__( 'Mutatio', 'mutatio' ),
			apply_filters( 'mutatio/admin_menu/capability', 'manage_options' ),
			'mutatio',
			array( $this, 'admin_main_page' ),
			'data:image/svg+xml;base64,' . base64_encode( $this->get_svg_content( 'menu-icon' ) ),
			80.1664476699
		);
	}

}

