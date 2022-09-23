<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Am_Operations
{
	private static $instance = null;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Am_Operations;
		}
		return self::$instance;
	}
	
	public function __construct()
	{
		
		add_action('wp_ajax_callback_delete_province', array( $this, 'callback_delete_province'));
		add_action('wp_ajax_nopriv_callback_delete_province',array( $this, 'callback_delete_province'));
		
		add_action('wp_ajax_callback_delete_all_provinces', array( $this, 'callback_delete_all_provinces'));
		add_action('wp_ajax_nopriv_callback_delete_all_provinces',array( $this, 'callback_delete_all_provinces'));
		
		add_action('wp_ajax_callback_delete_city', array( $this, 'callback_delete_city'));
		add_action('wp_ajax_nopriv_callback_delete_city',array( $this, 'callback_delete_city'));
		
		add_action('wp_ajax_callback_delete_all_cities', array( $this, 'callback_delete_all_cities'));
		add_action('wp_ajax_nopriv_callback_delete_all_cities',array( $this, 'callback_delete_all_cities'));
		
		add_action('wp_ajax_callback_get_all_cities_for_area', array( $this, 'callback_get_all_cities_for_area'));
		add_action('wp_ajax_nopriv_callback_get_all_cities_for_area',array( $this, 'callback_get_all_cities_for_area'));
		
		add_action('wp_ajax_callback_delete_area', array( $this, 'callback_delete_area'));
		add_action('wp_ajax_nopriv_callback_delete_area',array( $this, 'callback_delete_area'));
		
		add_action('wp_ajax_callback_delete_all_areas', array( $this, 'callback_delete_all_areas'));
		add_action('wp_ajax_nopriv_callback_delete_all_areas',array( $this, 'callback_delete_all_areas'));
		
		add_action('wp_ajax_callback_enable_area', array( $this, 'callback_enable_area'));
		add_action('wp_ajax_nopriv_callback_enable_area',array( $this, 'callback_enable_area'));
		
		add_action('wp_ajax_callback_disable_area', array( $this, 'callback_disable_area'));
		add_action('wp_ajax_nopriv_callback_disable_area',array( $this, 'callback_disable_area'));
		
		add_action('wp_ajax_callback_delete_postcode', array( $this, 'callback_delete_postcode'));
		add_action('wp_ajax_nopriv_callback_delete_postcode',array( $this, 'callback_delete_postcode'));
		
		add_action('wp_ajax_callback_delete_all_postcodes', array( $this, 'callback_delete_all_postcodes'));
		add_action('wp_ajax_nopriv_callback_delete_all_postcodes',array( $this, 'callback_delete_all_postcodes'));
	}
	
	
	
	function save_area($obj) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_areas';
		
		
		$data = array('area_title'=>$obj['area_title'],'cities'=>$obj['cities'],'status'=>true);
		
		$status = $wpdb->insert( $table_name, $data );
		return $status;

	}
	function save_city($obj) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_cities';
		
		
		$data = array('city_title'=>$obj['city_title'],'province'=>$obj['province'],'province_title'=>$obj['province_title']);
		
		$status = $wpdb->insert( $table_name, $data );
		return $status;

	}
	function save_province($province_title) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_provinces';
		
		$data = array('province_title'=>$province_title);
		
		$status = $wpdb->insert( $table_name, $data );
		return $status;

	}
	function save_postcode($obj) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_postcodes';
		 
		$data = array('postcode_title'=>$obj['postcode_title'],'city'=>$obj['city']);
		
		$status = $wpdb->insert( $table_name, $data );
		return $status;

	}
	
	//Callback to Ajax for deleting an area
	function callback_delete_area(){
		$area_id = $_POST['id'];

		if(!empty($area_id)){
			$result = $this->delete_area($area_id);
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
	function delete_area($id){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'am_areas';
		
		$status = $wpdb->delete( $table_name, array("id"=>$id));
		return $status;
	}
	//Callback to Ajax for deleting all cities
	function callback_delete_all_areas(){

		$result = $this->delete_all_areas();
		if($result){
			echo 'deleted';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	//Function to delete all item from table
	function delete_all_areas(){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'am_areas';
		
		$status = $wpdb->query("TRUNCATE TABLE $table_name");
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
		$table_name = $wpdb->prefix . 'am_cities';
		
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
		$table_name = $wpdb->prefix . 'am_cities';
		
		$status = $wpdb->query("TRUNCATE TABLE $table_name");
		return $status;
	}
	//Callback to Ajax for deleting a province
	function callback_delete_province(){
		$province_id = $_POST['id'];

		if(!empty($province_id)){
			$result = $this->delete_province($province_id);
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
	function delete_province($id){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'am_provinces';
		
		$status = $wpdb->delete( $table_name, array("id"=>$id));
		return $status;
	}
	//Callback to Ajax for deleting all province
	function callback_delete_all_provinces(){

		$result = $this->delete_all_provinces();
		if($result){
			echo 'deleted';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	//Function to delete all item from table
	function delete_all_provinces(){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'am_provinces';
		
		$status = $wpdb->query("TRUNCATE TABLE $table_name");
		return $status;
	}
	//Callback to Ajax for deleting a Postcode
	function callback_delete_postcode(){
		$postcode_id = $_POST['id'];

		if(!empty($postcode_id)){
			$result = $this->delete_postcode($postcode_id);
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
	function delete_postcode($id){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'am_postcodes';
		
		$status = $wpdb->delete( $table_name, array("id"=>$id));
		return $status;
	}
	//Callback to Ajax for deleting all postcodes
	function callback_delete_all_postcodes(){

		$result = $this->delete_all_postcodes();
		if($result){
			echo 'deleted';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	//Function to delete all item from table
	function delete_all_postcodes(){
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'am_postcodes';
		
		$status = $wpdb->query("TRUNCATE TABLE $table_name");
		return $status;
	}
	function get_area($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_areas';
		
		$data = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
		
		return $data;
	}
	function get_all_areas(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_areas';
		
		$data = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
		
		return $data;
	}
	function get_area_status($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_areas';
		
		$data = $wpdb->get_row( "SELECT status FROM $table_name WHERE id=$id", OBJECT );
		
		return $data;
	}
	//Callback to Ajax for enabling an area
	function callback_enable_area(){
		$area_id = $_POST['id'];

		if(!empty($area_id)){
			$result = $this->enable_area_status($area_id);
		}
		if($result){
			echo 'enabled';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	function enable_area_status($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_areas';
		
		$data = $wpdb->update($table_name, array('status'=>true), array('id'=>$id));
		
		return $data;
	}
	
	//Callback to Ajax for disabling an area
	function callback_disable_area(){
		$area_id = $_POST['id'];

		if(!empty($area_id)){
			$result = $this->disable_area_status($area_id);
		}
		if($result){
			echo 'disabled';
		}
		else{
			echo 'invalid';
		}
		die();
	}
	function disable_area_status($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_areas';
		
		$data = $wpdb->update($table_name, array('status'=>false), array('id'=>$id));
		
		return $data;
	}
	
	function get_city($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_cities';
		
		$data = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
		
		return $data;
	}
	//Callback for Ajax to pick all cities on Area page and Postcode page 
	function callback_get_all_cities_for_area(){
		

		$result = $this->get_all_cities();
		
		if($result){
			echo json_encode($result);
		}
		else{
			echo 'invalid';
		}
		die();
	}
	function get_all_cities(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_cities';
		
		$data = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
		
		return $data;
	}
	function update_areas_in_cities($cities, $area_title){
		
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_cities';
		foreach($cities as $city){
			$area_id = $wpdb->get_row( "SELECT * FROM wp_am_areas WHERE area_title = '$area_title'", OBJECT );
			
			$data = $wpdb->update($table_name, array('area_id'=>$area_id->id, 'area_title'=>$area_title), array('id'=>$city));
		}
		
		return $data;
	}
	function get_province($id){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_provinces';
		
		$data = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$id", OBJECT );
		
		return $data;
	}
	function get_all_provinces(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_provinces';
		
		$data = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
		
		return $data;
	}
	function get_all_postcodes(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'am_postcodes';
		
		$data = $wpdb->get_results( "SELECT * FROM $table_name", OBJECT );
		
		return $data;
	}
}