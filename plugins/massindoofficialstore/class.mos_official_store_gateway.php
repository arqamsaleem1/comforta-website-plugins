<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* The class itself, please note that it is inside plugins_loaded action hook
*/
class MOS_Official_Store extends WC_Payment_Gateway
{
	
	// Setup our Gateway's id, description and other values
	function __construct() {
		
		// The global ID for this Payment method
		$this->id = "mos_massindo_official_store";

		// The Title shown on the top of the Payment Gateways Page next to all the other Payment Gateways
		$this->method_title = __( "Massindo Official Store", 'massindoofficialstore' );

		// The description for this Payment Gateway, shown on the actual Payment options page on the backend
		$this->method_description = __( "Massindo Official Store Plug-in for WooCommerce", 'massindoofficialstore' );

		// The title to be used for the vertical tabs that can be ordered top to bottom
		$this->title = __( "Massindo Official Store", 'massindoofficialstore' );

		// If you want to show an image next to the gateway's name on the frontend, enter a URL to an image.
		$this->icon = null;

		// Bool. Can be set to true if you want payment fields to show on the checkout 
		// if doing a direct integration, which we are doing in this case
		$this->has_fields = false;

		// Supports the default credit card form
		//$this->supports = array( 'default_credit_card_form' );

		// This basically defines your settings which are then loaded with init_settings()
		$this->init_form_fields();

		// After init_settings() is called, you can get the settings and load them into variables, e.g:
		// $this->title = $this->get_option( 'title' );
		$this->init_settings();
		
		// Turn these settings into variables we can use
		foreach ( $this->settings as $setting_key => $value ) {
			$this->$setting_key = $value;
		}
		
		// Lets check for SSL
		add_action( 'admin_notices', array( $this,	'do_ssl_check' ) );
		
		// Save settings
		if ( is_admin() ) {
			// Versions over 2.0
			// Save our administration options. Since we are not going to be doing anything special
			// we have not defined 'process_admin_options' in this class so the method in the parent
			// class will be used instead
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		}		
	} // End __construct()

	/**
	 * Plugin options, we deal with it in Step 3 too
	 */
	public function init_form_fields(){

		$this->form_fields = array(
			'enabled' => array(
				'title' => __( 'Enable/Disable', 'woocommerce' ),
				'type' => 'checkbox',
				'label' => __( 'Massindo Official Store', 'woocommerce' ),
				'default' => 'yes'
			),
			'title' => array(
				'title' => __( 'Title', 'woocommerce' ),
				'type' => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
				'default' => __( 'Massindo Official Store', 'woocommerce' ),
				'desc_tip'      => true,
			),
			'description' => array(
				'title'       => __( 'Description', 'woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
				'default'     => '',
				'desc_tip'    => true,
			),

			'instructions' => array(
				'title'       => __( 'Instructions', 'woocommerce' ),
				'type'        => 'textarea',
				'description' => __( 'Instructions that will be added to the thank you page and emails.', 'woocommerce' ),
				'default'     => '',
				'desc_tip'    => true,
			),
		);

	}
	public function process_payment( $order_id ) {

		global $woocommerce;
		session_start();
		$order = new WC_Order( $order_id );

		// Mark as on-hold (we're awaiting the cheque)
		$order->update_status('on-hold', __( 'Awaiting payment', 'woocommerce' )); 
		$first_product_id = array_shift(WC()->cart->get_cart())['product_id'];
		
		
		// Remove cart
		$woocommerce->cart->empty_cart();
		
		// Return thankyou redirect
		return array(
			'result' => 'success',
			'redirect' => "https://shop.comforta.co.id/success-order-os/"
			//'redirect' => "http://localhost/comfortashop/success-order-os/"
		);

	}
	
}