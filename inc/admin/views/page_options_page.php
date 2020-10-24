<?php
/**
 * Cache Master - Options page.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$conflict_plugins = array(
    //'clearfy/clearfy.php',
);

foreach ( $conflict_plugins as $plugin ) {
    if ( is_plugin_active( $plugin ) ) {
        ?>

        <div class="notice notice-warning is-dismissible">
            <p>
                <?php  echo sprintf( __( 'Cache Master cannot work with the plugin "%s" becasue of output buffer conflicts.', 'cache-master' ), $plugin ); ?>
            </p>
        </div>

        <?php
    }
}

function scm_tab( $input, $check ) {
    if ( $input === $check ) {
        echo 'nav-tab nav-tab-active';
    } else {
        echo 'nav-tab';
    }
}

$tab = isset( $_GET['tab'])  ? $_GET['tab'] : null;

?>

<nav class="nav-tab-wrapper">
    <a href="?page=cache-master-settings" class="<?php scm_tab( $tab, null ); ?>">
        <?php _e( 'Basic', 'cache-master' ); ?>
    </a>
    <a href="?page=cache-master-settings&tab=advanced" class="<?php scm_tab( $tab, 'advanced' ); ?>">
        <?php _e( 'Advanced', 'cache-master' ); ?>
    </a>
    <a href="?page=cache-master-settings&tab=preferences" class="<?php scm_tab( $tab, 'preferences' ); ?>">
        <?php _e( 'Preferences', 'cache-master' ); ?>
    </a>
    <a href="?page=cache-master-settings&tab=benchmark" class="<?php scm_tab( $tab, 'benchmark' ); ?>">
        <?php _e( 'Benchmark', 'cache-master' ); ?>
    </a>
    <a href="?page=cache-master-settings&tab=woocommerce" class="<?php scm_tab( $tab, 'woocommerce' ); ?>">
        <?php _e( 'WooCommerce', 'cache-master' ); ?>
    </a>
    <a href="?page=cache-master-settings&tab=exclusion" class="<?php scm_tab( $tab, 'exclusion' ); ?>">
        <?php _e( 'Exclusion', 'cache-master' ); ?>
    </a>
</nav>

<div class="tab-content">
    <?php if ( null === $tab ) : ?>
        <form action="options.php" method="post">
            <?php settings_fields( 'scm_setting_group_1' ); ?>
            <?php do_settings_sections( 'scm_setting_page_1' );  ?>
            <hr />
            <?php submit_button(); ?>
        </form>
    <?php endif; ?>

    <?php if ( 'preferences' === $tab ) : ?>
        <form action="options.php" method="post">
            <?php settings_fields( 'scm_setting_group_6' ); ?>
            <?php do_settings_sections( 'scm_setting_page_6' );  ?>
            <hr />
            <p><em><?php _e( 'Once you make changes in this page, all cache data will be cleared.', 'cache-master' ); ?></em></p>
            <?php submit_button(); ?>
        </form>
    <?php endif; ?>

    <?php if ( 'benchmark' === $tab ) : ?>
        <p><?php _e( 'Benchmark information consists of memory usage, SQL query number, page generation time and page caching status.', 'cache-master' ); ?></p>
        <form action="options.php" method="post">
            <?php settings_fields( 'scm_setting_group_5' ); ?>
            <?php do_settings_sections( 'scm_setting_page_5' );  ?>
            <hr />
            <p><em><?php _e( 'Once you make changes in this page, all cache data will be cleared.', 'cache-master' ); ?></em></p>
            <?php submit_button(); ?>
        </form>
    <?php endif; ?>

    <?php if ( 'advanced' === $tab ) : ?>
        <p><?php _e( 'Skip those settings unless you want to make changes to default settings.', 'cache-master' ); ?></p>
        <form action="options.php" method="post">
            <?php settings_fields( 'scm_setting_group_7' ); ?>
            <?php do_settings_sections( 'scm_setting_page_7' );  ?>
            <hr />
            <?php submit_button(); ?>
        </form>
    <?php endif; ?>

    <?php if ( 'woocommerce' === $tab ) : ?>
        <form action="options.php" method="post">
            <?php settings_fields( 'scm_setting_group_8' ); ?>
            <?php do_settings_sections( 'scm_setting_page_8' );  ?>
            <hr />
            <p><em><?php _e( 'Once you make changes in this page, all cache data will be cleared.', 'cache-master' ); ?></em></p>
            <?php submit_button(); ?>
        </form>
    <?php endif; ?>

    <?php if ( 'exclusion' === $tab ) : ?>
        <form action="options.php" method="post">
            <?php settings_fields( 'scm_setting_group_9' ); ?>
            <?php do_settings_sections( 'scm_setting_page_9' );  ?>
            <hr />
            <?php submit_button(); ?>
        </form>
    <?php endif; ?>
</div>



