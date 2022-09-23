<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Woocity_Import
{
	private static $instance = null;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Woocity_Import;
		}
		return self::$instance;
	}
	
	public function __construct()
	{
		
	}

	public function import_city($file){

		$file_r = fopen($file, 'r');
		$first_row = fgetcsv($file_r);
		global $wpdb;

		$table_name = $wpdb->prefix . 'woocity_cities';
		
		$import_count = 0;
		while ($row = fgetcsv($file_r)) {
			
			
			$woo_city_id = strtolower($row[0]);
			$city = strtolower($row[0]);
			$province = strtolower($row[1]);
			$cost = strtolower($row[2]);
			
			$data = array('woo_city_id'=>$woo_city_id,'city'=>$city,'province'=>$province,'cost'=>$cost);	
			$status = $wpdb->insert( $table_name, $data );
			if($status){
				$import_count++;
			}

		}

		return $import_count;
	}

}