<?php

function arb_insert_reaction($args = []) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'arb_reactions';
    
    $defaults = [
        "post_id" => '',
        "user_id" => '',
        "reaction_id" => '',
    ];

    $data = wp_parse_args( $args, $defaults );

    // TODO: reaction_id if existed agaient a user on a post then uset the reaction_id

    $existing_reaction_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT reaction_id FROM $table_name WHERE post_id = %d AND user_id = %d",
            $data['post_id'],
            $data['user_id']
        )
    );

    if ( $existing_reaction_id ) {
        if ( $existing_reaction_id === $data['reaction_id'] ) {
            // The same reaction was already recorded for this post and user, so no need to update the database.
            // $wpdb->update($table_name, ['reaction_id' => null], ['post_id' => $data['post_id'], 'user_id' => $data['user_id']], '%d', ['%d', '%d']);
            return;
        } else {
            // Update the existing reaction.
            $wpdb->update(
                $table_name,
                [ 'reaction_id' => $data['reaction_id'] ],
                [ 'post_id' => $data['post_id'], 'user_id' => $data['user_id'] ],
                [ '%d' ],
                [ '%d', '%d' ]
            );
        }
    } else {
        // Insert a new reaction.
        $inserted = $wpdb->insert(
            $table_name,
            $data,
            [
                '%d',
                '%d',
                '%d',
            ]
        );

        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert', 'arb_reactions' ) );
        }

        return $wpdb->insert_id;
    }
}

function arb_reset_reaction($args = []) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'arb_reactions';
    
    $defaults = [
        "post_id" => '',
        "user_id" => '',
        "reaction_id" => '',
    ];

    $data = wp_parse_args( $args, $defaults );

    $existing_reaction_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT reaction_id FROM $table_name WHERE post_id = %d AND user_id = %d",
            $data['post_id'],
            $data['user_id']
        )
    );

    if ( $existing_reaction_id ) {
        if ( $existing_reaction_id === $data['reaction_id'] ) {
            $wpdb->update(
                $table_name,
                [ 'reaction_id' => 5 ],
                [ 'post_id' => $data['post_id'], 'user_id' => $data['user_id'] ],
                [ '%d' ],
                [ '%d', '%d' ]
            );
        }
    }
}

// Get total like
function arb_get_likes() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'arb_reactions';
    $user_id = get_current_user_id();
    
    $total_likes = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE post_id = %d AND reaction_id != 0",
            get_the_ID()
        ) 
    );
    
    $num_liked_by = count( $total_likes );

    if( 1 == $num_liked_by ) {
        if( $user_id == $total_likes->user_id ) {
            $like_message = __( 'You like this', 'arb-reaction' );
        } else {
            $like_message = __( '1 person like this', 'arb-reaction' );
        }
    } else if( 2 == $num_liked_by ) {
        $like_message = __( 'You and 1 other like this', 'arb-reaction' );
    } else if( 0 == $num_liked_by ) {
        $like_message = __( 'Be the first one', 'arb-reaction' );
    } else {
        $num_others = $num_liked_by - 1;
        $like_message = __('You and ', 'arb-reaction') . $num_others . __(' others like this', 'arb-reaction');
    }

    return $like_message;
}