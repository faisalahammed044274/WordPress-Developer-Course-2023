<?php
/*
 * Plugin Name:			Background Builder for Section
 * Plugin URI:			https://pluginenvision.com/plugins/background-block
 * Description:			Customize your WordPress section easily! Choose backgrounds with color, gradient, image. Add parallax effects, and more for a stunning layout.
 * Version:				0.05
 * Requires at least:	6.2
 * Requires PHP:		7.2
 * Author:				Plugin Envision
 * Author URI:			https://pluginenvision.com
 * License:				GPLv3 or later
 * License URI:			https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:			background-block
 * Domain Path:			/languages
*/

if ( !defined( 'ABSPATH' ) ) { exit; }

define( 'EVBB_VERSION', isset( $_SERVER['HTTP_HOST'] ) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '0.05' );
define( 'EVBB_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'EVBB_DIR_PATH', plugin_dir_path( __FILE__ ) );

require_once EVBB_DIR_PATH . 'inc/block.php';