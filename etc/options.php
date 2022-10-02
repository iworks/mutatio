<?php

function iworks_mutatio_options() {
	$options = array();
	/**
	 * main settings
	 */
	$options['index'] = array(
		'use_tabs'        => true,
		'version'         => '0.0',

		/**
		 * admin menu
		 */
		'page_title'      => __( 'Mutatio — Configuration', 'mutatio' ),
		'menu_title'      => __( 'Mutatio', 'mutatio' ),
		'menu'            => 'mutatio',
		'menu_capability' => apply_filters( 'mutatio/admin_menu/capability', 'manage_options' ),
		'menu_icon'       => iworks_mutatio_options_get_icon(),
		'menu_position'   => 80.1664476699,

		'pages'           => array(
			'admin'    => array(
				'menu'               => 'submenu',
				'parent'             => 'iworks_mutatio_index',
				'menu_title'         => __( 'Admin Area', 'mutatio' ),
				'page_title'         => __( 'Admin Area — Configuration', 'mutatio' ),
				'menu_capability'    => apply_filters( 'mutatio/capability/admin', 'manage_options' ),
				'show_page_callback' => 'iworks_mutatio_page_callback',
			),
			'frontend' => array(
				'menu'               => 'submenu',
				'parent'             => 'iworks_mutatio_index',
				'menu_title'         => __( 'Front-end', 'mutatio' ),
				'page_title'         => __( 'Front-end — Configuration', 'mutatio' ),
				'menu_capability'    => apply_filters( 'mutatio/capability/module/frontend', 'manage_options' ),
				'show_page_callback' => 'iworks_mutatio_page_callback',
			),
			'email'    => array(
				'menu'               => 'submenu',
				'parent'             => 'iworks_mutatio_index',
				'menu_title'         => __( 'Email', 'mutatio' ),
				'page_title'         => __( 'Email — Configuration', 'mutatio' ),
				'menu_capability'    => apply_filters( 'mutatio/capability/module/email', 'manage_options' ),
				'show_page_callback' => 'iworks_mutatio_page_callback',
			),
			'utilites' => array(
				'menu'               => 'submenu',
				'parent'             => 'iworks_mutatio_index',
				'menu_title'         => __( 'Utilites', 'mutatio' ),
				'page_title'         => __( 'Utilites — Configuration', 'mutatio' ),
				'menu_capability'    => apply_filters( 'mutatio/capability/module/utilites', 'manage_options' ),
				'show_page_callback' => 'iworks_mutatio_page_callback',
			),
		),

		'enqueue_scripts' => array(),
		'enqueue_styles'  => array(),
		'options'         => array(
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
			array(
				'name'              => 'login',
				'type'              => 'checkbox',
				'th'                => __( 'Login Screen', 'mutatio' ),
				'default'           => 0,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
				'since'             => '1.0.0',
				'group'             => 'module',
			),
			/**
			 * Section "Frontend"
			 *
			 * @since 1.0.0
			 */
			array(
				'type'  => 'heading',
				'label' => __( 'Front-end', 'mutatio' ),
				'since' => '1.0.0',
			),
			/**
			 * Section "Email"
			 *
			 * @since 1.0.0
			 */
			array(
				'type'  => 'heading',
				'label' => __( 'Email', 'mutatio' ),
			),
			/**
			 * Section "Utilites"
			 *
			 * @since 1.0.0
			 */
			array(
				'type'  => 'heading',
				'label' => __( 'Utilites', 'mutatio' ),
			),
			array(
				'name'              => 'cookie',
				'type'              => 'checkbox',
				'th'                => __( 'Cookie Notice', 'mutatio' ),
				'default'           => 0,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
				'since'             => '1.0.0',
				'group'             => 'module',
			),
			array(
				'name'              => 'maintenance',
				'type'              => 'checkbox',
				'th'                => __( 'Maintenance Mode', 'mutatio' ),
				'default'           => 0,
				'sanitize_callback' => 'absint',
				'classes'           => array( 'switch-button' ),
				'since'             => '1.0.0',
				'group'             => 'module',
			),
			/**
			 * Section "Settings"
			 *
			 * @since 1.0.0
			 */
			array(
				'type'  => 'heading',
				'label' => __( 'Settings', 'mutatio' ),
			),
			array(
				'type'        => 'subheading',
				'label'       => __( 'Data', 'mutatio' ),
				'description' => __( 'Control what to do with your settings and data. Settings are considered the module configurations, Data includes the transient bits such as logs, last import/export time and other pieces of information stored over time.', 'mutatio' ),
			),
			array(
				'name'              => 'uninstall',
				'type'              => 'radio',
				'th'                => __( 'Uninstallation', 'mutatio' ),
				'default'           => 'keep',
				'radio'             => array(
					'keep'   => array( 'label' => __( 'Keep', 'upprev' ) ),
					'remove' => array( 'label' => __( 'Remove', 'upprev' ) ),
				),
				'sanitize_callback' => 'esc_html',
				'description'       => __( 'When you uninstall Mutatio, what do you want to do with your settings and stored data?', 'mutatio' ),
			),
			array(
				'name'              => 'install',
				'type'              => 'radio',
				'th'                => __( 'Installation', 'mutatio' ),
				'default'           => 'preserve',
				'radio'             => array(
					'preserve' => array( 'label' => __( 'Preserve', 'upprev' ) ),
					'reset'    => array( 'label' => __( 'Reset', 'upprev' ) ),
				),
				'sanitize_callback' => 'esc_html',
				'description'       => __( 'Choose whether to save your settings for next time, or reset them.', 'mutatio' ),
			),
		),
	);
	/**
	 * return
	 */
	return apply_filters( 'iworks_plugin_get_options', $options, 'mutatio' );
}

function iworks_mutatio_options_loved_this_plugin( $iworks_iworks_seo_improvements ) {
	$content = apply_filters( 'iworks_rate_love', '', 'mutatio' );
	if ( ! empty( $content ) ) {
		echo $content;
		return;
	}
	?>
<p><?php _e( 'Below are some links to help spread this plugin to other users', 'mutatio' ); ?></p>
<ul>
	<li><a href="https://wordpress.org/support/plugin/mutatio/reviews/#new-post"><?php _e( 'Give it a five stars on WordPress.org', 'mutatio' ); ?></a></li>
	<li><a href="<?php _ex( 'https://wordpress.org/plugins/mutatio/', 'plugin home page on WordPress.org', 'mutatio' ); ?>"><?php _e( 'Link to it so others can easily find it', 'mutatio' ); ?></a></li>
</ul>
	<?php
}
function iworks_mutatio_taxonomies() {
	$data       = array();
	$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
	foreach ( $taxonomies as $taxonomy ) {
		$data[ $taxonomy->name ] = $taxonomy->labels->name;
	}
	return $data;
}
function iworks_mutatio_post_types() {
	$args       = array(
		'public' => true,
	);
	$p          = array();
	$post_types = get_post_types( $args, 'names' );
	foreach ( $post_types as $post_type ) {
		$a               = get_post_type_object( $post_type );
		$p[ $post_type ] = $a->labels->name;
	}
	return $p;
}

function iworks_mutatio_options_need_assistance( $iworks_iworks_seo_improvementss ) {
	$content = apply_filters( 'iworks_rate_assistance', '', 'mutatio' );
	if ( ! empty( $content ) ) {
		echo $content;
		return;
	}

	?>
<p><?php _e( 'We are waiting for your message', 'mutatio' ); ?></p>
<ul>
	<li><a href="<?php _ex( 'https://wordpress.org/support/plugin/mutatio/', 'link to support forum on WordPress.org', 'mutatio' ); ?>"><?php _e( 'WordPress Help Forum', 'mutatio' ); ?></a></li>
</ul>
	<?php
}

function iworks_mutatio_options_get_icon() {
	return sprintf(
		'data:image/svg+xml;base64,%s',
		base64_encode(
			file_get_contents(
				sprintf(
					'%s/assets/images/menu-icon.svg',
					plugin_dir_path( dirname( __FILE__ ) )
				)
			)
		)
	);
}

function iworks_mutatio_page_callback() {
	do_action( 'iworks_mutatio_admin_subpage_callback' );
}

