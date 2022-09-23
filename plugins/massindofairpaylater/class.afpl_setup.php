<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* 
*/
class Afpl_Setup
{
	private static $instance = null;
	private $afpl;
	static function init()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new Afpl_Setup;
		}
		return self::$instance;
	}
	private function __construct()
	{
		//$this->am = Am::init();
		add_action( 'wp_enqueue_scripts' , array( $this, 'enqueue_afpl_scripts' ) );
		add_action( 'plugins_loaded', array( $this, 'afpl_gateway_init' ), 0 );
	}
	function enqueue_afpl_scripts(){
		wp_enqueue_style( 'afpl-styles', plugins_url( 'assets/css/afpl-styles.css', AFPL_PLUGIN_FILE ));
	}
	// Include our Gateway Class and register Payment Gateway with WooCommerce
	function afpl_gateway_init() {
		// If the parent WC_Payment_Gateway class doesn't exist
		// it means WooCommerce is not installed on the site
		// so do nothing
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
		
		// If we made it this far, then include our Gateway Class
		require_once( 'class.afpl_paylater_gateway.php' );

		// Now that we have successfully included our class,
		// Lets add it too WooCommerce
		add_filter( 'woocommerce_payment_gateways', 'add_Afpl_Paylater_Gateway' );
		function add_Afpl_Paylater_Gateway( $methods ) {
			$methods[] = 'Afpl_Paylater_Gateway';
			return $methods;
		}
		
	}
}