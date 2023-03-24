<?php

namespace ARB\Reaction_Button;

/**
 * Installer class
 */
class Installer {
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    public function add_version() {
        $installed = get_option( 'arb_installed' );
        if ( !$installed ) {
            update_option( 'arb_installed', time() );
        }

        update_option( 'arb_version', ARB_REACTION_BUTTON_VERSION );
    }

    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}arb_reactions`(
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            post_id int(11) NOT NULL,
            reaction_id int(11) NOT NULL,
            -- created_at DATETIME NOT NULL,
            -- created_by BIGINT(20) UNSIGNED NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( !function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }

}