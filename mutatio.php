<?php
/**
 * Mutatio — change your site look
 *
 * @package           PLUGIN_NAME
 * @author            AUTHOR_NAME
 * @copyright         2022-PLUGIN_TILL_YEAR Marcin Pietrzak
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Mutatio
 * Plugin URI:        PLUGIN_URI
 * Description:       PLUGIN_DESCRIPTION
 * Version:           PLUGIN_VERSION
 * Requires at least: PLUGIN_REQUIRES_WORDPRESS
 * Requires PHP:      PLUGIN_REQUIRES_PHP
 * Author:            AUTHOR_NAME
 * Author URI:        AUTHOR_URI
 * Text Domain:       mutatio
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * static options
 */
$base     = dirname( __FILE__ );
$includes = $base . '/includes';

/**
 * get plugin settings
 *
 * @since 1.0.0
 */
include_once $base . '/etc/options.php';

/**
 * @since 1.0.6
 */
if ( ! class_exists( 'iworks_options' ) ) {
	include_once $includes . '/iworks/options/options.php';
}

/**
 * i18n
 */
load_plugin_textdomain( 'mutatio', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

/**
 * load
 */
require_once $includes . '/iworks/mutatio/class-iworks-mutatio-loader.php';
// require_once $includes . '/iworks/mutatio/class-iworks-mutatio-frontend.php';
// require_once $includes . '/iworks/mutatio/class-iworks-mutatio-apple.php';
// require_once $includes . '/iworks/mutatio/class-iworks-mutatio-microsoft.php';

/**
 * run
 */
new iWorks_Mutatio_Loader;
// new iWorks_PWA_Frontend;
// new iWorks_PWA_Apple;
// new iWorks_PWA_Microsoft;

/**
 * admin
 */
if ( is_admin() ) {
	require_once $includes . '/iworks/mutatio/class-iworks-mutatio-administrator.php';
	new iWorks_Mutatio_Administrator;
}

/**
 * load options
 *
 * since 1.0.0
 *
 */
global $iworks_mutatio_options;
$iworks_mutatio_options = null;

function get_iworks_mutatio_options() {
	global $iworks_mutatio_options;
	if ( is_object( $iworks_mutatio_options ) ) {
		return $iworks_mutatio_options;
	}
	$iworks_mutatio_options = new iworks_options();
	$iworks_mutatio_options->set_option_function_name( 'iworks_mutatio_options' );
	$iworks_mutatio_options->set_option_prefix( 'iworks_mutatio_' );
	if ( method_exists( $iworks_mutatio_options, 'set_plugin' ) ) {
		$iworks_mutatio_options->set_plugin( basename( __FILE__ ) );
	}
	return $iworks_mutatio_options;
}


/**
 * Ask for vote
 *
 * @since 1.0.0
 */
include_once $includes . '/iworks/rate/rate.php';
do_action(
	'iworks-register-plugin',
	plugin_basename( __FILE__ ),
	__( 'Mutatio', 'mutatio' ),
	'mutatio'
);


