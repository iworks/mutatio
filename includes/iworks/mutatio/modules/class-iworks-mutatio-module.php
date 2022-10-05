<?php

abstract class iWorks_Mutatio_Module {

	/**
	 * PLUGIN_VERSION
	 *
	 * @since 1.0.0
	 */
	protected $version       = 'PLUGIN_VERSION';
	protected $configuration = array();
	protected $data          = array();
	protected $url;
	protected $debug = false;
	protected $root  = '';

	/**
	 * iWorks Options object
	 *
	 * @since 1.0.0
	 */
	protected $options;

	/**
	 * Module option name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $option_name = 'mutatio';

	/**
	 * Module slug name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $module_slug = 'index';

	/**
	 * Module options (configuration).
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $module_options = array();

	/**
	 * Module name name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $module_name = 'Mutatio';

	/**
	 * Module group_key name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $module_group_key = 'mutatio';

	public function __construct( $options ) {
		$file        = dirname( dirname( dirname( dirname( __FILE__ ) ) ) );
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
		$this->options = $options;
		/**
		 * hooks
		 */
		add_filter( 'iworks_mutatio_admin_subpage_configuration', array( $this, 'filter_options_add_module_configuration' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_register_script' ), 544 );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_script' ), 887 );
	}

	abstract public function wp_register_script();
	abstract public function wp_enqueue_script();

	/**
	 * Check is REST API request handler
	 *
	 * @since 1.0.0
	 */
	protected function is_rest_request() {
		return defined( 'REST_REQUEST' ) && REST_REQUEST;
	}

	public function filter_options_add_module_configuration( $configuration, $module_group_key ) {
		if ( $this->module_group_key !== $module_group_key ) {
			return $configuration;
		}
		if ( ! isset( $configuration['options'] ) ) {
			$configuration['options'] = array();
		}
		$configuration['options'][] = array(
			'type'  => 'heading',
			'label' => $this->module_name,
		);
		foreach ( $this->configuration as $one ) {
			$configuration['options'][] = $one;
		}
		return $configuration;
	}

	protected function get_field_name( $field_name ) {
		return sprintf(
			'%s_%s',
			$this->module_slug,
			$field_name
		);
	}

	protected function get_option_value( $field_name ) {
		return $this->options->get_option( $this->get_field_name( $field_name ) );
	}

	protected function register_setting( $options, $option_group ) {
		foreach ( $options as $option ) {
			/**
			 * don't register setting without type and name
			 */
			if ( ! is_array( $option ) || ! array_key_exists( 'type', $option ) || ! array_key_exists( 'name', $option ) ) {
				continue;
			}
			/**
			 * don't register certain type setting or with empty name
			 */
			if ( preg_match( '/^(sub)?heading$/', $option['type'] ) || empty( $option['name'] ) ) {
				continue;
			}
			/**
			 * register setting
			 */
			$args = array();
			if ( isset( $option['sanitize_callback'] ) ) {
				$args['sanitize_callback'] = $option['sanitize_callback'];
			}
			if ( isset( $option['description'] ) ) {
				$args['description'] = $option['description'];
			}
			if ( isset( $option['flush_rewrite_rules'] ) ) {
				$action = sprintf( 'update_option_%s%s', $this->options->get_option_name( $option['name'] ) );
				add_action( $action, array( $this, 'flush_rewrite_rules' ) );
			}
			/**
			 * register
			 */
			register_setting(
				'mutatio_page_iworks_mutatio_' . $option_group,
				$this->options->get_option_name( $option['name'] ),
				$args
			);
		}
	}

	protected function register_script( $target = 'frontend' ) {
		wp_register_script(
			$this->options->get_option_name( $this->module_slug ),
			sprintf(
				'%s/assets/scripts/module/%s-%s%s.js',
				$this->url,
				$this->module_slug,
				$target,
				$this->debug ? '' : '.min'
			),
			array(),
			$this->version,
			true
		);
	}

	protected function enqueue_script() {
		$handle = $this->options->get_option_name( $this->module_slug );
		wp_enqueue_script( $handle );
		if ( $this->data ) {
			wp_localize_script( $handle, $handle, $data );
		}
	}

	protected function get_css_rule( $name, $value, $value_sufix = '' ) {
		return sprintf(
			'%s: %s%s;%s',
			$name,
			$value,
			$value_sufix,
			$this->eol
		);
	}

	protected function get_css_selector( $selector, $rules ) {
		return sprintf(
			'%1$s{%3$s%2$s}%3$s',
			$selector,
			$rules,
			$this->eol
		);
	}

	protected function get_css_media( $type, $value, $rules ) {
		if ( ! preg_match( '/^m(in|ax)$/', $type ) ) {
			return $rules;
		}
		return sprintf(
			'@media screen and (%1$s-width:%2$s) {%4$s%3$s}%4$s',
			esc_attr( $type ),
			is_numeric( $value ) ? ( 'max' === $type ? $value + 1 : $value ) . 'px' : $value,
			$rules,
			$this->eol
		);

	}
}
