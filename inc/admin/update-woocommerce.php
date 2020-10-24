<?php
/**
 * Cache Master - WooCommerce events.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'woocommerce_payment_complete', 'scm_payment_complete' );

/**
 * Delete the cache of the post that is just updated.
 *
 * @return void
 */
function scm_payment_complete( $order_id ){
    $order = wc_get_order( $order_id );
    $items = $order->get_items();

    foreach ( $items as $item ) {
        $product_id = $item->get_product_id();
    }

    $post_url    = get_permalink( $product_id );
    $cache_key   = md5( parse_url( $post_url, PHP_URL_PATH ) );
    $driver_type = get_option( 'scm_option_driver' );
    $driver      = scm_driver_factory( $driver_type );

    $driver->delete( $cache_key );
}
