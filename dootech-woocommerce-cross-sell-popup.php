<?php

/**
 * @link              https://www.dootech.fr/
 * @since             1.0.0
 * @package           Dootech_Woocommerce_Cross_Sell_Popup
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Cross-sell Popup
 * Plugin URI:        https://www.dootech.fr/blog/augmentez-votre-chiffre-daffaire-avec-le-plugin-woocommerce-cross-sell-popup/
 * Description:       WooCommerce Cross-sell Popup allow to show combo, packs or product group with lower price that customer can buy when he add new product to the cart to increase revenues.
 * Version:           1.0.0
 * Author:            Dootech
 * Author URI:        https://www.dootech.fr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dt-woocommerce-cross-sell-popup
 * Domain Path:       /languages
 * WC tested up to: 3.5.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DOOTECH_WC_CS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dootech-woocommerce-cross-sell-popup-activator.php
 */
function activate_Dootech_Woocommerce_cross_sell_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dootech-woocommerce-cross-sell-popup-activator.php';
	Dootech_Woocommerce_Cross_Sell_Popup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dootech-woocommerce-cross-sell-popup-deactivator.php
 */
function deactivate_Dootech_Woocommerce_cross_sell_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dootech-woocommerce-cross-sell-popup-deactivator.php';
	Dootech_Woocommerce_Cross_Sell_Popup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Dootech_Woocommerce_cross_sell_popup' );
register_deactivation_hook( __FILE__, 'deactivate_Dootech_Woocommerce_cross_sell_popup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dootech-woocommerce-cross-sell-popup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Dootech_Woocommerce_cross_sell_popup() {

	$plugin = new Dootech_Woocommerce_Cross_Sell_Popup();
	$plugin->run();

}
run_Dootech_Woocommerce_cross_sell_popup();
