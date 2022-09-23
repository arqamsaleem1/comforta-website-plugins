<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Woo_City
{
	private static $instance = null;
	private $woocity;
	
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Woo_City;
		}
		return self::$instance;
	}
	
	private function __construct()
	{
		$this->woocity = woocity::init();
		register_activation_hook( __FILE__, 'plugin_activation' );
		register_deactivation_hook( __FILE__, 'plugin_deactivation' );
	}
	
	//This function will create Plugin specific table in db at the time of plugin activation
	function plugin_activation(){
		global $wpdb;

		$table = $wpdb->prefix . 'woocity_cities';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  woo_city_id varchar (100) DEFAULT '' NOT NULL,
				  city varchar (800) DEFAULT '' NOT NULL,
				  province varchar(100) DEFAULT '' NOT NULL,
				  cost varchar(100) DEFAULT '' NOT NULL,
				  PRIMARY KEY  (id)
				) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
	}
	
	public static function plugin_deactivation()
	{
		global $wpdb;
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$options = get_option('woocity_delete_data');
		if ( $options == 'yes' ) {
			
			$cities_table = $wpdb->prefix . 'woocity_cities';
			
			$sql2 = "DROP TABLE IF EXISTS $cities_table";
			$wpdb->query($sql2);
			
		}
		delete_option( 'woocity_delete_data' );
	}
}