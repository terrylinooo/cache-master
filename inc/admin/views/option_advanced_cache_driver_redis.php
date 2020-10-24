<?php
/**
 * Cache Master - Advanced settings - Driver: Redis.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_redis = get_option( 'scm_option_advanced_driver_redis' );

$option_list = array(
	'host' => __( 'Host', 'cache-master' ),
    'port' => __( 'Port', 'cache-master' ),
    'user' => __( 'User', 'cache-master' ),
    'pass' => __( 'Password', 'cache-master' ),
);

$option_default_list = array(
    'host' => '127.0.0.1',
    'port' => 6379,
    'user' => '',
    'pass' => '',
);

?>

<?php if ( extension_loaded( 'redis' ) ) : ?>

    <?php if ( 'redis' !== get_option( 'scm_option_driver' ) ) : ?>

        <div>
            <?php foreach ( $option_list as $k => $v ) : ?>
            <div class="scm-option-item">
                <div class="scm-label-wrapper">
                    <label for="cache-master-advanced-driver-redis-option-<?php echo $k; ?>">
                        <?php echo $v; ?>
                    <label>
                </div>

                <?php if ( !empty( $option_redis[ $k ] ) ) : ?>
                    <?php $redis_field_value = $option_redis[ $k ]; ?>
                <?php else: ?>
                    <?php $redis_field_value = $option_default_list[ $k ]; ?>
                <?php endif; ?>

                <input 
                    type="text" 
                    name="scm_option_advanced_driver_redis[<?php echo $k; ?>]" 
                    id="cache-master-advanced-driver-redis-option-<?php echo $k; ?>" 
                    value="<?php echo $redis_field_value; ?>" 
                />
            </div>
            <?php endforeach; ?>
        </div>
        <p><em><?php _e( 'In order to authenticate with a username and password you need Redis >= 6.0.' ); ?></em></p>
        <p><em><?php _e( 'Change the settings carefully, make sure you know what you do.', 'cache-master' ); ?></em></p>

    <?php else: ?>

        <div>
            <?php foreach ( $option_list as $k => $v ) : ?>
            <div class="scm-option-item">
                <div class="scm-label-wrapper">
                    <label>
                        <?php echo $v; ?>
                    <label>
                </div>

                <?php if ( !empty( $option_redis[ $k ] ) ) : ?>
                    <?php $redis_field_value = $option_redis[ $k ]; ?>
                <?php else: ?>
                    <?php $redis_field_value = $option_default_list[ $k ]; ?>
                <?php endif; ?>

                <input type="text" value="<?php echo $redis_field_value; ?>" disabled  />
            </div>
            <?php endforeach; ?>
        </div>
        <p><em style="color: #009900"><?php _e( 'This option is not available to change, becasue you are using this driver.', 'cache-master' ); ?></em></p>

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
    <p><em style="color: #990000"><?php echo sprintf( __( 'PHP extension "%s" is not installed on your system.', 'cache-master' ), 'redis' ); ?></em></p>

<?php endif; ?>