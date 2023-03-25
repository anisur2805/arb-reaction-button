<?php
/**
 * Plugin Name: Reaction Button
 * Plugin URI: #
 * Description: A custom WordPress plugin that displays three reaction icons: 'smile,' 'straight,' and 'sad.' This plugin allows logged-in users to submit their reactions by clicking on the corresponding icon. Users can also modify or delete their reactions at any time, similar to the reaction functionality on Facebook or LinkedIn.
 * Version: 1.0
 * Author: Anisur Rahman
 * Author URI: #
 * Text Domain: arb-reaction
 *
 * @package WooCommerce
 */
defined( 'ABSPATH' ) or die( 'No Cheating!' );

use ARB\Reaction_Button\Ajax;
use ARB\Reaction_Button\Assets;
use ARB\Reaction_Button\Installer;
use ARB\Reaction_Button\Widgets\ARB_Reaction_Button_Widget;

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

final class ARB_Reaction_Button {
    /**
     * plugin version
     */
    const version = '1.0';

    /**
     * class constructor
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate'] );
        add_action( 'plugins_loaded', [$this, 'init_plugin'] );
        add_shortcode( 'reaction_button', [$this, 'arb_reaction_button_shortcode' ] );
        add_action( 'elementor/widgets/register', [ $this, 'arb_reaction_button_register_widget' ] );
        add_action( 'init', [ $this, 'rab_rab_reaction_button_blocks_block_init' ] );

    }

    /**
     * Initialize a singleton instance
     *
     * @return \ARB_Reaction_Button
     */
    public static function init() {
        static $instance = false;
        if ( !$instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * define plugin require constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'ARB_REACTION_BUTTON_VERSION', self::version );
        define( 'ARB_REACTION_BUTTON_FILE', __FILE__ );
        define( 'ARB_REACTION_BUTTON_PATH', __DIR__ );
        define( 'ARB_REACTION_BUTTON_URL', plugins_url( '', ARB_REACTION_BUTTON_FILE ) );
        define( 'ARB_REACTION_BUTTON_ASSETS', ARB_REACTION_BUTTON_URL . '/assets' );
        define( 'ARB_REACTION_BUTTON_INCLUDES', ARB_REACTION_BUTTON_URL . '/includes' );
    }

    /**
     * Do staff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Installer();
        $installer->run();
    }
    
    public function init_plugin() {
        
        new Assets();
        
        if( defined( 'DOING_AJAX') && DOING_AJAX ) {
            new Ajax();
        }
    }

    // Add the shortcode [custom-reactions] to any post or page
    function arb_reaction_button_shortcode() {
        wp_enqueue_style( 'arb-style' );
        wp_enqueue_script( 'arb-script' );
        ob_start();
        ?>
        <div class="custom-reactions-container">
            <div class="like-info">
                <?php echo arb_get_likes(); ?>
            </div>

            <div class="like-wrapper">
                <!-- <button class="" data-react-id="1"> <span class="dashicons dashicons-thumbs-up"></span> Like</button> -->
                <?php echo arb_retrieve_like_button(); ?>
            </div>
            <div class="like-variations">
                <input type="hidden" name="arb_user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>" />
                <input type="hidden" name="arb_post_id" value="<?php echo esc_attr( get_the_ID()); ?>" />
                <button class="button-smile button-variation-item" data-react-id="1">
                    <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/smile.png' ); ?>" />
                    <span><?php esc_html_e('Smile'); ?></span>
                </button>
                <button class="button-straight button-variation-item" data-react-id="2">
                    <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/straight.png' ); ?>" />
                    <span><?php esc_html_e('Straight'); ?></span>
                </button>
                <button class="button-sad button-variation-item" data-react-id="3">
                    <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/sad.png' ); ?>" />
                    <span><?php esc_html_e('Sad'); ?></span>
                </button>
            </div>
        </div>
        <?php
        $output = ob_get_clean();
    
        return $output;
    }

    function arb_reaction_button_register_widget( $widgets_manager ) {
        require_once( __DIR__ . '/includes/widgets/arb-reaction-button-widget.php' );

        $widgets_manager->register( new ARB_Reaction_Button_Widget() );
    }
    function rab_rab_reaction_button_blocks_block_init() {
        register_block_type( __DIR__ . '/includes/blocks/rab-reaction-button-blocks/build' );
    }

}

/**
 * Initialize the main plugin
 *
 * @return \ARB_Reaction_Button
 */
function ARB_Reaction_Button() {
    return ARB_Reaction_Button::init();
}

ARB_Reaction_Button();