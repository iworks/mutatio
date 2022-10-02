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
			$options['options'] = array(
				/**
				 * Section "Admin Area"
				 *
				 * @since 1.0.0
				 */
				array(
					'type'        => 'heading',
					'description' => esc_html__( 'There is no active modules in this section.', 'mutatio' ),
				),
			);
		} else {
			$page_data['use_tabs'] = true;
		}
		$options = $page_data + $options;
		?>
<div class="wrap iworks_options">
	<h1><?php echo $options['page_title']; ?></h1>
	<form method="post" action="<?php echo esc_url( $url ); ?>" id="<?php echo esc_attr( $screen->base ); ?>">
		<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
		<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
		<input type="hidden" name="action" value="save_howto_metaboxes_general" />
		<div class="metabox-holder<?php echo empty( $screen_layout_columns ) || 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
		<?php
		// $this->settings_fields( $option_name );

		$this->options->build_options( 'index', true, false, $options );
		?>
				</div>
			</div>
			<br class="clear"/>
		</div>
	</form>
</div>
		<?php
	}
}

