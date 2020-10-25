<?php
/**
 * Cache Master - Advanced settings - Driver: Memcached.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_memcached = get_option( 'scm_option_advanced_driver_memcached' );

$option_list = array(
	'host' => __( 'Host', 'cache-master' ),
    'port' => __( 'Port', 'cache-master' ),
);

$option_default_list = array(
    'host' => '127.0.0.1',
    'port' => 11211,
);

$is_driver_setting_correct = false;

if ( scm_test_driver( 'memcached' ) ) {
    $is_driver_setting_correct = true;
}

?>

<?php if ( extension_loaded( 'memcached' ) ) : ?>

    <?php if ( 'memcached' !== get_option( 'scm_option_driver' ) ) : ?>

        <div>
            <?php foreach ( $option_list as $k => $v ) : ?>
            <div class="scm-option-item">
                <div class="scm-label-wrapper">
                    <label for="cache-master-advanced-driver-memcached-option-<?php echo $k; ?>">
                        <?php echo $v; ?>
                    <label>
                </div>

                <?php if ( !empty( $option_memcached[ $k ] ) ) : ?>
                    <?php $memcached_field_value = $option_memcached[ $k ]; ?>
                <?php else: ?>
                    <?php $memcached_field_value = $option_default_list[ $k ]; ?>
                <?php endif; ?>

                <input type="text" 
                    name="scm_option_advanced_driver_memcached[<?php echo $k; ?>]" 
                    id="cache-master-advanced-driver-memcached-option-<?php echo $k; ?>" 
                    value="<?php echo $memcached_field_value; ?>" 
                />
            </div>
            <?php endforeach; ?>
        </div>
        <p><em><?php _e( 'Change the settings carefully, make sure you know what you do.', 'cache-master' ); ?></em></p>
        <?php if ( ! $is_driver_setting_correct ) : ?>
        <p><em class="scm-msg scm-msg-error"><?php _e( 'The settings you set are not working, please recheck your settings.', 'cache-master' ); ?></em></p>
        <?php endif; ?>

    <?php else: ?>

        <div>
            <?php foreach ( $option_list as $k => $v ) : ?>
            <div class="scm-option-item">
                <div class="scm-label-wrapper">
                    <label>
                        <?php echo $v; ?>
                    <label>
                </div>

                <?php if ( !empty( $option_memcached[ $k ] ) ) : ?>
                        <?php $memcached_field_value = $option_memcached[ $k ]; ?>
                <?php else: ?>
                    <?php $memcached_field_value = $option_default_list[ $k ]; ?>
                <?php endif; ?>

                <input type="text" value="<?php echo $memcached_field_value; ?>" disabled  />
            </div>
            <?php endforeach; ?>
        </div>
        <p><em class="scm-msg scm-msg-info"><?php _e( 'This option is not available to change, becasue you are using this driver.', 'cache-master' ); ?></em></p>

    <?php endif; ?>

<?php else: ?>

    <div>
        <?php foreach ( $option_list as $k => $v ) : ?>
        <div class="scm-option-item">
            <div class="scm-label-wrapper">
                <label>
                    <?php echo $v; ?>
                <label>
            </div>
            <input type="text" value="<?php echo $option_default_list[ $k ]; ?>" disabled  />
        </div>
        <?php endforeach; ?>
    </div>
    <p><em class="scm-msg scm-msg-error"><?php echo sprintf( __( 'PHP extension "%s" is not installed on your system.', 'cache-master' ), 'memcached' ); ?></em></p>

<?php endif ;?>