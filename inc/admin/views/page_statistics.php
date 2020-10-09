<?php
/**
 * Cache Master - Stats
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.4.0
 * @version 1.4.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

function scm_get_stats( $type ) {
	$dir = scm_get_stats_dir( $type );

	$nums = 0;
	$size = 0;

	foreach ( new DirectoryIterator( $dir ) as $file ) {
		if ( $file->isFile() && $file->getExtension() === 'json' ) {
			$nums++;
			$size += (int) file_get_contents( $file->getPathname() );
		}
	}

	return array(
		'nums' => $nums,
		'size' => $size,
	);
}

?>

<div id="scm-statistic-page">
	
	<form action="options.php" method="post">
		<?php settings_fields( 'scm_setting_group_3' ); ?>
		<?php do_settings_sections( 'scm_setting_page_3' );  ?>
		<hr />
		<?php submit_button(); ?>
	</form>

	<?php if ( 'enable' === get_option( 'scm_option_statistics_status' ) ) : ?>
	<div class="scm-content-wrapper">
		<table class="table-stats">
			<tr>
				<th><?php _e( 'Cache type', 'cache-master' ); ?></th>
				<th><?php _e( 'Rows', 'cache-master' ); ?></th>
				<th><?php _e( 'Total size', 'cache-master' ); ?> (MB)</th>
			<tr>
			<?php foreach( scm_get_cache_type_list() as $key => $value ) : ?>
				<?php $stats_data = scm_get_stats( $key ); ?>
				<tr>
					<td><?php echo $value; ?></td>
					<td><?php echo $stats_data['nums']; ?></td>
					<td><?php echo round( $stats_data['size'] / ( 1024 * 1024 ), 2); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<?php endif; ?>

	<form action="options.php" method="post">
		<?php settings_fields( 'scm_setting_group_4' ); ?>
		<?php do_settings_sections( 'scm_setting_page_4' );  ?>
		<hr />
		<?php submit_button( __( 'Confirm Clearing Cache', 'cache-master' ) ); ?>
	</form>
</div>
