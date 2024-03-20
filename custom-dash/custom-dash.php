<?php
/**
 * Custom Dash plugin.
 *
 * @since             1.0.0
 * @package           ias-wp-customdash
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Dash
 * Description:       This plugin will change the logo on login screen.
 * Version:           1.0.0
 * Author:            Arun Sharma
 * Author URI:        https://www.imarun.me/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-dash
 */

declare( strict_types = 1 );

use Imarun\CustomDash\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Plugin version constants.
 */
define( 'IAS_CD_WP_PLUGIN_VERSION', '1.0.0' );

include_once __DIR__ . '/vendor/autoload.php';

$plugin = new Plugin();
