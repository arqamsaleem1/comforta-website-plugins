<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Woocity_Operations
{
	private static $instance = null;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Woocity_Operations;
		}
		return self::$instance;
	}
	
	public function __construct(){
	
		add_action('wp_ajax_callback_delete_city', array( $this, 'callback_delete_city'));
		add_action('wp_ajax_nopriv_callback_delete_city',array( $this, 'callback_delete_city'));
		
		add_action('wp_ajax_callback_delete_all_cities', array( $this, 'callback_delete_all_cities'));
		add_action('wp_ajax_nopriv_callback_delete_all_cities',array( $this, 'callback_delete_all_cities'));
	}
	
	function save_city($obj) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'woocity_cities';
		
		
		$data = array('woo_city_id'=>$obj['woo_city_id'],'city'=>$obj['city'],'province'=>$obj['province'],'cost'=>$obj['cost']);
		
		$status = $wpdb->insert( $table_name, $data );
		return $status;

	}
	
	//Callback to Ajax for deleting a city
	function callback_delete_city(){
		$city_id = $_POST['id'];

		if(!empty($city_id)){
			$result = $this->delete_city($city_id);
		}
		if($result){
			echo 'deleted';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	//Function to delete a specific item from table
	function delete_city($id){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'woocity_cities';
		
		$status = $wpdb->delete( $table_name, array("id"=>$id));
		return $status;
	}
	//Callback to Ajax for deleting all cities
	function callback_delete_all_cities(){

		$result = $this->delete_all_cities();
		if($result){
			echo 'deleted';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	//Function to delete all item from table
	function delete_all_cities(){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'woocity_cities';
		
		$status = $wpdb->query("TRUNCATE TABLE $table_name");
		return $status;
	}
	
	function get_city($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'woocity_cities';
		
		$data = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
		
		return $data;
	}
	
	function get_all_cities(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'woocity_cities';
		
		$data = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
		
		return $data;
	}
	
	
}