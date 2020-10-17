<?php
/**
 * Cache Master - Setting page.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.5.2
 * @version 1.5.2
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

add_action( 'admin_bar_menu', 'scm_button_clear_cache', 999 );
add_action( 'admin_footer', 'scm_footer_js_clear_cache' );

/**
 * Add a clear cache button on admin bar.
 *
 * @param object $admin_bar
 *
 * @return void
 */
function scm_button_clear_cache( $admin_bar ){
    $admin_bar->add_menu( array( 
        'id'    => 'scm-clear-cache',
        'title' => '<img src="' . plugins_url( 'cache-master/inc/assets/images/menu_icon.png' ) . '" style="vertical-align: middle; padding-bottom: 2px; padding-right: 4px;">' . __( 'Clear Cache', 'cache-master' ),
        'href'  => '#' 
    ) );
}

/**
 * Ajax handler for the action of the clear cache button.
 *
 * @return void
 */
function scm_footer_js_clear_cache() {
    ?>

    <script>

        (function($) {
            $(function() {
                $('li#wp-admin-bar-scm-clear-cache .ab-item').on('click', function() {
                    var data = {
                        'action': 'scm_action_clear_cache',
                        '_wpnonce': '<?php echo wp_create_nonce( 'scm_clear_cache_' . scm_get_dir_hash() ); ?>'
                    };
                    $.post(ajaxurl, data, function(response) {
                        alert(response);
                    });
                });
            });
        })(jQuery);

    </script> 

    <?php
}

