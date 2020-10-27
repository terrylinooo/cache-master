<?php
/**
 * Class SCM_Benchmark_Widget
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Cache Master
 * @since 1.5.0
 * @version 1.5.0
 */

if ( ! defined( 'SCM_INC' ) ) {
	die;
}

/**
 * Display the WordPress benchmark report in the widget area.
 */
class SCM_Benchmark_Widget extends WP_Widget {

	/**
	 * Sets up a new widget instance.
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'                   => 'widget_scm_benchmark',
			'description'                 => __( 'Display the benchmark report before and after caching by Cache Master.', 'cache-master' ),
			'customize_selective_refresh' => true,
		);

		parent::__construct( 'scm_benchmark', __( 'Benchmark Report', 'cache-master' ), $widget_ops);
	}

	/**
	 * Outputs the content for the Mynote TOC instance.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		
		echo '<div class="cache-master-plugin-widget-wrapper" style="display: none">';
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
 
		?>
			<div class="cache-master-plugin-widget">
				<div class="scm-table">
					<div class="scm-tr">
						<div class="scm-td">
							<span class="scm-img scm-img-1" title="<?php echo esc_attr__( 'Cache status powered by Cache Master plugin', 'cache-master' ); ?>"><?php echo scm_get_svg_icon( 'status' ); ?></span>
							<span class="scm-text"><?php _e( 'Cache status', 'cache-master' ); ?></span>
						</div>
						<div class="scm-td">
							<span class="scm-field-cache-status">-</span>
						</div>
					</div>
					<div class="scm-tr">
						<div class="scm-td">
							<span class="scm-img scm-img-2" title="<?php echo esc_attr__( 'Memory usage', 'cache-master' ); ?>"><?php echo scm_get_svg_icon( 'memory' ); ?></span>
							<span class="scm-text"><?php _e( 'Memory usage', 'cache-master' ); ?></span>
						</div>
						<div class="scm-td">
							<span class="scm-field-memory-usage">-</span> MB
						</div>
					</div>
					<div class="scm-tr">
						<div class="scm-td">
							<span class="scm-img scm-img-3" title="<?php echo esc_attr__( 'SQL queries', 'cache-master' ); ?>"><?php echo scm_get_svg_icon( 'database' ); ?></span>
							<span class="scm-text"><?php _e( 'SQL queries', 'cache-master' ); ?></span>
						</div>
						<div class="scm-td">
							<span class="scm-field-sql-queries">-</span>
						</div>
					</div>
					<div class="scm-tr">
						<div class="scm-td">
							<span class="scm-img scm-img-4" title="<?php echo esc_attr__( 'Page generation time', 'cache-master' ); ?>"><?php echo scm_get_svg_icon( 'speed' ); ?></span>
							<span class="scm-text"><?php _e( 'Page generation time', 'cache-master' ); ?></span>
						</div>
						<div class="scm-td">
							<span class="scm-field-page-generation-time">-</span> (<?php _e( 'sec', 'cache-master' ); ?>)
						</div>
					</div>
				</div>
			</div>
		<?php

		echo '</div>';

		echo $args['after_widget'];
	}

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
		$title = __( 'Cache Master', 'cache-master' );

        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        ?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
    	<?php
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
		$instance = array();

        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
        return $instance;
    }

	/**
	 * Flushes the widget cache.
	 */
	public function flush_widget_cache() {
		_deprecated_function( __METHOD__, '4.4.0' );
	}
}