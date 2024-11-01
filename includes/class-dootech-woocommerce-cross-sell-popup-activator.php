<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.dootech.fr/
 * @since      1.0.0
 *
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/includes
 * @author     Dootech <contact@dootech.fr>
 */
class Dootech_Woocommerce_Cross_Sell_Popup_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// ACTIVATE AJAX FOR WooCommerce
		update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes', 'yes' );
	}

}
