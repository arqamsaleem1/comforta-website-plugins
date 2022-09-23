<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Woo City Massindo
 *
 * @package     PluginPackage
 * @author      
 * @copyright   2020
 * @license     GPL-3.0
 *
 * @wordpress-plugin
 * Plugin Name: Woo City Massindo
 * Plugin URI:  www.dns.co.id
 * Description: Massindo Ecommerce Pack is designed to accomodate number of requirements for Massindo's brand ecommerce site. This pack contains various plugins from the store management to payment management solution.
 * Version:     1.0.0
 * Author: Arqam Saleem | Project Manager: Riman Budiman
 * Author URI:  
 * Text Domain: woocity
 * License:     GPL-3.0+
 */

define( 'WOOCITY_VERSION',		'1.0.0' );
define( 'WOOCITY_PLUGIN_DIR',	plugin_dir_path( __FILE__ ) );
define( 'WOOCITY_PLUGIN_FILE',	__FILE__ );

require_once( WOOCITY_PLUGIN_DIR . 'class.woo_city.php' );
if ( is_admin() ) {
	require_once( WOOCITY_PLUGIN_DIR . 'class.woocity_admin.php' );
	woocity_admin::init();
}
require_once( WOOCITY_PLUGIN_DIR . 'class.woocity_import.php' );
require_once( WOOCITY_PLUGIN_DIR . 'class.woocity_operations.php' );

register_activation_hook( __FILE__, array( 'Woo_City', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Woo_City', 'plugin_deactivation' ) );
add_action( 'init', array( 'Woocity_Operations', 'init' ) );