<?php
/**
 * Brightness
 * calculates a brighter or darker color based on the hex value given
 * @since 1.1
 * @link http://lab.clearpixel.com.au/2008/06/darken-or-lighten-colours-dynamically-using-php/
 * @param string $hex REQUIRED the hex color value
 * @param string $percent REQUIRED how much the offset should be
 * usage: wppb_brightness('ff0000','0.2')
 */
function wppb_brightness($hex, $percent) {
	/**
	 * Work out if hash given
	 */
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/**
	 * HEX TO RGB
	 */
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent);// + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	/**
	 * RBG to Hex
	 */
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

/**
 * WPPB Check position
 * does a check for a slash or a dollar sign and deals with them appropriately
 * originally added by [RavanH](https://github.com/RavanH) in 1.0.4
 * abstracted to a function in 2.0
 * @author Chris Reynolds
 * @author [RavanH](https://github.com/RavanH)
 * @since 2.0
 */
function wppb_check_pos($progress) {
	$pos = strpos($progress, '/');
	if($pos===false) {
		$width = $progress . "%";
		$progress = $progress . " %";
	} else {
		$dollar = strpos($progress, '$');
		if ( $dollar === false ) {
			/**
			 * this could be used for other currencies, potentially, though if it was, it should be changed into a case instead of an if statement
			 */
		} else {
			/**
			 * if there's a dollar sign in the progress, it will break the math
			 * let's strip it out so we can add it back later
			 */
			$progress = str_replace('$', '', $progress);
		}
		$xofy = explode('/',$progress);
		if (!$xofy[1])
			$xofy[1] = 100;
		$percentage = $xofy[0] / $xofy[1] * 100;
		$width = $percentage . "%";
		if ( $dollar === false ) {
			$progress = number_format_i18n( $xofy[0] ) . " / " . number_format_i18n( $xofy[1] );
		} else {
			/**
			 * if there's a dollar sign in the progress, display it manually
			 */
			$progress = '$' . number_format_i18n( $xofy[0] ) . ' / $' . number_format_i18n( $xofy[1] );
		}
	}
	return array($progress,$width); // pass both the progress and the width back
}

/**
 * WPPB Get Progress Bar
 * gets all the parameters passed to the shortcode and constructs the progress bar
 * @param $location - inside, outside, null (default: null)
 * @param $fullwidth - any value (default: null)
 * @param $text - any custom text (default: null)
 * @param $progress - the progress to display (required)
 * @param $option - any applicable options (default: null)
 * @param $width - the width of the progress bar, based on $progress (required)
 * @param $color - custom color for the progress bar (default: null)
 * @param $gradient - custom gradient value, in decimals (default: null)
 * @param $gradient_end gradient end color, based on the endcolor parameter or $gradient (default: null)
 * @author Chris Reynolds
 * @since 2.0
 */
function wppb_get_progress_bar($location = false, $text = false, $progress, $option = false, $width, $fullwidth = false, $color = false, $gradient = false, $gradient_end = false) {
	/**
	 * here's the html output of the progress bar
	 */
	$wppb_output	= "<div class=\"wppb-wrapper $location"; // adding $location to the wrapper class, so I can set a width for the wrapper based on whether it's using div.wppb-wrapper.after or div.wppb-wrapper.inside or just div.wppb-wrapper
	if ( $fullwidth ) {
		$wppb_output .= " full";
	}
	$wppb_output .= "\">";
	if ( $location && $text) { // if $location is not empty and there's custom text, add this
		$wppb_output .= "<div class=\"$location\">" . wp_kses($text, array()) . "</div>";
	} elseif ( $location && !$text ) { // if the $location is set but there's no custom text
		$wppb_output .= "<div class=\"$location\">";
		$wppb_output .= $progress;
		$wppb_output .= "</div>";
	} elseif ( !$location && $text) { // if the location is not set, but there is custom text
		$wppb_output .= "<div class=\"inside\">" . wp_kses($text, array()) . "</div>";
	}
	$wppb_output 	.= 	"<div class=\"wppb-progress";
	if ($fullwidth) {
		$wppb_output .= " full";
	} else {
		$wppb_output .= " fixed";
	}
	$wppb_output 	.= "\">";
	$wppb_output	.= "<span";
	if ($option) {
		$wppb_output .= " class=\"{$option}\"";
	}
	if ($color) { // if color is set
		$wppb_output .= " style=\"width: $width; background: {$color};";
		if ($gradient_end) {
			$wppb_output .= "background: -moz-linear-gradient(top, {$color} 0%, $gradient_end 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,{$color}), color-stop(100%,$gradient_end)); background: -webkit-linear-gradient(top, {$color} 0%,$gradient_end 100%); background: -o-linear-gradient(top, {$color} 0%,$gradient_end 100%); background: -ms-linear-gradient(top, {$gradient} 0%,$gradient_end 100%); background: linear-gradient(top, {$color} 0%,$gradient_end 100%); \"";
		}
	} else {
		$wppb_output .= " style=\"width: $width;";
	}
	if ($gradient && $color) {
		$wppb_output .= "background: -moz-linear-gradient(top, {$color} 0%, $gradient_end 100%); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,{$color}), color-stop(100%,$gradient_end)); background: -webkit-linear-gradient(top, {$color} 0%,$gradient_end 100%); background: -o-linear-gradient(top, {$color} 0%,$gradient_end 100%); background: -ms-linear-gradient(top, {$gradient} 0%,$gradient_end 100%); background: linear-gradient(top, {$color} 0%,$gradient_end 100%); \"";
	} else {
		$wppb_output .= "\"";
	}
	$wppb_output	.= "><span></span></span>";
	$wppb_output	.=	"</div>";
	$wppb_output	.= "</div>";
	/**
	 * now return the progress bar
	 */
	return $wppb_output;
}