<?php

include_once 'class-iworks-mutatio-module.php';

class iWorks_Mutatio_Module_Maintenance extends iWorks_Mutatio_Module {

    protected $module_slug      = 'maintenance';
    protected $module_group_key = 'utilites';

    public function __construct( $options ) {
        if ( $this->is_rest_request() ) {
            return;
        }
        parent::__construct( $options );
        $this->module_name = __( 'Maintenance', 'mutatio' );

        /**
         * off for ffrontend if it is not needed
         */
        if ( ! is_admin() ) {
            if ( 'off' === $this->get_option_value( 'mode' ) ) {
                return;
            }
            add_action( 'template_redirect', array( $this, 'output' ), 0 );
            add_filter( 'rest_authentication_errors', array( $this, 'only_allow_logged_in_rest_access' ) );
        }
        /**
         * Settings
         */
        $this->configuration = array(
            array(
                'name'    => $this->get_field_name( 'mode' ),
                'type'    => 'radio',
                'th'      => __( 'Post Types', 'mutatio' ),
                'options' => array(
                    'off' => array(
                        'label' => __( 'Off', 'mutatio' ),
                    ),
                    // 'soon' => array(
                        // 'label' => __( 'Soon', 'mutatio' ),
                    // ),
                    'maintenance' => array(
                        'label' => __( 'Maintenance', 'mutatio' ),
                    ),
                ),
                'since'   => '1.0.0',
                'default' => 'off',
            ),
            array(
                'name'    => $this->get_field_name( 'content' ),
                'type'    => 'textarea',
                'th'      => __( 'Content', 'mutatio' ),
                'classes' => array(
                    'large-text',
                ),
                'rows' => 20,
                'since'   => '1.0.0',
            ),
        );
        $this->register_setting( $this->configuration, $this->module_group_key );
    }

    public function wp_register_script() {
    }

    public function wp_enqueue_script() {
    }

    /**
     * Display the coming soon page
     */
    public function output() {
        /**
         * Compability with Domain Mapping
         * Cross-domain autologin (asynchronously)
         *
         * @since 1.0.0
         */
        if ( class_exists( 'Domainmap_Module_Cdsso' ) ) {
            global $wp_query;
            if ( isset( $wp_query->query_vars[ Domainmap_Module_Cdsso::SSO_ENDPOINT ] ) ) {
                return;
            }
        }
        $args = array();
        /**
         * set data
         */
        $head = '';
        if ( function_exists( 'wp_site_icon' ) ) {
            ob_start();
            wp_site_icon();
            $head = ob_get_contents();
            ob_end_clean();
        }
        $body_classes = $this->get_body_classes();
        /**
         * content
         */
        $args['body'] = wpautop( $this->get_option_value( 'content' ) );
        /**
         * Settings
         */
        /**
         *  set headers
         */
        $mode = $this->get_option_value( 'mode' );
        if ( 'maintenance' === $mode ) {
            header( 'HTTP/1.1 503 Service Temporarily Unavailable' );
            header( 'Status: 503 Service Temporarily Unavailable' );
            header( 'Retry-After: 86400' ); // retry in a day
            $maintenance_file = WP_CONTENT_DIR . '/maintenance.php';
            if ( ! empty( $enable_maintenance_php ) and file_exists( $maintenance_file ) ) {
                include_once $maintenance_file;
                exit();
            }
        }
        // Prevetn Plugins from caching
        // Disable caching plugins. This should take care of:
        // - W3 Total Cache
        // - WP Super Cache
        // - ZenCache (Previously QuickCache)
        if ( ! defined( 'DONOTCACHEPAGE' ) ) {
            define( 'DONOTCACHEPAGE', true );
        }
        if ( ! defined( 'DONOTCDN' ) ) {
            define( 'DONOTCDN', true );
        }
        if ( ! defined( 'DONOTCACHEDB' ) ) {
            define( 'DONOTCACHEDB', true );
        }
        if ( ! defined( 'DONOTMINIFY' ) ) {
            define( 'DONOTMINIFY', true );
        }
        if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
            define( 'DONOTCACHEOBJECT', true );
        }
        header( 'Cache-Control: max-age=0; private' );
        /**
         * Render
         */
        $this->render( $mode, $args );
        exit;
    }
}

