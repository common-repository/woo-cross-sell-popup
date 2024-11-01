<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.dootech.fr/
 * @since      1.0.0
 *
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/public
 * @author     Dootech <contact@dootech.fr>
 */
class Dootech_Woocommerce_Cross_Sell_Popup_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $localizeFrontend;

	private $enable_params;
	private $enable_crosssell;
	private $enable_on_mobile;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $enable_params ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->enable_params = $enable_params;
		$this->enable_crosssell = $enable_params['enable_crosssell'];
		$this->enable_on_mobile = $enable_params['enable_on_mobile'];

		//MAIN FUNCTION FOR THE POPUP
		if ( esc_attr( get_option( $this->plugin_name.$this->enable_crosssell)) == 'Yes' ) {
			if( esc_attr( get_option( $this->plugin_name.$this->enable_on_mobile)) == 'No' ){
				//if in option hide on mobile dont show the main popup function
				if ( !wp_is_mobile() ) {
					add_action( 'wp_enqueue_scripts', array( $this, 'dootech_display_crosssell_popup_in_front_js' ) );
					add_action('wp_footer', array( $this, 'dootech_display_crosssell_popup_in_front' ) );
				}
			} else {
				add_action( 'wp_enqueue_scripts', array( $this, 'dootech_display_crosssell_popup_in_front_js' ) );
				add_action('wp_footer', array( $this, 'dootech_display_crosssell_popup_in_front' ) );
			}
		}
	}

	/**
	 * Display crosssell on single product page
	 */
	public function dootech_display_crosssell_popup_in_front_js(){

		// remove cross sell display from cart page
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

		wp_enqueue_style( $this->plugin_name."css", plugin_dir_url( __FILE__ ) . 'css/dootech-woocommerce-cross-sell-popup-public.css', array(), $this->version, 'all' );

		wp_enqueue_script('jquery');

		wp_enqueue_script( $this->plugin_name."js", plugin_dir_url( __FILE__ ) . 'js/dootech-woocommerce-cross-sell-popup-public.js?v='. rand (0,99999999999999999), array( 'jquery' ), $this->version, true );

	}

	/**
	 * Display cross sells
	 */
	public function dootech_display_crosssell_popup_in_front() {

		/*Get data form submition*/
		$product_id   = filter_input( INPUT_POST, 'add-to-cart', FILTER_SANITIZE_NUMBER_INT );
		$quantity     = filter_input( INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT );
		$variation_id = filter_input( INPUT_POST, 'variation_id', FILTER_SANITIZE_NUMBER_INT );

		$check_variation = 0;
		if ( $variation_id ) {
			$product_id      = $variation_id;
			$check_variation = 1;
		}

		if ( is_product() ) {
			if ( $product_id && $quantity ) {
				global $product;

				$cross_sells = is_callable( array( $product, 'get_cross_sell_ids' ) ) ? $product->get_cross_sell_ids() : null;
				// bail if the product has no upsells before we output anything
				if ( empty( $cross_sells ) ) {
					return;
				}

				if ( $cross_sells ) :
					?>
					<section id="popup1" class="cross-sells crosssells products dt-overlay" style="display: block;">
						<div class="dt-cross-sell-popup">
							<?php
							if ($product) {

								?>
								<div class="cross-sells-added">
									<h4><?php echo __( 'You just added:', 'dootech-wccs' ); ?> </h4>
									<?php
									echo "<div class='cross-sells-added-thumb'>" . woocommerce_get_product_thumbnail( 'thumbnail' ) . "</div>";
									echo "<div class='cross-sells-added-title'>" . $product->get_title() . "</div>";
									?>
									<div class="clear"></div>
								</div>
								<div class='links' align='center'><a href='javascript:' class='continue btn btn-continue'><?php echo __( "Continue my shopping", "dootech-wccs" ); ?></a> <a href='<?php echo WC()->cart->get_cart_url(); ?>' class='btn btn-my-cart'><?php echo __( "My cart", "dootech-wccs" ); ?></a> <a href='<?php echo WC()->cart->get_checkout_url(); ?>' class='btn btn-my-cart'><?php echo __( "Checkout", "dootech-wccs" ); ?></a>
									<span class="close">&times;</span>
								</div>
								<?php
							}
							?>
							<hr>
							<h4><?php esc_html_e( 'Other people who bought this product also bought:', 'dootech-wccs' ) ?></h4>

							<div id="crosssells" data-visible="4">
								<ul class="products">

									<?php foreach ( $cross_sells as $cross_sell ) : ?>

										<?php
										$post_object = get_post( $cross_sell );

										setup_postdata( $GLOBALS['post'] =& $post_object );

										wc_get_template_part( 'content', 'product' ); ?>

									<?php endforeach; ?>

								</ul>
							</div>
						</div>
					</section>

				<?php endif;

				wp_reset_postdata();
			}
		}
	}

}
