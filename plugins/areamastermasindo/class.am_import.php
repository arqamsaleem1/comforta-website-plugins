<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Am_Import
{
	private static $instance = null;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Am_Import;
		}
		return self::$instance;
	}
	
	public function __construct()
	{
		
	}

	public function import_province($file){

		$file_r = fopen($file, 'r');
		$first_row = fgetcsv($file_r);
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_provinces';
		
		$import_count = 0;
		while ($row = fgetcsv($file_r)) {
			
			$id = $row[0];
			$province_title = strtolower($row[1]);
			
			$get1 = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
			$get2 = $wpdb->get_row( "SELECT * FROM $table_name WHERE province_title='$province_title'", OBJECT );
			
			if (isset($get1) or isset($get2)) {
				continue;
			}
			else{
				$data = array('id'=>$id,'province_title'=>$province_title);	
				$status = $wpdb->insert( $table_name, $data );
				$import_count++;
			}

		}

		return $import_count;
	}
	
	public function import_city($file){

		$file_r = fopen($file, 'r');
		$first_row = fgetcsv($file_r);
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_cities';
		
		$import_count = 0;
		while ($row = fgetcsv($file_r)) {
			
			$id = $row[0];
			$city_title = strtolower($row[1]);
			$province_title = strtolower($row[2]);
			
			//$get1 = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
			$get2 = $wpdb->get_row( "SELECT * FROM $table_name WHERE city_title='$city_title'", OBJECT );
		
			if (!is_null($get2)) {
				continue;
			}
			else{
				$province_id = $wpdb->get_row( "SELECT * FROM wp_am_provinces WHERE province_title='$province_title'", OBJECT );
				//print_r($province_id);
				$data = array('id'=>$id,'city_title'=>$city_title,'province'=>$province_id->id,'province_title'=>$province_title);	
				$status = $wpdb->insert( $table_name, $data );
				if($status){
					$import_count++;
				}
			}

		}

		return $import_count;
	}

	public function import_postcode($file){

		$file_r = fopen($file, 'r');
		$first_row = fgetcsv($file_r);
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_postcodes';
		
		$import_count = 0;
		while ($row = fgetcsv($file_r)) {
			
			$id = $row[0];
			$postcode_title = strtolower($row[1]);
			$city_title = strtolower($row[2]);
			
			//$get1 = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
			$get2 = $wpdb->get_row( "SELECT * FROM $table_name WHERE postcode_title='$postcode_title'", OBJECT );
			
			if (!is_null($get2)) {
				continue;
			}
			else{
				$city_id = $wpdb->get_row( "SELECT * FROM wp_am_cities WHERE city_title='$city_title'", OBJECT );
				if($city_id){
					$data = array('id'=>$id,'postcode_title'=>$postcode_title,'city'=>$city_id->id);	
					$status = $wpdb->insert( $table_name, $data );
					$import_count++;
				}
			}

		}

		return $import_count;
	}
}