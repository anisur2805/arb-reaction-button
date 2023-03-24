<?php

namespace ARB\Reaction_Button\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * @since 1.1.0
 */
class ARB_Reaction_Button_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'arb-reaction-button';
    }

    public function get_title() {
        return __('Reaction Button', 'arb-reaction');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Header Content', 'arb-reaction'),
            ]
        );
        $this->add_control(
            'wcu-pre-header',
            [
                'label'       => __('Test', 'arb-reaction'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
    
        $this->end_controls_section();
    }
    

    protected function render() {
        wp_enqueue_style( 'arb-style' );
        wp_enqueue_script( 'arb-script' );
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
                <button class="button-smile button-variation-item" data-react-id="1">
                    <img src="<?php echo esc_url( ARB_REACTION_BUTTON_ASSETS . '/images/smile.png' ); ?>" />
                </button>
                <button class="button-smile button-variation-item" data-react-id="2">
                    <img src="<?php echo esc_url( ARB_REACTION_BUTTON_ASSETS . '/images/straight.png' ); ?>" />
                </button>
                <button class="button-smile button-variation-item" data-react-id="3">
                    <img src="<?php echo esc_url( ARB_REACTION_BUTTON_ASSETS . '/images/sad.png' ); ?>" />
                </button>
            </div>
        </div>
        <?php
        $output = ob_get_clean();

        echo $output;
    }
}