<?php
/**
 * Cache Master - Advanced settings - Driver: MongoDB.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.6.0
 * @version 1.6.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_mongodb = get_option( 'scm_option_advanced_driver_mongodb' );

$option_list = array(
	'host'       => __( 'Host', 'cache-master' ),
    'port'       => __( 'Port', 'cache-master' ),
    'user'       => __( 'User', 'cache-master' ),
    'pass'       => __( 'Password', 'cache-master' ),
    'database'   => __( 'Database', 'cache-master' ),
    'collection' => __( 'Collection', 'cache-master' ),
);

$option_default_list = array(
    'host'       => '127.0.0.1',
    'port'       => 27017,
    'user'       => '',
    'pass'       => '',
    'database'   => 'test',
    'collection' => 'cache_data',
);

?>

<?php if ( extension_loaded( 'mongodb' ) ) : ?>

    <?php if ( 'mongo' !== get_option( 'scm_option_driver' ) ) : ?>

        <div>
            <?php foreach ( $option_list as $k => $v ) : ?>
            <div class="scm-option-item">
                <div class="scm-label-wrapper">
                    <label for="cache-master-advanced-driver-mongodb-option-<?php echo $k; ?>">
                        <?php echo $v; ?>
                    <label>
                </div>

                <?php if ( !empty( $option_mongodb[ $k ] ) ) : ?>
                    <?php $mongodb_field_value = $option_mongodb[ $k ]; ?>
                <?php else: ?>
                    <?php $mongodb_field_value = $option_default_list[ $k ]; ?>
                <?php endif; ?>

                <input 
                    type="text" 
                    name="scm_option_advanced_driver_mongodb[<?php echo $k; ?>]" 
                    id="cache-master-advanced-driver-mongodb-option-<?php echo $k; ?>" 
                    value="<?php echo $mongodb_field_value; ?>" 
                />
            </div>
            <?php endforeach; ?>

        </div>
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

                <?php if ( !empty( $option_mongodb[ $k ] ) ) : ?>
                    <?php $mongodb_field_value = $option_mongodb[ $k ]; ?>
                <?php else: ?>
                    <?php $mongodb_field_value = $option_default_list[ $k ]; ?>
                <?php endif; ?>

                <input type="text" value="<?php echo $mongodb_field_value; ?>" disabled  />
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
    <p><em style="color: #990000"><?php echo sprintf( __( 'PHP extension "%s" is not installed on your system.', 'cache-master' ), 'mongodb' ); ?></em></p>

<?php endif ;?>