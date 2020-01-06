<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Get all pros and cons boxes
 *
 * @param $args array
 *
 * @return array
 */
function apcb_get_all_pros_and_cons_boxes( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'ID',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'prosandconsbox-all';
    $items     = wp_cache_get( $cache_key, 'apcb' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'posts WHERE `post_type`="amazin_pc_box" ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'apcb' );
    }

    return $items;
}

/**
 * Fetch all pros and cons box from database
 *
 * @return array
 */
function apcb_get_pros_and_cons_box_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'posts WHERE `post_type`="amazin_pc_box"' );
}

/**
 * Fetch a single pros and cons box from database
 *
 * @param int   $id
 *
 * @return array
 */
function apcb_get_pros_and_cons_box( $id ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'posts WHERE id = %d', $id ) );
}

function apcb_new_pros_and_cons_box ( $pros_and_cons_box) {
    wp_insert_post( $pros_and_cons_box );
    return 1;
}

function apcb_update_pros_and_cons_box ( $pros_and_cons_box) {
    wp_update_post ( $pros_and_cons_box );
    return $pros_and_cons_box->id;
}

function apcb_delete_pros_and_cons_boxes ( $ids ) {
    global $wpdb;

    $ids = implode( ',', array_map( 'absint', $ids ) );
    $delQuery = "DELETE FROM " . $wpdb->prefix . "posts WHERE id IN ($ids)";

    return $wpdb->query( $delQuery );
}
