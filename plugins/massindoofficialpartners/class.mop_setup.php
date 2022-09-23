<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Mop_Setup
{
	private static $instance = null;
	private $mop;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Mop_Setup;
		}
		return self::$instance;
	}
	private function __construct()
	{
		
		add_action( 'wp_enqueue_scripts' , array( $this, 'enqueue_mop_scripts' ) );
		add_action( 'plugins_loaded', array( $this, 'mop_gateway_init' ), 0 );
	}
	function enqueue_mop_scripts(){
		wp_enqueue_style( 'mop-styles', plugins_url( 'assets/css/mop-styles.css', MOP_PLUGIN_FILE ));
	}
	// Include our Gateway Class and register Payment Gateway with WooCommerce
	function mop_gateway_init() {
		// If the parent WC_Payment_Gateway class doesn't exist
		// it means WooCommerce is not installed on the site
		// so do nothing
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
		
		// If we made it this far, then include our Gateway Class
		require_once( 'class.mop_official_partner_gateway.php' );

		// Now that we have successfully included our class,
		// Lets add it too WooCommerce
		add_filter( 'woocommerce_payment_gateways', 'add_mop_Official_Partners' );
		function add_mop_Official_Partners( $methods ) {
			$methods[] = 'mop_Official_Partners';
			return $methods;
		}
		
	}
}