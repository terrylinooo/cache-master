<?php
/**
 * Cache Master - Update setting.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

add_action( 'update_option_scm_option_driver', 'scm_update_scm_option_driver' );
add_action( 'update_option_scm_option_post_types', 'scm_update_scm_option_post_types' );

/**
 * Rebuild data schema.
 *
 * @return void
 */
function scm_update_scm_option_driver() {
    $driver_type = get_option( 'scm_option_driver' );

    if ( ! scm_test_driver( $driver_type ) ) {
        set_option( 'scm_option_driver', 'file' );

        // Road back to File driver if the option is not available.
        $driver_type = 'file';
    }

    $driver = scm_driver_factory( $driver_type );
    $driver->rebuild();
}

/**
 * Clear all caches.
 *
 * @return void
 */
function scm_update_scm_option_post_types() {
    $driver_type = get_option( 'scm_option_driver' );
    $driver = scm_driver_factory( $driver_type );
    $driver->clear();
}
