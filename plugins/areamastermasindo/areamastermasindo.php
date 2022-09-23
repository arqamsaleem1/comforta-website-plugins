<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Area Master
 *
 * @package     PluginPackage
 * @author      
 * @copyright   2020
 * @license     GPL-3.0
 *
 * @wordpress-plugin
 * Plugin Name: Master Area Massindo
 * Plugin URI:  www.dns.co.id
 * Description: Massindo Ecommerce Pack is designed to accomodate number of requirements for Massindo's brand ecommerce site. This pack contains various plugins from the store management to payment management solution.
 * Version:     1.0.0
 * Author: Arqam Saleem | Project Manager: Riman Budiman
 * Author URI:  
 * Text Domain: areamaster 
 * License:     GPL-3.0+
 */

define( 'AM_VERSION',		'1.0.0' );
define( 'AM_PLUGIN_DIR',	plugin_dir_path( __FILE__ ) );
define( 'AM_PLUGIN_FILE',	__FILE__ );

require_once( AM_PLUGIN_DIR . 'class.master_area.php' );
if ( is_admin() ) {
	require_once( AM_PLUGIN_DIR . 'class.am_admin.php' );
	am_admin::init();
}
require_once( AM_PLUGIN_DIR . 'class.am_import.php' );
require_once( AM_PLUGIN_DIR . 'class.am_operations.php' );

register_activation_hook( __FILE__, array( 'Master_Area', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Master_Area', 'plugin_deactivation' ) );
add_action( 'init', array( 'Am_Operations', 'init' ) );