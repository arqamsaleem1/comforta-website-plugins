<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Master_Area
{
	private static $instance = null;
	private $am;
	
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Master_Area;
		}
		return self::$instance;
	}
	
	private function __construct()
	{
		$this->am = Am::init();
		register_activation_hook( __FILE__, 'plugin_activation' );
		register_deactivation_hook( __FILE__, 'plugin_deactivation' );
	}
	
	//This function will create Plugin specific table in db at the time of plugin activation
	public function plugin_activation(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_areas';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  area_title varchar (100) DEFAULT '' NOT NULL,
				  cities text DEFAULT '' NOT NULL,
				  status BOOLEAN DEFAULT 1 NOT NULL,
				  PRIMARY KEY  (id)
				) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		$table_name = $wpdb->prefix . 'am_cities';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  city_title varchar (100) DEFAULT '' NOT NULL,
				  province varchar(30) DEFAULT '' NOT NULL,
				  province_title varchar(100) DEFAULT '' NOT NULL,
				  area_id mediumint(9) DEFAULT null,
				  area_title varchar (100) DEFAULT null,
				  PRIMARY KEY  (id)
				) $charset_collate;";
		
		dbDelta( $sql );
		
		$table_name = $wpdb->prefix . 'am_provinces';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  province_title varchar (100) DEFAULT '' NOT NULL,
				  PRIMARY KEY  (id)
				) $charset_collate;";
		dbDelta( $sql );
		
		$table_name = $wpdb->prefix . 'am_postcodes';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  postcode_title varchar (100) DEFAULT '' NOT NULL,
				  city varchar (100) DEFAULT '' NOT NULL,
				  PRIMARY KEY  (id)
				) $charset_collate;";
		dbDelta( $sql );
	}
	


	public static function plugin_deactivation()
	{
		global $wpdb;
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$options = get_option('am_delete_data');
		if ( $options == 'yes' ) {
			
			$areas_table_name = $wpdb->prefix . 'am_areas';
			$cities_table_name = $wpdb->prefix . 'am_cities';
			$provinces_table_name = $wpdb->prefix . 'am_provinces';
			$postcodes_table_name = $wpdb->prefix . 'am_postcodes';
			
			$sql = "DROP TABLE IF EXISTS $areas_table_name";
			$wpdb->query($sql);
			$sql2 = "DROP TABLE IF EXISTS $cities_table_name";
			$wpdb->query($sql2);
			
			$sql = "DROP TABLE IF EXISTS $provinces_table_name";
			$wpdb->query($sql);
			$sql2 = "DROP TABLE IF EXISTS $postcodes_table_name";
			$wpdb->query($sql2);
		}
		delete_option( 'am_delete_data' );
	}
}