<?php

function arb_reaction_button_register_block() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    register_block_type( 'arb/reaction-button', array(
        'editor_script' => 'arb-editor-script',
    ) );
}
add_action( 'init', 'arb_reaction_button_register_block' );

function my_plugin_enqueue_scripts() {
    wp_enqueue_style( 'arb-reaction-button-style', ARB_REACTION_BUTTON_URL . '/assets/css/style.css' );
    wp_enqueue_script( 'arb-reaction-button-script', ARB_REACTION_BUTTON_URL . '/assets/js/script.js', array( 'wp-blocks', 'wp-element' ), false, true );
}
add_action( 'enqueue_block_editor_assets', 'my_plugin_enqueue_scripts' );


function my_plugin_render_reaction_button( $attributes ) {
    ob_start();
    ?>
    <div class="custom-reactions-container">
        <div class="like-info">
            <?php echo arb_get_likes(); ?>
        </div>

        <div class="like-wrapper">
            <button class="" data-react-id="1"> <span class="dashicons dashicons-thumbs-up"></span> Like</button>
        </div>
        <div class="like-variations">
            <input type="hidden" name="arb_user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>" />
            <input type="hidden" name="arb_post_id" value="<?php echo esc_attr( get_the_ID()); ?>" />
            <button class="button-smile button-variation-item arb-reaction-button" data-react-id="1">
                <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/smile.png' ); ?>" />
            </button>
            <button class="button-smile button-variation-item arb-reaction-button" data-react-id="2">
                <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/straight.png' ); ?>" />
            </button>
            <button class="button-smile button-variation-item arb-reaction-button" data-react-id="3">
                <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/sad.png' ); ?>" />
            </button>
        </div>
    </div>
    <?php
    $output = ob_get_clean();

    return $output;
}
