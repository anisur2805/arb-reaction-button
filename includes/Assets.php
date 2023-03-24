<?php

namespace ARB\Reaction_Button;

class Assets {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function get_scripts() {
        return [
            'arb-script' => [
                'src'     => ARB_REACTION_BUTTON_ASSETS . '/js/frontend.js',
                'version' => filemtime(ARB_REACTION_BUTTON_PATH . '/assets/js/frontend.js'),
                'deps'    => ['jquery'],
            ],
        ];
    }

    public function get_styles() {
        return [
            'arb-style' => [
                'src'     => ARB_REACTION_BUTTON_ASSETS . '/css/frontend.css',
                'version' => filemtime(ARB_REACTION_BUTTON_PATH . '/assets/css/frontend.css'),
            ],
        ];
    }

    public function enqueue_assets() {
        $scripts = $this->get_scripts();

        foreach ($scripts as $handle => $script) {
            $deps = isset($script['deps']) ? $script['deps'] : false;
            wp_register_script($handle, $script['src'], $deps, $script['version'], true);
        }

        $styles = $this->get_styles();

        foreach ($styles as $handle => $style ) {
            $deps = isset( $style['deps']) ? $style['deps'] : false;
            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'arb-script', 'arbObj', [
            'ajaxUrl'  => admin_url('admin-ajax.php' ),
            'error'    => __( 'Something went wrong', 'arb-reaction' ),
            '_wpnonce' => wp_create_nonce( 'arb-nonce' ),
        ]);
    }
}
