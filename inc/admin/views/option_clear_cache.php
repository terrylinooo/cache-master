<?php
/**
 * Cache Master - Statistic status
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.4.0
 * @version 1.4.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

?>

<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_clear_cache" id="cache-master-clear-cache-all-option-enable" value="all" >
		<label for="cache-master-clear-cache-all-option-enable">
			<?php echo __( 'All', 'cache-master' ); ?><br />
		<label>
    </div>
    <?php if ( 'enable' === get_option( 'scm_option_statistics_status' ) ) : ?>
        <?php foreach ( scm_get_cache_type_list() as $k => $v ) : ?>
        <div class="scm-option-item">
            <input type="radio" name="scm_option_clear_cache" id="cache-master-clear-cache-<?php echo $k; ?>-option-disable" value="<?php echo $k; ?>">
            <label for="cache-master-clear-cache-<?php echo $k; ?>-option-enable">
			<?php echo $v; ?><br />
		<label>
        </div>	
        <?php endforeach; ?>
        <p><em><?php echo __( 'Clear cache data of a specific cache type, or just clear all of them.', 'cache-master' ); ?></em></p>
    <?php endif; ?>
</div>
