<?php
/*
Plugin Name: Progress Bar
Plugin URI: http://museumthemes.com/progress-bar/
Description: a simple progress bar shortcode that can be styled with CSS
Version: 2.1.1
Author: Chris Reynolds
Author URI: http://museumthemes.com
License: GPL3
*/

/*
	Progress Bar
    Copyright (C) 2013 | Chris Reynolds (chris@arcanepalette.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    http://www.opensource.org/licenses/gpl-3.0.html
*/

include ( plugin_dir_path( __FILE__ ) . 'wppb-widget.php' );
include ( plugin_dir_path( __FILE__ ) . 'functions.php' );

/**
 * wppb_init
 * loads the css and javascript
 * @author Chris Reynolds
 * @since 0.1
 */

function wppb_init() {
	$wppb_path = plugin_dir_url( __FILE__ );
	if ( !is_admin() ) { // don't load this if we're in the backend
		wp_register_style( 'wppb_css', $wppb_path . 'css/wppb.css' );
		wp_enqueue_style( 'wppb_css' );
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'wppb_animate', $wppb_path . 'js/wppb_animate.js', 'jquery' );
		wp_enqueue_script ( 'wppb_animate' );
	}
}
add_action( 'init', 'wppb_init' );

/**
 * Progress Bar
 * simple shortcode that displays a progress bar
 * @author Chris Reynolds
 * @since 0.1
 * @param string $progress REQUIRED displays the actual progress bar in % or in x/y
 * usage: [wppb progress=50] or [wppb progress=500/1000]
 * @param string $option OPTIONAL calls various options. These can be user-input (uses CSS classes, so anything a user adds to their CSS could
 * potentially be used as an option) or any of the pre-defined options/styles. Included options (as of 1.0.1): candystripes, animated-candystripes,
 * red
 * usage: [wppb progress=50 option="red candystripes"]
 * usage: [wppb progress=50 option=animated-candystripes]
 * @param string $percent OPTIONAL displays the percentage either on the bar itself, or after the progress bar, depending on which parameter is used.
 * Options are 'after' and 'inside'.
 * usage: [wppb progress=50 percent=after]
 * @param bool $fullwidth OPTIONAL if present (really, if this is in the shortcode at all), will stretch the progress bar to 100% width
 * usage: [wppb progress=50 fullwidth=true]
 * @param string $color OPTIONAL sets a color for the progress bar that overrides the default color. can be used as a starting color for $gradient
 * usage: [wppb progress=50 color=ff0000]
 * usage: [wppb progress=50 color=ff0000 gradient=.1]
 * @param string $gradient OPTIONAL @uses $color adds an end color that is the number of degrees offset from the $color parameter and uses it for a
 * gradient
 * $color parameter is REQUIRED for $gradient
 * @uses wppb_check_pos
 * usage: [wppb progress=50 color=ff0000 gradient=.1]
 */

function wppb( $atts ) {
	extract( shortcode_atts( array(
		'progress' => '',		// the progress in % or x/y
		'option' => '',			// what options you want to use (candystripes, animated-candystripes, red)
		'percent' => '',		// whether you want to display the percentage and where you want that to go (after, inside) (deprecated)
		'location' => '',		// replaces $percent
		'fullwidth' => '',		// determines if the progress bar should be full width or not
		'color' => '',			// this will set a static color value for the progress bar, or a starting point for the gradient
		'gradient' => '',		// will set a positive or negative end result based on the color, e.g. gradient=1 will be 100% brighter, gradient=-0.2 will be 20% darker
		'endcolor' => '',		// defines an end color for a custom gradient
		'text' => ''			// allows you to define custom text instead of a percent.
		), $atts ) );

	$wppb_check_results = wppb_check_pos($progress); // check the progress for a slash, indicating a fraction instead of a percent
	$percent = $wppb_check_results[0];
	$width = $wppb_check_results[1];

	/**
	 * if percent is set instead of location, set the location value to be the same as percent
	 */
	if ( isset($atts['percent']) && !isset($atts['location']) ) {
		$location = $atts['percent'];
	} elseif ( isset($atts['location']) ) {
		$location = $atts['location'];
	}

	/**
	 * if there's custom text and no location has been defined, make the location inside
	 */
	if ( $text && !$location )
		$location = 'inside';


	/**
	 * sanitize any text content
	 */
	if ( isset($atts['text']) ) {
		$text = strip_tags($atts['text']);
	}

	/**
	 * figure out gradient stuff
	 */
	$gradient_end = null;
	if ( isset($atts['endcolor']) ) {
		$gradient_end = $atts['endcolor'];
	}
	if ( isset( $atts['gradient'] ) && isset( $atts['color'] ) ) { // if a color AND gradient is set (gradient won't work without the starting color)
		$gradient_end = wppb_brightness( $atts['color'] , $atts['gradient'] );
	}

	if ( isset($atts['fullwidth']) )
		$fullwidth = true;

	$progress = $wppb_check_results[0];
	/**
	 * get the progress bar
	 */
	$wppb_output = wppb_get_progress_bar($location, $text, $progress, $option, $width, $fullwidth, $color, $gradient, $gradient_end);
	return $wppb_output;
}
add_shortcode('wppb','wppb');