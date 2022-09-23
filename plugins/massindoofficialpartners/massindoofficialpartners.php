<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Massindo Fair Pay Later
 *
 * @package     PluginPackage
 * @author      
 * @copyright   2020
 * @license     GPL-3.0
 *
 * @wordpress-plugin
 * Plugin Name: Massindo Official Partners
 * Plugin URI:  www.dns.co.id
 * Description: Massindo Ecommerce Pack is designed to accomodate number of requirements for Massindo's brand ecommerce site. This pack contains various plugins from the store management to payment management solution.
 * Developed by: PT. Digital Niaga Solusindo (DNS)
 * Version:     1.0.0
 * Project Manager: Riman Budiman
 * Project Coordinator: Tameem Ahmad
 * Author: Arqam Saleem | Project Manager: Riman Budiman
 * Author URI:  
 * Text Domain: massindofairpaylater
 * License:     GPL-3.0+
 */

define( 'MOP_VERSION',		'1.0.0' );
define( 'MOP_PLUGIN_DIR',	plugin_dir_path( __FILE__ ) );
define( 'MOP_PLUGIN_FILE',	__FILE__ );

require_once( MOP_PLUGIN_DIR . 'class.mop_setup.php' );
Mop_Setup::init();