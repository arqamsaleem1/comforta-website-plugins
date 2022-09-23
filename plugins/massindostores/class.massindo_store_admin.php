<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Massindo_Store_Admin
{
	private static $instance = null;
	private $massindo_store_admin;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Massindo_Store_Admin;
		}
		return self::$instance;
	}
	private function __construct()
	{
		add_action( 'admin_menu', array( $this, 'built_admin_menu' ));
		add_action( 'admin_enqueue_scripts' , array( $this, 'add_massindo_store_scripts' ),10 );
	}

	public function built_admin_menu()
	{	
		
		add_submenu_page( 'woocommerce','Massindo Official Marketplace', 'Massindo Official Marketplace', 'manage_options', 'massindo_store_dashboard', array( $this, 'massindo_store_settings' ));
		
	}
	
	public function add_massindo_store_scripts($hook)
	{	
		
		if ( $hook == 'woocommerce_page_massindo_store_dashboard'){
			wp_enqueue_style( 'massindo_store_bootstrap_styles', plugins_url( 'assets/css/bootstrap.min.css', MST_PLUGIN_FILE ), array(), MST_VERSION );
			
			wp_enqueue_style( 'massindo_store_datatable_styles', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css', array(), MST_VERSION );
			
			

			wp_enqueue_script( 'massindo_store_bootstrap',  plugins_url( 'assets/js/bootstrap.min.js', MST_PLUGIN_FILE ), array('jquery'), MST_VERSION, true);
			
		}
		wp_enqueue_script( 'massindo_store_datatable_script',  "https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js", array('jquery'), MST_VERSION, true);
		wp_enqueue_script( 'massindo_store_admin_script',  plugins_url( 'assets/js/mst-script.js', MST_PLUGIN_FILE ), array('jquery'), MST_VERSION, true);
		wp_localize_script( 'massindo-store_admin-script', 'plugin_ajax_url', array( 'ajax_url' => admin_url('admin-ajax.php')));
		
		wp_enqueue_style( 'massindo_store_admin-styles', plugins_url( 'assets/css/admin-styles.css', MST_PLUGIN_FILE ), array(), MST_VERSION );
		wp_enqueue_style( 'massindo_store_fontawesome-styles', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), MST_VERSION );
		
	}
	public function massindo_store_settings()
	{
		if ( isset($_GET['success']) && $_GET['success'] != '' ) {
			$this->massindo_store->showSuccessAlert($_GET['success']);
		}
		if ( isset($_GET['error']) && $_GET['error'] != '' ) {
			$this->massindo_store->showErrorAlert($_GET['error']);
		}
		load_template( MST_PLUGIN_DIR . 'views/massindo_store_page.php' );
	}
	
}