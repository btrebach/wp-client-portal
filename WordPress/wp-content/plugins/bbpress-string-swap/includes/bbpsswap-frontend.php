<?php
/**
 * Filter functions and display logic for the frontend display of changed strings.
 *
 * @package    bbPress String Swap
 * @subpackage Frontend
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/bbpress-string-swap/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.0.0
 */

/**
 * Exit if accessed directly.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Display the Forums Archive title.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_forums_title
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_forum_archive_title( $bbpsswap_forums_title ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_forums_title = esc_html( $bbpsswap_options[ 'forums_archive_title' ] );

	/** Check for empty string */
	if ( empty( $bbpsswap_forums_title ) ) {

		$bbpsswap_forums_title = __( 'Forums', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_forum_archive_title', $bbpsswap_forums_title );

}  // end of function ddw_bbpsswap_display_bbpress_forum_archive_title


/**
 * Display the Breadcrumb Home Text.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_breadcrumb_args
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_breadcrumb_home_text( $bbpsswap_breadcrumb_args ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_breadcrumb_args[ 'home_text' ] = esc_html( $bbpsswap_options[ 'breadcrumb_args_home_text' ] );

	/** Check for empty string */
	if ( empty( $bbpsswap_breadcrumb_args[ 'home_text' ] ) ) {

		$bbpsswap_breadcrumb_args[ 'home_text' ] = esc_attr__( 'Home', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_breadcrumb_home_text', $bbpsswap_breadcrumb_args );

}  // end of function ddw_bbpsswap_display_bbpress_breadcrumb_home_text


/**
 * Display the Breadcrumb Root Text.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_breadcrumb_args
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_breadcrumb_root_text( $bbpsswap_breadcrumb_args ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_breadcrumb_args[ 'root_text' ] = esc_html( $bbpsswap_options[ 'breadcrumb_args_root_text' ] );

	/** Check for empty string */
	if ( empty( $bbpsswap_breadcrumb_args[ 'root_text' ] ) ) {

		$bbpsswap_breadcrumb_args[ 'root_text' ] = esc_attr__( 'Forums', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_breadcrumb_root_text', $bbpsswap_breadcrumb_args );

}  // end of function ddw_bbpsswap_display_bbpress_breadcrumb_root_text


/**
 * Display the Breadcrumb Separator String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.0.0
 *
 * @param  string $bbpsswap_breadcrumb_args_sep
 *
 * @return string
 */
function ddw_bbpsswap_display_bbpress_breadcrumb_sep( $bbpsswap_breadcrumb_args_sep ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_breadcrumb_args_sep[ 'sep' ] = $bbpsswap_options[ 'breadcrumb_args_sep' ];

	/** Check for empty string */
	if ( empty( $bbpsswap_breadcrumb_args_sep[ 'sep' ] ) ) {

		$bbpsswap_breadcrumb_args_sep[ 'sep' ] = esc_attr__( '&rsaquo;', 'bbpress-string-swap' );

	}

	return apply_filters( 'bbpsswap_filter_breadcrumb_sep', $bbpsswap_breadcrumb_args_sep );

}  // end of function ddw_bbpsswap_display_bbpress_breadcrumb_sep


/**
 * Helper function:
 * Search for a specific translation string and add changed text.
 *    NOTE: Provides fallback to default value if option is empty.
 *          Also works for default installs ('en_US' locale).
 *
 * @since  1.4.0
 *
 * @uses   get_option()
 *
 * @param  string $option_key Option key of our own options array.
 * @param  array  $strings Array of original text strings used by bbPress.
 * @param  string $default_translation A fallback default translation if the
 *                                     user setting may be empty.
 *
 * @global $l10n
 *
 * @return string Changed string for display. Merged to global object $l10n/MO.
 */
function ddw_bbpsswap_custom_strings_via_l10n_global( $option_key, $strings, $default_translation ) {

	global $l10n;

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	foreach ( (array) $strings as $string ) {

		/** Set label logic */
		$custom_label = ( ! empty( $bbpsswap_options[ $option_key ] ) ) ? $bbpsswap_options[ $option_key ] : $default_translation;

		/** Tweak/add translation/custom label within bbPress textdomain */
		if ( isset( $l10n[ 'bbpress' ] )
				&& isset( $l10n[ 'bbpress' ]->entries[ $string ] )
		) {

			$l10n[ 'bbpress' ]->entries[ $string ]->translations[0] = $custom_label;

		} else {

			$mo = new MO();

			$mo->add_entry(
				array(
					'singular'     => $string,
					'translations' => array( $custom_label )
				)
			);

			if ( isset( $l10n[ 'bbpress' ] ) ) {

				$mo->merge_with( $l10n[ 'bbpress' ] );

			}
		 
			$l10n[ 'bbpress' ] = &$mo;

			//unset( $mo );

		}  // end if

	}  // end foreach
	
}  // end of function ddw_bbpsswap_custom_strings_via_l10n_global


add_action( 'init', 'ddw_bbpsswap_do_string_swaps' );
/**
 * Passing an array of labels to our helper function to do string swaps.
 *    NOTE: Most of the used strings are currently not filterable by itself.
 *          So using translations global variable and merging to the "MO" object
 *          is the only way. AND, we avoid the 'gettext' filter with that, which
 *          is by intention, and a must performance-wise!
 *
 * @since 1.4.0
 *
 * @uses  ddw_bbpsswap_custom_strings_via_l10n_global()
 */
function ddw_bbpsswap_do_string_swaps() {

	$bbpsswap_labels = array(

		/**
		 * bbPress User roles
		 */

		/** Key Master */
		'keymaster' => array(
			'option_key'  => 'user_display_key_master',
			'strings'     => array( 'Key Master', 'Keymaster' ),
			'translation' => __( 'Key Master', 'bbpress-string-swap' ),
		),

		/** Moderator */
		'moderator' => array(
			'option_key'  => 'user_display_moderator',
			'strings'     => array( 'Moderator' ),
			'translation' => __( 'Moderator', 'bbpress-string-swap' ),
		),

		/** Participant */
		'participant' => array(
			'option_key'  => 'user_display_participant',
			'strings'     => array( 'Participant' ),
			'translation' => __( 'Participant', 'bbpress-string-swap' ),
		),

		/** Member */
		'member' => array(
			'option_key'  => 'user_display_member',
			'strings'     => array( 'Member' ),
			'translation' => __( 'Member', 'bbpress-string-swap' ),
		),

		/** Spectator */
		'spectator' => array(
			'option_key'  => 'user_display_spectator',
			'strings'     => array( 'Spectator' ),
			'translation' => __( 'Spectator', 'bbpress-string-swap' ),
		),

		/** Visitor */
		'visitor' => array(
			'option_key'  => 'user_display_visitor',
			'strings'     => array( 'Visitor' ),
			'translation' => __( 'Visitor', 'bbpress-string-swap' ),
		),

		/** Blocked */
		'blocked' => array(
			'option_key'  => 'user_display_blocked',
			'strings'     => array( 'Blocked' ),
			'translation' => __( 'Blocked', 'bbpress-string-swap' ),
		),

		/** Guest */
		'guest' => array(
			'option_key'  => 'user_display_guest',
			'strings'     => array( 'Guest' ),
			'translation' => __( 'Guest', 'bbpress-string-swap' ),
		),

		/**
		 * Various strings
		 */

		/** Posts */
		'posts' => array(
			'option_key'  => 'display_posts',
			'strings'     => array( 'Posts' ),
			'translation' => __( 'Posts', 'bbpress-string-swap' ),
		),

		/** Started-by */
		'startedby' => array(
			'option_key'  => 'display_startedby',
			'strings'     => array( 'Started by: %1$s' ),
			'translation' => __( 'Started by: %1$s', 'bbpress-string-swap' ),
		),

		/** Freshness */
		'freshness' => array(
			'option_key'  => 'display_freshness',
			'strings'     => array( 'Freshness' ),
			'translation' => __( 'Freshness', 'bbpress-string-swap' ),
		),

		/** Voices */
		'voices' => array(
			'option_key'  => 'display_voices',
			'strings'     => array( 'Voices' ),
			'translation' => __( 'Voices', 'bbpress-string-swap' ),
		),

		/** Submit */
		'submit' => array(
			'option_key'  => 'display_submit',
			'strings'     => array( 'Submit' ),
			'translation' => __( 'Submit', 'bbpress-string-swap' ),
		),

		/**
		 * No [...] strings
		 */

		/** No Forums */
		'no_forums' => array(
			'option_key'  => 'display_no_forums',
			'strings'     => array( 'Oh bother! No forums were found here!' ),
			'translation' => __( 'Oh bother! No forums were found here!', 'bbpress-string-swap' ),
		),

		/** No Topics */
		'no_topics' => array(
			'option_key'  => 'display_no_topics',
			'strings'     => array( 'Oh bother! No topics were found here!' ),
			'translation' => __( 'Oh bother! No topics were found here!', 'bbpress-string-swap' ),
		),

		/** No Replies */
		'no_replies' => array(
			'option_key'  => 'display_no_replies',
			'strings'     => array( 'Oh bother! No replies were found here!' ),
			'translation' => __( 'Oh bother! No replies were found here!', 'bbpress-string-swap' ),
		),

		/** No Search Results */
		'no_search_results' => array(
			'option_key'  => 'display_no_search_results',
			'strings'     => array( 'Oh bother! No search results were found here!' ),
			'translation' => __( 'Oh bother! No search results were found here!', 'bbpress-string-swap' ),
		),

	);  // end of array

	/** Apply our translation loader for each add-on, if active */
	foreach ( $bbpsswap_labels as $bbpsswap_label => $label_id ) {

		/** Actually load the various textdomains for displaying translations */
		ddw_bbpsswap_custom_strings_via_l10n_global(
			$label_id[ 'option_key' ],
			(array) $label_id[ 'strings' ],
			$label_id[ 'translation' ]
		);

	}  // end foreach

}  // end of function ddw_bbpsswap_do_string_swaps


/**
 * Display the Topic Pagination Prev String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_topic_pagination_prev
 *
 * @return string
 */
function ddw_bbpsswap_display_topic_pagination_prev( $bbpsswap_topic_pagination_prev ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_topic_pagination_prev[ 'prev_text' ] = $bbpsswap_options[ 'topic_pagination_prev_text' ];

	/** Check for empty string */
	if ( empty( $bbpsswap_topic_pagination_prev[ 'prev_text' ] ) ) {

		$bbpsswap_topic_pagination_prev['prev_text'] = esc_attr__( '&larr;', 'bbpress-string-swap' );

	}  // end if

	return apply_filters( 'bbpsswap_filter_topic_pagination_prev', $bbpsswap_topic_pagination_prev );

}  // end of function ddw_bbpsswap_display_topic_pagination_prev


/**
 * Display the Topic Pagination Next String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_topic_pagination_next
 *
 * @return string
 */
function ddw_bbpsswap_display_topic_pagination_next( $bbpsswap_topic_pagination_next ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_topic_pagination_prev[ 'next_text' ] = $bbpsswap_options[ 'topic_pagination_next_text' ];

	/** Check for empty string */
	if ( empty( $bbpsswap_topic_pagination_next[ 'next_text' ] ) ) {

		$bbpsswap_topic_pagination_next['next_text'] = esc_attr__( '&rarr;', 'bbpress-string-swap' );

	}  // end if

	return apply_filters( 'bbpsswap_filter_topic_pagination_next', $bbpsswap_topic_pagination_next );

}  // end of function ddw_bbpsswap_display_topic_pagination_next


/**
 * Display the Reply Pagination Prev String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_reply_pagination_prev
 *
 * @return string
 */
function ddw_bbpsswap_display_reply_pagination_prev( $bbpsswap_reply_pagination_prev ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_reply_pagination_prev[ 'prev_text' ] = $bbpsswap_options[ 'reply_pagination_prev_text' ];

	/** Check for empty string */
	if ( empty( $bbpsswap_reply_pagination_prev[ 'prev_text' ] ) ) {

		$bbpsswap_reply_pagination_prev['prev_text'] = esc_attr__( '&larr;', 'bbpress-string-swap' );

	}  // end if

	return apply_filters( 'bbpsswap_filter_reply_pagination_prev', $bbpsswap_reply_pagination_prev );

}  // end of function ddw_bbpsswap_display_reply_pagination_prev


/**
 * Display the Reply Pagination Next String.
 *
 * If the text string is empty, fall back to the default value.
 *
 * @since  1.1.0
 *
 * @param  string $bbpsswap_reply_pagination_next
 *
 * @return string
 */
function ddw_bbpsswap_display_reply_pagination_next( $bbpsswap_reply_pagination_next ) {

	/** Get our option */
	$bbpsswap_options = get_option( 'bbpsswap-options' );

	$bbpsswap_reply_pagination_prev[ 'next_text' ] = $bbpsswap_options[ 'reply_pagination_next_text' ];

	/** Check for empty string */
	if ( empty( $bbpsswap_reply_pagination_next[ 'next_text' ] ) ) {

		$bbpsswap_reply_pagination_next['next_text'] = esc_attr__( '&rarr;', 'bbpress-string-swap' );

	}  // end if

	return apply_filters( 'bbpsswap_filter_reply_pagination_next', $bbpsswap_reply_pagination_next );

}  // end of function ddw_bbpsswap_display_reply_pagination_next