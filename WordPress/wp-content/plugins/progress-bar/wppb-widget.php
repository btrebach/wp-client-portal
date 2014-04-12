<?php
/**
 * WPPB Widget
 * allows the progress bar to be added to a configurable widget
 * @author Chris Reynolds
 * @since 2.0.1
 * @uses WP_Widget
 */
function wppb_register_widget() {
	register_widget( 'WPPB_Widget' );
}
add_action( 'widgets_init', 'wppb_register_widget' );

class WPPB_Widget extends WP_Widget {
	public function __construct() {
		$widget_options = array( 'classname' => 'wppb-widget', 'description' => __('Allows you to add a progress bar to your sidebar.', 'wp-progress-bar' ) );
		$control_options = array( 'id_base' => 'wppb-widget' );
		$this->WP_Widget( 'wppb-widget', __('Progress Bar', 'wp-progress-bar' ), $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		extract($args);

		if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = ''; }
		if ( isset( $instance['progress'] ) ) { $progress = $instance['progress']; } else { $progress = ''; }
		if ( isset( $instance['color'] ) ) { $color = $instance['color']; } else { $color = ''; } // a dropdown
		if ( isset( $instance['candystripe'] ) ) { $candystripe = $instance['candystripe']; } else { $candystripe = false; }
		if ( isset( $instance['location'] ) ) { $location = $instance['location']; } else { $location = ''; }
		if ( isset( $instance['text'] ) ) { $text = $instance['text']; } else { $text = ''; }
		if ( isset( $instance['description'] ) ) { $description = $instance['description']; } else { $text = ''; }

		echo $args['before_widget'];

		if ( !empty( $title ) )
			echo $args['before_title'] . esc_attr( $title ) . $args['after_title'];

		$wppb_check_results = wppb_check_pos($progress); // check the progress for a slash, indicating a fraction instead of a percent
		$percent = $wppb_check_results[0];
		$width = $wppb_check_results[1];

		if ( 'none' == $location )
			$location = null;

		$option = null;
		if ( $color )
			$option .= $color;
		if ( $candystripe )
			$option .= ' ' . $candystripe;

		$progress = $percent;
		$the_progress_bar = wppb_get_progress_bar($location, $text, $progress, $option, $width, 'true');
		echo $the_progress_bar;
		echo wpautop(wp_kses_post( $description ));

		echo $args['after_widget'];

	}

	public function form( $instance ) {
		$defaults = array( 'title' => '', 'progress' => '', 'color' => 'blue', 'candystripe' => 'none', 'location' => 'none', 'text' => '', 'description' => '' );
		$instance = wp_parse_args((array) $instance, $defaults);

		if ( isset( $instance['title'] ) ) { $title = apply_filters( 'widget_title', $instance['title'] ); } else { $title = ''; }
		if ( isset( $instance['progress'] ) ) { $progress = $instance['progress']; } else { $progress = ''; }
		if ( isset( $instance['color'] ) ) { $color = $instance['color']; } else { $color = ''; } // a dropdown
		if ( isset( $instance['candystripe'] ) ) { $candystripe = $instance['candystripe']; } else { $candystripe = false; } // a radio button
		if ( isset( $instance['location'] ) ) { $location = $instance['location']; } else { $location = ''; } // a dropdown
		if ( isset( $instance['text'] ) ) { $text = $instance['text']; } else { $text = ''; }
		if ( isset( $instance['description'] ) ) { $description = $instance['description']; } else { $description = ''; }
		?>
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>"><strong><?php _e( 'Title', 'wp-progress-bar' ); ?></strong></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php esc_attr_e($title); ?>" /><br />
			<span class="description"><?php _e( 'The widget title (optional).', 'wp-progress-bar' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name('progress'); ?>"><strong><?php _e( 'Progress', 'wp-progress-bar' ); ?></strong></label>
			<input size="4" id="<?php echo $this->get_field_id('progress'); ?>" name="<?php echo $this->get_field_name('progress'); ?>" type="text" value="<?php esc_attr_e($progress); ?>" /><br />
			<span class="description"><?php _e( 'Can be a numeric value or a fraction (like 5/6). (required)', 'wp-progress-bar' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name('color'); ?>"><strong><?php _e( 'Color', 'wp-progress-bar' ); ?></strong></label>
			<select name="<?php echo $this->get_field_name('color'); ?>" id="<?php echo $this->get_field_id('color'); ?>" class="widefat">
				<?php
				$colors = array(
					'red' => array(
						'name' => __( 'Red', 'wp-progress-bar' ),
						'value' => 'red'
					),
					'blue' => array(
						'name' => __( 'Blue', 'wp-progress-bar' ),
						'value' => ''
					),
					'green' => array(
						'name' => __( 'Green', 'wp-progress-bar' ),
						'value' => 'green'
					),
					'orange' => array(
						'name' => __( 'Orange', 'wp-progress-bar' ),
						'value' => 'orange'
					),
					'yellow' => array(
						'name' => __( 'Yellow', 'wp-progress-bar' ),
						'value' => 'yellow'
					)
				);
				foreach ( $colors as $hue ) {
					echo '<option value="' . $hue['value'] . '" id="' . $hue['value'] . '"', $color == $hue['value'] ? ' selected="selected"' : '', '>', $hue['name'], '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name('candystripe'); ?>"><strong><?php _e( 'Candystripe', 'wp-progress-bar' ); ?></strong></label>
			<fieldset>
			<label for="<?php echo $this->get_field_name('candystripe'); ?>"><input type="radio" id="<?php echo $this->get_field_id('candystripe'); ?>" name="<?php echo $this->get_field_name('candystripe'); ?>" value="candystripe" <?php checked('candystripe', $candystripe); ?> /> <?php _e( 'Candystripe', 'wp-progress-bar' ); ?></label><br />
			<label for="<?php echo $this->get_field_name('animated-candystripe'); ?>"><input type="radio" id="<?php echo $this->get_field_id('candystripe'); ?>" name="<?php echo $this->get_field_name('candystripe'); ?>" value="animated-candystripe" <?php checked('animated-candystripe', $candystripe); ?> /> <?php _e( 'Animated Candystripe', 'wp-progress-bar' ); ?></label><br />
			<label for="<?php echo $this->get_field_name('none'); ?>"><input type="radio" id="<?php echo $this->get_field_id('candystripe'); ?>" name="<?php echo $this->get_field_name('candystripe'); ?>" value="none" <?php checked('none', $candystripe); ?> /> <?php _e( 'None', 'wp-progress-bar' ); ?></label><br />
			</fieldset><br />
			<span class="description"><?php _e( 'Whether the progress bar should have a candystripe.', 'wp-progress-bar' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name('location'); ?>"><strong><?php _e( 'Location', 'wp-progress-bar' ); ?></strong></label>
			<select name="<?php echo $this->get_field_name('location'); ?>" id="<?php echo $this->get_field_id('location'); ?>" class="widefat">
				<?php
					$locations = array(
						'inside' => array(
							'name' => __( 'Inside', 'wp-progress-bar' ),
							'value' => 'inside'
						),
						'outside' => array(
							'name' => __( 'Outside', 'wp-progress-bar' ),
							'value' => 'outside'
						),
						'none' => array(
							'name' => __( 'None', 'wp-progress-bar' ),
							'value' => 'none'
						)
					);
					foreach ( $locations as $place ) {
						echo '<option value="' . $place['value'] . '" id="' . $place['value'] . '"', $location == $place['value'] ? ' selected="selected"' : '', '>', $place['name'], '</option>';
					}
				?>
			</select>
			<span class="description"><?php _e( 'Displays the progress either inside or outside the progress bar or not at all if "None" is selected.', 'wp-progress-bar' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name('text'); ?>"><strong><?php _e( 'Text', 'wp-progress-bar' ); ?></strong></label>
			<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php esc_attr_e($text); ?>" /><br />
			<span class="description"><?php _e( 'Custom text to display (instead of the progress value). (optional).', 'wp-progress-bar' ); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name('description'); ?>"><strong><?php _e( 'Description', 'wp-progress-bar' ); ?></strong></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php esc_attr_e($description); ?></textarea><br />
			<span class="description"><?php _e( 'A block of text that displays under the progress bar to describe what the progress bar is for. (optional).', 'wp-progress-bar' ); ?></span>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['progress'] = ( !empty( $new_instance['progress'] ) ) ? esc_html( $new_instance['progress'] ) : '';
		$instance['color'] = ( !empty( $new_instance['color'] ) ) ? strip_tags( $new_instance['color'] ) : '';
		$instance['candystripe'] = ( !empty( $new_instance['candystripe'] ) ) ? strip_tags( $new_instance['candystripe'] ) : '';
		$instance['location'] = ( !empty( $new_instance['location'] ) ) ? strip_tags( $new_instance['location'] ) : '';
		$instance['text'] = ( !empty( $new_instance['text'] ) ) ? wp_kses_post( $new_instance['text'] ) : '';
		$instance['description'] = ( !empty( $new_instance['description'] ) ) ? wp_kses_post( $new_instance['description'] ) : '';

		return $instance;
	}
}