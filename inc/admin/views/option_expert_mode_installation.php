<?php
/**
 * Cache Master - Uninstall option.
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.2.1
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

$option_expert_mode_installation = get_option( 'scm_option_expert_mode_installation', 'no' );

$check_file_result   = scm_search_expert_mode_code_snippet( scm_get_upload_dir() );
$is_expert_mode_code = $check_file_result[0];
$is_blog_dir         = $check_file_result[1];

$result_1 = '<span class="scm-no">' . __( 'No', 'cache-master' ) . '</span>';
$result_2 = '<span class="scm-no">' . __( 'No', 'cache-master' ) . '</span>';

if ( $is_expert_mode_code ) {
	$result_1 = '<span class="scm-yes">' . __( 'Yes', 'cache-master' ) . '</span>';
} 
if ( $is_blog_dir ) {
	$result_2 = '<span class="scm-yes">' . __( 'Yes', 'cache-master' ) . '</span>';
}
?>

<?php if ( scm_is_available_inject_code() ) : ?>
<div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_expert_mode_installation" id="cache-master-expert-mode-installation-option-yes" value="yes" 
			<?php checked( $option_expert_mode_installation, 'yes' ); ?>>
		<label for="cache-master-expert-mode-installation-option-yes">
			<?php echo __( 'Yes, help me install the code automatically.', 'cache-master' ); ?><br />
		<label>
	</div>
	<div class="scm-option-item">
		<input type="radio" name="scm_option_expert_mode_installation" id="cache-master-expert-mode-installation-option-no" value="no" 
			<?php checked( $option_expert_mode_installation, 'no' ); ?>>
		<label for="cache-master-expert-mode-installation-option-no">
			<?php echo __( 'No, I will install the code manually.', 'cache-master' ); ?>
		<label>
	</div>	
</div>
<p><em><?php echo __( 'Code Master can modify <code>wp-config.php</code> and install the code for you.', 'cache-master' ); ?></em></p>
<p><em><?php echo __( 'Or, you can follow the guide below to install the code yourself.', 'cache-master' ); ?></em></p>

<?php else: ?>

<p><?php echo sprintf( __( 'Check the code block in %s', 'cache-master' ), '<code>wp-config.php</code><p>' ); ?></p>
<ul>
    <li><?php _e( 'Does the code block exist?', 'cache-master' ); ?> <?php echo $result_1; ?></li>
    <li><?php _e( 'Does the code block is fit for this blog?', 'cache-master' ); ?> <?php echo $result_2; ?></li>
</ul>
<div>
	<div class="scm-option-item">
		<input type="checkbox" name="scm_option_expert_mode_installation" id="cache-master-expert-mode-installation-option-remove" value="remove" 
			<?php checked( $option_expert_mode_installation, 'remove' ); ?>>
		<label for="cache-master-expert-mode-installation-option-remove">
			<?php echo __( 'Restore', 'cache-master' ); ?><br />
		<label>
	</div>
	<p><?php echo sprintf( __( 'Click the checkbox if you would like to remove the Expert Mode code block from %s', 'cache-master' ), '<code>wp-config.php</code><p>' ); ?></p>
</div>

<?php endif; ?>