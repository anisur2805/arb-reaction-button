<?php

namespace ARB\Reaction_Button;

class Ajax {
    public function __construct() {
        add_action('wp_ajax_like_action', [$this, 'like_action']);
        add_action('wp_ajax_nopriv_like_action', [$this, 'logged_out_like_action']);
        add_action('wp_ajax_main_like_action', [$this, 'main_like_action']);
        add_action('wp_ajax_nopriv_main_like_action', [$this, 'logged_out_like_action']);
    }

    public function logged_out_like_action() {
        wp_send_json_error([
            'error' => __('Please login to Like the post', 'arb-reaction')
        ]);
    }

    public function like_action() {
        global $wpdb;

        if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'arb-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verify failed!', 'arb-reaction' )
            ] );
        }

        $id      = ( isset( $_POST[ 'id' ] ) ) ? intval($_POST['id']) : 0;
        $user_id = ( isset( $_POST[ 'user_id' ] ) ) ? intval( $_POST[ 'user_id' ] ) : 0;
        $post_id = ( isset( $_POST[ 'post_id' ] ) ) ? intval( $_POST[ 'post_id' ] ) : 0;
        
        $args = [
            "post_id"       => $post_id,
            "user_id"       => $user_id,
            "reaction_id"   => $id,
        ];

        $insert_id = arb_insert_reaction($args);

        wp_send_json_success([
            'id'      => $insert_id,
            'message' => __( 'submit done!', 'arb-reaction' ),
        ]);
    }    
    public function main_like_action() {
        global $wpdb;

        if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'arb-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verify failed!', 'arb-reaction' )
            ] );
        }

        $id      = ( isset( $_POST[ 'id' ] ) ) ? intval($_POST['id']) : 0;
        $user_id = ( isset( $_POST[ 'user_id' ] ) ) ? intval( $_POST[ 'user_id' ] ) : 0;
        $post_id = ( isset( $_POST[ 'post_id' ] ) ) ? intval( $_POST[ 'post_id' ] ) : 0;
        
        $args = [
            "post_id"       => $post_id,
            "user_id"       => $user_id,
            "reaction_id"   => $id,
        ];

        $insert_id = arb_reset_reaction($args);

        wp_send_json_success([
            'id'      => $insert_id,
            'message' => __( 'submit done!', 'arb-reaction' ),
        ]);
    }
}
