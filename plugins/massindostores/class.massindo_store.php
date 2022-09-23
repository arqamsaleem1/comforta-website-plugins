<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Massindo_Store
{
	private static $instance = null;
	private $massindo_store;
	
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Massindo_Store;
		}
		return self::$instance;
	}
	
	private function __construct()
	{
		$this->massindo_store = massindo_store::init();
		register_activation_hook( __FILE__, 'plugin_activation' );
		register_deactivation_hook( __FILE__, 'plugin_deactivation' );
	}
	
	//This function will create Plugin specific table in db at the time of plugin activation
	function plugin_activation(){
		global $wpdb;

		$table = $wpdb->prefix . 'massindo_stores';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  store varchar (500) DEFAULT '' NOT NULL,
				  city varchar (100) DEFAULT '' NOT NULL,
				  province varchar(100) DEFAULT '' NOT NULL,
				  store_url varchar (800) DEFAULT '' NOT NULL,
				  market_place varchar (500) DEFAULT '' NOT NULL,
				  daerah varchar (100) DEFAULT '',
				  longitude varchar (100) DEFAULT '',
				  latitude varchar (100) DEFAULT '',
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
		/* $options = get_option('woocity_delete_data');
		if ( $options == 'yes' ) {
			
			$massindo_stores_table = $wpdb->prefix . 'massindo_stores';
			
			$sql2 = "DROP TABLE IF EXISTS $massindo_stores_table";
			$wpdb->query($sql2);
			
		}
		delete_option( 'massindo_store_delete_data' ); */
	}
}