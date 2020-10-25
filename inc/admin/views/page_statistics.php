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
	
	<?php if ( 'enable' === get_option( 'scm_option_statistics_status' ) ) : ?>
	
	<div class="scm-content-wrapper">
		
		<table class="table-stats-wrapper">
			<tr>
				<td class="stats-l">
					<form action="options.php" method="post">
					<table class="table-stats" cellpadding="0" cellspacing="0">
						<tr>
							<th><?php _e( 'Clear Cache', 'cache-master' ); ?></th>
							<th><?php _e( 'Cache Type', 'cache-master' ); ?></th>
							<th><?php _e( 'Rows', 'cache-master' ); ?></th>
							<th><?php _e( 'Total Size', 'cache-master' ); ?> (MB)</th>
						<tr>
						<?php foreach( scm_get_cache_type_list() as $key => $value ) : ?>
							<?php $stats_data = scm_get_stats( $key ); ?>
							<tr>
								<td id="option-item-<?php echo $key; ?>"></td>
								<td style="text-align: left;"><?php echo $value; ?></td>
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
							<td class="scm-total-size">
								<input type="radio" name="scm_option_clear_cache" id="cache-master-clear-cache-all-option-enable" value="all" >
							</td>
							<td class="scm-total-size" style="text-align: left;"><?php _e( 'All', 'cache-master' ); ?></td>
							<td class="scm-total-size"><?php echo $total_rows; ?></td>
							<td class="scm-total-size"><?php echo $total_size; ?></td>

						</tr>
					</table>
					<div id="show-form-clear-cache"></div>
					<?php submit_button( __( 'Confirm Clearing Cache', 'cache-master' ) ); ?>
					</form>
				</td>
				<td class="stats-r">
					<form action="options.php" method="post">
						<?php settings_fields( 'scm_setting_group_3' ); ?>
						<?php do_settings_sections( 'scm_setting_page_3' );  ?>
						<hr />
						<?php submit_button(); ?>
					</form>
				</td>
			</tr>
		</table>
	</div>
	<div id="hidden-form-clear-cache" style="display: none">
		<?php settings_fields( 'scm_setting_group_4' ); ?>
		<?php do_settings_sections( 'scm_setting_page_4' );  ?>
	</div>

	<?php else: ?>

		<form action="options.php" method="post">
			<?php settings_fields( 'scm_setting_group_3' ); ?>
			<?php do_settings_sections( 'scm_setting_page_3' );  ?>
			<hr />
			<?php submit_button(); ?>
		</form>
		<form action="options.php" method="post">
			<?php settings_fields( 'scm_setting_group_4' ); ?>
			<?php do_settings_sections( 'scm_setting_page_4' );  ?>
			<hr />
			<?php submit_button( __( 'Confirm Clearing Cache', 'cache-master' ) ); ?>
		</form>

	<?php endif; ?>

	
</div>

<script>
	(function($) {
		$(function() {
			$('.scm-cache-type-list').each(function() {
				var type = $(this).attr('data-type');
				var html = $(this).html();
				$('#option-item-' + type).html(html);
			});

			$('#hidden-form-clear-cache').find('input[type=hidden]').each(function() {
				$(this).appendTo('#show-form-clear-cache');
			});
		});
	})(jQuery);
</script>