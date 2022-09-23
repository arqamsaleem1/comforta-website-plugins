<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Massindo_Store_Operations
{
	private static $instance = null;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Massindo_Store_Operations;
		}
		return self::$instance;
	}
	
	public function __construct(){
	
		add_action('wp_ajax_callback_delete_store', array( $this, 'callback_delete_store'));
		add_action('wp_ajax_nopriv_callback_delete_store',array( $this, 'callback_delete_store'));
		
		add_action('wp_ajax_callback_delete_all_stores', array( $this, 'callback_delete_all_stores'));
		add_action('wp_ajax_nopriv_callback_delete_all_stores',array( $this, 'callback_delete_all_stores'));
	}
	
	function save_store($obj) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'massindo_stores';
		
		$data = array('store'=>$obj['store'],'city'=>$obj['city'],'province'=>$obj['province'],'store_url'=>$obj['store_url'],'market_place'=>$obj['market_place'],'daerah'=>$obj['daerah'],'longitude'=>$obj['longitude'],'latitude'=>$obj['latitude']);
		
		$status = $wpdb->insert( $table_name, $data );
		return $status;

	}
	
	//Callback to Ajax for deleting a store
	function callback_delete_store(){
		$store_id = $_POST['id'];

		if(!empty($store_id)){
			$result = $this->delete_store($store_id);
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
	function delete_store($id){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'massindo_stores';
		
		$status = $wpdb->delete( $table_name, array("id"=>$id));
		return $status;
	}
	//Callback to Ajax for deleting all cities
	function callback_delete_all_stores(){

		$result = $this->delete_all_stores();
		if($result){
			echo 'deleted';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	//Function to delete all item from table
	function delete_all_stores(){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'massindo_stores';
		
		$status = $wpdb->query("TRUNCATE TABLE $table_name");
		return $status;
	}
	
	function get_store($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'massindo_stores';
		
		$data = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
		
		return $data;
	}
	
	function get_all_stores(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'massindo_stores';
		
		$data = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
		
		return $data;
	}
	
}