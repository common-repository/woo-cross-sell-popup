<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.dootech.fr/
 * @since      1.0.0
 *
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dootech_Woocommerce_Cross_Sell_Popup
 * @subpackage Dootech_Woocommerce_Cross_Sell_Popup/admin
 * @author     Dootech <contact@dootech.fr>
 */
class Dootech_Woocommerce_Cross_Sell_Popup_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $short_name    The name of this plugin.
	 */
	private $short_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $enable_params;
	private $enable_crosssell;
	private $enable_on_mobile;

	public $tab;
	public $activeTab;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The slug of this plugin.
	 * @param      string    $short_name    The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 * @param      array     $enable_params    The params of this plugin.
	 */
	public function __construct( $plugin_name, $short_name, $version, $enable_params ) {

		$this->plugin_name = $plugin_name;
		$this->short_name = $short_name;
		$this->version = $version;

		$this->enable_params = $enable_params;
		$this->enable_crosssell = $enable_params['enable_crosssell'];
		$this->enable_on_mobile = $enable_params['enable_on_mobile'];

        // add page in the Settings menu
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ], 900 );
		add_action( 'admin_init', [ $this, 'admin_panels' ] );
	}

	/**
	 * Add the new WooCommerce sub menu
     *
     * @since 1.0.0
	 */
	public function add_admin_menu() {
		add_submenu_page( 'woocommerce', $this->short_name, __( 'Cross-sell popup', $this->plugin_name ), 'manage_options', $this->plugin_name, array( $this, 'dt_cross_sell_admin_settings' ) );

	}

	/**
	 * Display settings
	 *
	 * @since 1.0.0
	 */
	public function dt_cross_sell_admin_settings(){
		echo "<div class='".$this->plugin_name."'>";
		echo "<h1>". $this->short_name ."</h1>";

	    $this->admin_tabs();
		?>
            <form method='post' id='<?php echo $this->plugin_name; ?>-form'
                  action= "<?php echo admin_url( 'admin.php?page='.$this->plugin_name ); ?>">
                <?php

                settings_fields( $this->plugin_name.'general-options' );
                do_settings_sections( $this->plugin_name.'general-options' );

                wp_nonce_field( $this->plugin_name );
                submit_button();

                ?>
            </form>

            <div class='result'><?php $this->admin_process_settings(); ?> </div>
		<?php
		echo "</div>";
	}

	/**
	 * Display settings tabs
	 *
	 * @since 1.0.0
	 */
	public function admin_tabs(){
		$this->tab = array( 'settings' => 'Settings' );
		if( $_GET['tab'] ){
			$this->activeTab = $_GET['tab'] ;
		} else  {
			$this->activeTab = 'main';
		}

		echo '<h2 class="nav-tab-wrapper">';
		foreach( $this->tab as $tab => $name ){
			$class = ( $tab == $this->activeTab ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab".$class." contant' href='?page=".$this->plugin_name."&tab=".$tab."'>".$name."</a>";
		}
		echo '</h2>';
	}

	/**
	 * Enable crosssell on single page product
	 *
	 * @since 1.0.0
	 */
	public function enable_crosssell(){
		?>
        <select name="<?php echo $this->plugin_name.$this->enable_crosssell; ?>" id="<?php echo $this->plugin_name.$this->enable_crosssell; ?>" required value="<?php echo esc_attr( get_option( $this->plugin_name.$this->enable_crosssell ) ); ?>" placeholder='<?php echo __( 'Enable crosssell', $this->plugin_name ); ?>' >

			<?php if ( esc_attr( get_option( $this->plugin_name.$this->enable_crosssell ) ) != '' && !$_REQUEST[$this->plugin_name.$this->enable_crosssell] ) { ?>
                <option selected value='<?php echo esc_attr( get_option( $this->plugin_name.$this->enable_crosssell ) ); ?>'>
					<?php echo __( esc_attr( get_option( $this->plugin_name.$this->enable_crosssell ) ), $this->plugin_name ); ?></option>
				<?php
			} elseif ( $_REQUEST[$this->plugin_name.$this->enable_crosssell] ) { ?>
                <option selected value='<?php echo sanitize_text_field( $_REQUEST[$this->plugin_name.$this->enable_crosssell] );?>'>
					<?php echo __( sanitize_text_field( $_REQUEST[$this->plugin_name.$this->enable_crosssell] ), $this->plugin_name ); ?></option>
				<?php
			}?>
            <optgroup label="------">------</optgroup>
            <option value='Yes'><?php echo __( 'Yes', $this->plugin_name ); ?></option>
            <option value='No'><?php echo __( 'No', $this->plugin_name ); ?></option>
        </select>
		<?php
	}

	/**
	 * Enable on mobile settings
	 *
	 * @since 1.0.0
	 */
	public function enable_on_mobile(){
		?>
        <select name="<?php echo $this->plugin_name.$this->enable_on_mobile; ?>" id="<?php echo $this->plugin_name.$this->enable_on_mobile; ?>" required value="<?php echo esc_attr( get_option( $this->plugin_name.$this->enable_on_mobile ) ); ?>" placeholder='<?php echo __( 'Show on Mobile', $this->plugin_name ); ?>' >
            <<?php if ( esc_attr( get_option( $this->plugin_name.$this->enable_on_mobile ) ) != '' && !$_REQUEST[$this->plugin_name.$this->enable_on_mobile] ) { ?>
                <option selected value='<?php echo esc_attr( get_option( $this->plugin_name.$this->enable_on_mobile ) ); ?>'>
					<?php echo __( esc_attr( get_option( $this->plugin_name.$this->enable_on_mobile ) ), $this->plugin_name ); ?></option>
				<?php
			} elseif ( $_REQUEST[$this->plugin_name.$this->enable_on_mobile] ) { ?>
                <option selected value='<?php echo sanitize_text_field( $_REQUEST[$this->plugin_name.$this->enable_on_mobile] );?>'>
					<?php echo __( sanitize_text_field( $_REQUEST[$this->plugin_name.$this->enable_on_mobile] ), $this->plugin_name ); ?></option>
				<?php
			}?>
            <optgroup label="------">------</optgroup>
            <option  value='Yes'><?php echo __( 'Yes', $this->plugin_name ); ?></option>
            <option  value='No'><?php echo __( 'No', $this->plugin_name ); ?></option>
        </select>
		<?php
	}

	/**
	 * Show options
	 *
	 * @since 1.0.0
	 */
	public function admin_panels(){
		add_settings_section( $this->plugin_name."general", "", null, $this->plugin_name."general-options" );

		add_settings_field( 'enable_crosssell', __( "Enable crosssell", $this->plugin_name ), array( $this, 'enable_crosssell' ), $this->plugin_name."general-options", $this->plugin_name."general" );
		register_setting( $this->plugin_name."general", $this->plugin_name.$this->enable_crosssell );

		add_settings_field( 'enable_on_mobile', __( "Show Popup on Mobile", $this->plugin_name ), array( $this, 'enable_on_mobile' ), $this->plugin_name."general-options", $this->plugin_name."general");
		register_setting( $this->plugin_name."general", $this->plugin_name.$this->enable_on_mobile);
	}

	/**
	 * Save settings
	 *
	 * @since 1.0.0
	 */
	public function admin_process_settings(){

		if($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_can('administrator') ){

			check_admin_referer( $this->plugin_name );
			check_ajax_referer($this->plugin_name);
			if($_REQUEST[$this->plugin_name.$this->enable_crosssell]){
				update_option($this->plugin_name.$this->enable_crosssell,sanitize_text_field($_REQUEST[$this->plugin_name.$this->enable_crosssell]));
			}

			if($_REQUEST[$this->plugin_name.$this->enable_on_mobile]){
				update_option($this->plugin_name.$this->enable_on_mobile,sanitize_text_field($_REQUEST[$this->plugin_name.$this->enable_on_mobile]));
			}
		}
	}

}
