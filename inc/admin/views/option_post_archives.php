<?php

/**
 * Cache Master - Post Archives
 *
 * @author Terry Lin, Yannick Lin
 * @link https://terryl.in/
 * @since 1.3.0
 * @version 1.3.0
 */

if (!defined('SCM_INC')) {
	die;
}


$option_post_archives = get_option('scm_option_post_archives');

$option_list = array(
	'category' => __('Category', 'cache-master'),
	'tag'      => __('Tag', 'cache-master'),
	'date'     => __('Date', 'cache-master'),
	'author'   => __('Author', 'cache-master'),
);


// Custom Post Type Archives
$args = array(
	'public'   => true,
	'has_archive' => true,
	'_builtin' => false
);
$cpt_archives = get_post_types($args, 'objects', 'and');

foreach ($cpt_archives as $cpt_archive) {
	$option_list = array_merge($option_list, array(
		("archive_" . $cpt_archive->name) => ('Archive for ' . $cpt_archive->labels->singular_name)
	));
}

?>

<div>
	<?php foreach ($option_list as $k => $v) : ?>
		<div class="scm-option-item">
			<input type="checkbox" name="scm_option_post_archives[<?php echo $k; ?>]" id="cache-master-post-archive-option-<?php echo $k; ?>" value="yes" <?php if (isset($option_post_archives[$k])) : ?> <?php checked($option_post_archives[$k], 'yes'); ?> <?php endif; ?>>
			<label for="cache-master-post-archive-option-<?php echo $k; ?>">
				<?php echo $v; ?><br />
				<label>
		</div>
	<?php endforeach; ?>
</div>
<p><em><?php _e('What type of archive page do you like to cache?', 'cache-master'); ?></em></p>