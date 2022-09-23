<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Massindo_Store_Import
{
	private static $instance = null;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Massindo_Store_Import;
		}
		return self::$instance;
	}
	
	public function __construct()
	{
		
	}

	public function import_stores($file){

		$file_r = fopen($file, 'r');
		$first_row = fgetcsv($file_r);
		global $wpdb;

		$table_name = $wpdb->prefix . 'massindo_stores';
		
		$import_count = 0;
		while ($row = fgetcsv($file_r)) {
			
			
			$store = strtolower($row[0]);
			$city = strtolower($row[1]);
			$province = strtolower($row[2]);
			$store_url = strtolower($row[3]);
			$market_place = strtolower($row[4]);
			$daerah = strtolower($row[5]);
			$longitude = strtolower($row[6]);
			$latitude = strtolower($row[7]);
			
			$data = array('store'=>$store,'city'=>$city,'province'=>$province,'store_url'=>$store_url,'market_place'=>$market_place,'daerah'=>$daerah,'longitude'=>$longitude,'latitude'=>$latitude);
				
			$status = $wpdb->insert( $table_name, $data );
			if($status){
				$import_count++;
			}

		}

		return $import_count;
	}

}