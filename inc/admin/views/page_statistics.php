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

	if ( is_dir( $dir ) ) {
		foreach ( new DirectoryIterator( $dir ) as $file ) {
			if ( $file->isFile() && $file->getExtension() === 'json' ) {
				$nums++;
				$size += (int) file_get_contents( $file->getPathname() );
			}
		}
	} else {
		wp_mkdir_p( $dir );
	}

	return array(
		'nums' => $nums,
		'size' => $size,
	);
}

$total_size = 0;
$total_rows = 0;

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
		<table class="table-stats-wrapper">
			<tr>
				<td class="stats-l">
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
								<td>
									<?php

										$size = round( $stats_data['size'] / ( 1024 * 1024 ), 2);

										if ( $size > 100 ) {
											echo '<span class="scm-warning">' . $size . '</span>';
										} else {
											echo '<span class="scm-info">' . $size . '</span>';
										}

										$total_size += $size;
										$total_rows += $stats_data['nums'];
									?>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr>
							<td></td>
							<td class="scm-total-size"><?php echo $total_rows; ?></td>
							<td class="scm-total-size"><?php echo $total_size; ?></td>
						</tr>
					</table>
				</td>
				<td class="stats-r">
					<form action="options.php" method="post">
					<?php settings_fields( 'scm_setting_group_4' ); ?>
					<?php do_settings_sections( 'scm_setting_page_4' );  ?>
					<hr />
					<?php submit_button( __( 'Confirm Clearing Cache', 'cache-master' ) ); ?>
				</td>
			</tr>
		</table>
	</div>

	<?php else: ?>
		<form action="options.php" method="post">
		<?php settings_fields( 'scm_setting_group_4' ); ?>
		<?php do_settings_sections( 'scm_setting_page_4' );  ?>
		<hr />
		<?php submit_button( __( 'Confirm Clearing Cache', 'cache-master' ) ); ?>
	</form>

	<?php endif; ?>
</div>
