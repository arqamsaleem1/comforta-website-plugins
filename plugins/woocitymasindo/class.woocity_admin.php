<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Woocity_Admin
{
	private static $instance = null;
	private $woocity;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Woocity_Admin;
		}
		return self::$instance;
	}
	private function __construct()
	{
		add_action( 'admin_menu', array( $this, 'built_admin_menu' ));
		add_action( 'admin_enqueue_scripts' , array( $this, 'add_woocity_scripts' ),10 );
	}

	public function built_admin_menu()
	{	
		
		add_menu_page( 'Woo City Massindo', 'Woo City Massindo', 'manage_options', 'woocity_settings', array( $this, 'setting_page' ));
		
		add_submenu_page( 'woocity_settings','City Dashboard', 'City', 'manage_options', 'woocity_city_dashboard', array( $this, 'city_dashboard_page' ));
		
	}
	
	public function add_woocity_scripts($hook)
	{	
		
		if ( $hook == 'woo-city-massindo_page_woocity_city_dashboard' or $hook == 'toplevel_page_woocity_settings' ){
			wp_enqueue_style( 'woocity_bootstrap_styles', plugins_url( 'assets/css/bootstrap.min.css', WOOCITY_PLUGIN_FILE ), array(), WOOCITY_VERSION );
			
			wp_enqueue_style( 'woocity_datatable_styles', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css', array(), WOOCITY_VERSION );
			
			

			wp_enqueue_script( 'woocity_bootstrap',  plugins_url( 'assets/js/bootstrap.min.js', WOOCITY_PLUGIN_FILE ), array('jquery'), WOOCITY_VERSION, true);
			
		}
		wp_enqueue_script( 'woocity_datatable-script',  "https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js", array('jquery'), WOOCITY_VERSION, true);
		wp_enqueue_script( 'woocity_admin-script',  plugins_url( 'assets/js/woocity-admin-script.js', WOOCITY_PLUGIN_FILE ), array('jquery'), WOOCITY_VERSION, true);
		wp_localize_script( 'woocity_admin-script', 'plugin_ajax_url', array( 'ajax_url' => admin_url('admin-ajax.php')));
		
		wp_enqueue_style( 'woocity_admin-styles', plugins_url( 'assets/css/admin-styles.css', WOOCITY_PLUGIN_FILE ), array(), WOOCITY_VERSION );
		wp_enqueue_style( 'woocity_fontawesome-styles', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), WOOCITY_VERSION );
		
	}
	public function setting_page()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->woocity->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->woocity->showErrorAlert($_GET['error']);
		}
		load_template( WOOCITY_PLUGIN_DIR . 'views/plugin_page.php' );
	}
	
	public function city_dashboard_page()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->woocity->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->woocity->showErrorAlert($_GET['error']);
		}
		load_template( WOOCITY_PLUGIN_DIR . 'views/city-dashboard.php' );
	}
	
}