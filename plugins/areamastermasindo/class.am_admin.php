<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Am_Admin
{
	private static $instance = null;
	private $am;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Am_Admin;
		}
		return self::$instance;
	}
	private function __construct()
	{
		//$this->am = Am::init();
		add_action( 'admin_init' , array( $this, 'add_am_scripts' ) );
		add_action( 'admin_menu', array( $this, 'built_admin_menu' ), 2 );
	}

	public function add_am_scripts()
	{
		wp_enqueue_style( 'am_bootstrap_styles', plugins_url( 'assets/css/bootstrap.min.css', AM_PLUGIN_FILE ), array(), AM_VERSION );
		wp_enqueue_style( 'am_datatable_styles', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css', array(), AM_VERSION );
		
		wp_enqueue_style( 'am_select2-styles', "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css", array(), AM_VERSION );

		wp_enqueue_script( 'am_bootstrap',  plugins_url( 'assets/js/bootstrap.min.js', AM_PLUGIN_FILE ), array('jquery'), AM_VERSION, true);
		wp_enqueue_script( 'am_select2-script',  "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js", array('jquery'), AM_VERSION, true);
		wp_enqueue_script( 'am_datatable-script',  "https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js", array('jquery'), AM_VERSION, true);
		
		
		wp_enqueue_script( 'am_admin-script',  plugins_url( 'assets/js/am-admin-script.js', AM_PLUGIN_FILE ), array('jquery'), AM_VERSION, true);
		wp_localize_script( 'am_admin-script', 'plugin_ajax_url', array( 'ajax_url' => admin_url('admin-ajax.php')));
		
		wp_enqueue_style( 'am_admin-styles', plugins_url( 'assets/css/admin-styles.css', AM_PLUGIN_FILE ), array(), AM_VERSION );
		wp_enqueue_style( 'am_fontawesome-styles', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), AM_VERSION );
		
	}

	public function built_admin_menu()
	{
		add_menu_page( 'Master Area Massindo', 'Master Area Massindo', 'manage_options', 'am_settings', array( $this, 'setting_page' ));
		
		add_submenu_page( 'am_settings','Province Dashboard', 'Province', 'manage_options', 'am_province_dashboard', array( $this, 'province_dashboard_page' ));
		
		add_submenu_page( 'am_settings','City Dashboard', 'City', 'manage_options', 'am_city_dashboard', array( $this, 'city_dashboard_page' ));
		add_submenu_page( 'am_settings','Postcode Dashboard', 'Postcode', 'manage_options', 'am_postcode_dashboard', array( $this, 'postcode_dashboard_page' ));
		add_submenu_page( 'am_settings','Area Dashboard', 'Area', 'manage_options', 'am_Area_dashboard', array( $this, 'area_dashboard_page' ));
	}

	public function setting_page()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->am->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->am->showErrorAlert($_GET['error']);
		}
		load_template( AM_PLUGIN_DIR . 'views/plugin_page.php' );
	}
	
	public function province_dashboard_page()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->am->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->am->showErrorAlert($_GET['error']);
		}
		load_template( AM_PLUGIN_DIR . 'views/province-dashboard.php' );
	}
	public function city_dashboard_page()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->am->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->am->showErrorAlert($_GET['error']);
		}
		load_template( AM_PLUGIN_DIR . 'views/city-dashboard.php' );
	}
	public function postcode_dashboard_page()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->am->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->am->showErrorAlert($_GET['error']);
		}
		load_template( AM_PLUGIN_DIR . 'views/postcode-dashboard.php' );
	}
	public function area_dashboard_page()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->am->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->am->showErrorAlert($_GET['error']);
		}
		load_template( AM_PLUGIN_DIR . 'views/area-dashboard.php' );
	}
}