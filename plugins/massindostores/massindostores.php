<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Massindo Official Marketplace
 *
 * @package     PluginPackage
 * @author      
 * @copyright   2020
 * @license     GPL-3.0
 *
 * @wordpress-plugin
 * Plugin Name: Massindo Official Marketplace
 * Plugin URI:  www.dns.co.id
 * Description: Massindo Ecommerce Pack is designed to accomodate number of requirements for Massindo's brand ecommerce site. This pack contains various plugins from the store management to payment management solution.
 * Version:     1.0.0
 * Author: Arqam Saleem | Project Manager: Riman Budiman
 * Author URI:  
 * Text Domain: massindostores
 * License:     GPL-3.0+
 */

define( 'MST_VERSION',		'1.0.0' );
define( 'MST_PLUGIN_DIR',	plugin_dir_path( __FILE__ ) );
define( 'MST_PLUGIN_FILE',	__FILE__ );

require_once( MST_PLUGIN_DIR . 'class.massindo_store.php' );
if ( is_admin() ) {
	require_once( MST_PLUGIN_DIR . 'class.massindo_store_admin.php' );
	massindo_store_admin::init();
}
require_once( MST_PLUGIN_DIR . 'class.massindo_store_import.php' );
require_once( MST_PLUGIN_DIR . 'class.massindo_store_operations.php' );

register_activation_hook( __FILE__, array( 'Massindo_Store', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Massindo_Store', 'plugin_deactivation' ) );
add_action( 'init', array( 'Massindo_Store_Operations', 'init' ) );