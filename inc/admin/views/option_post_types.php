<?php

/**
 * Cache Master - Post types.
 *
 * @author Terry Lin, Yannick Lin
 * @link https://terryl.in/
 * @since 1.2.1
 * @version 1.3.1
 */

if (!defined('SCM_INC')) {
	die;
}

$option_post_types = get_option('scm_option_post_types');

$option_list = array(
	'post' => __('Post', 'cache-master'),
	'page' => __('Page', 'cache-master'),
);

$args = array(
	'public'   => true,
	'_builtin' => false
);

$custom_post_types = get_post_types($args, 'objects', 'and');
?>

<div>
	<?php foreach ($option_list as $k => $v) : ?>
		<div class="scm-option-item">
			<input type="checkbox" name="scm_option_post_types[<?php echo $k; ?>]" id="cache-master-post-type-option-<?php echo $k; ?>" value="yes" <?php if (isset($option_post_types[$k])) : ?> <?php checked($option_post_types[$k], 'yes'); ?> <?php endif; ?>>
			<label for="cache-master-post-type-option-<?php echo $k; ?>">
				<?php echo $v; ?><br />
				<label>
		</div>
	<?php endforeach; ?>

	<?php foreach ($custom_post_types as $post_type) : ?>
		<div class="scm-option-item">
			<input type="checkbox" name="scm_option_post_types[<?php echo $post_type->name; ?>]" id="cache-master-post-type-option-<?php echo $post_type->name; ?>" value="yes" <?php if (isset($option_post_types[$post_type->name])) : ?> <?php checked($option_post_types[$post_type->name], 'yes'); ?> <?php endif; ?>>
			<label for="cache-master-post-type-option-<?php echo $post_type->name; ?>">
				<?php echo $post_type->labels->singular_name; ?><br />
				<label>
		</div>
	<?php endforeach; ?>

</div>
<p><em><?php _e('What post type do you like to cache?', 'cache-master'); ?></em></p>