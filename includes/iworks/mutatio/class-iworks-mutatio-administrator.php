<?php

include_once dirname( dirname( __FILE__ ) ) . '/class-iworks-mutatio.php';

class iWorks_Mutatio_Administrator extends iWorks_Mutatio {

	public function __construct() {
		parent::__construct();
		add_action( 'admin_head', array( $this, 'action_admin_head_add_favicon' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		/**
		 * iWorks Mutatio Module Admin page
		 */
		add_action( 'iworks_mutatio_admin_subpage_callback', array( $this, 'admin_subpage_callback' ) );
		/**
		 * iWorks Rate Class
		 *
		 * Allow to change iWorks Rate logo for admin notice.
		 *
		 * @since 1.0.0
		 *
		 * @param string $logo Logo, can be empty.
		 * @param object $plugin Plugin basic data.
		 */
		add_filter( 'iworks_rate_notice_logo_style', array( $this, 'filter_plugin_logo' ), 10, 2 );
	}

	public function admin_init() {
		$this->options->options_init();
	}

	public function action_admin_head_add_favicon() {
		// d(get_current_screen());
		// d($this->options);
		// die;
	}

	/**
	 * Plugin logo for rate messages
	 *
	 * @since 1.0.0
	 *
	 * @param string $logo Logo, can be empty.
	 * @param object $plugin Plugin basic data.
	 */
	public function filter_plugin_logo( $logo, $plugin ) {
		if ( is_object( $plugin ) ) {
			$plugin = (array) $plugin;
		}
		if ( 'mutatio' === $plugin['slug'] ) {
			return $this->url . '/assets/images/logo.svg';
		}
		return $logo;
	}


	public function admin_subpage_callback() {
		$screen           = get_current_screen();
		$module_group_key = end( preg_split( '/_/', $screen->base ) );
		$page_data        = $this->options->get_group();
		$page_data        = $page_data['pages'][ $module_group_key ];
		/**
		 * filter options
		 */
		$options = apply_filters( 'iworks_mutatio_admin_subpage_configuration', array(), $module_group_key );
		if ( empty( $options ) ) {
			$options                = $page_data;
			$options['use_tabs']    = true;
				$options['version'] = '0.0';
				$options['options'] = array(
					/**
					 * Section "Admin Area"
					 *
					 * @since 1.0.0
					 */
					array(
						'type'        => 'heading',
						'label'       => __( 'Admin Area', 'mutatio' ),
						'description' => esc_html__( 'Select the modules which should be active.', 'mutatio' ),
					),
				);
		}

		d( $options );

		$this->options->build_options( 'index', true, false, $options );
	}
}

