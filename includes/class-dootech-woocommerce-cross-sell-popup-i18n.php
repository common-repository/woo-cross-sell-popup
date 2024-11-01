<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.dootech.fr/
 * @since      1.0.0
 *
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/includes
 * @author     Dootech <contact@dootech.fr>
 */
class Dootech_Woocommerce_Cross_Sell_Popup_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dootech-wccs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
