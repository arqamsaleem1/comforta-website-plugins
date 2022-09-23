<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Mos_Setup
{
	private static $instance = null;
	private $mos;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Mos_Setup;
		}
		return self::$instance;
	}
	private function __construct()
	{
		
		add_action( 'wp_enqueue_scripts' , array( $this, 'enqueue_mos_scripts' ) );
		add_action( 'plugins_loaded', array( $this, 'mos_gateway_init' ), 0 );
	}
	function enqueue_mos_scripts(){
		wp_enqueue_style( 'mos-styles', plugins_url( 'assets/css/mos-styles.css', MOS_PLUGIN_FILE ));
	}
	// Include our Gateway Class and register Payment Gateway with WooCommerce
	function mos_gateway_init() {
		// If the parent WC_Payment_Gateway class doesn't exist
		// it means WooCommerce is not installed on the site
		// so do nothing
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
		
		// If we made it this far, then include our Gateway Class
		require_once( 'class.mos_official_store_gateway.php' );

		// Now that we have successfully included our class,
		// Lets add it too WooCommerce
		add_filter( 'woocommerce_payment_gateways', 'add_mos_Official_Store' );
		function add_mos_Official_Store( $methods ) {
			$methods[] = 'mos_Official_store';
			return $methods;
		}
		
	}
}