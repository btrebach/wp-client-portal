<?php
/**
 * Various helper functions, mostly for the admin area.
 *
 * @package    bbPress String Swap
 * @subpackage Helper functions
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/bbpress-string-swap/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.4.0
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
 * Various user checks.
 *
 * @since 1.4.0
 *
 * @uses  is_user_logged_in()
 * @uses  current_user_can()
 * @uses  wp_die()
 */
function ddw_bbpsswap_delete_legacy_options() {

	/** Check for logged in user first */
	if ( ! is_user_logged_in() ) {

		wp_die(
			__( 'You must be logged in to run this script.', 'bbpress-string-swap' ),
			__( 'bbPress String Swap', 'bbpress-string-swap' ),
			array( 'back_link' => true )
		);

	}  // end if user login check

	/** Check for adequate capibility second. */
	if ( ! current_user_can( 'install_plugins' ) ) {

		wp_die(
			__( 'You do not have permission to run this script.', 'bbpress-string-swap' ),
			__( 'bbPress String Swap', 'bbpress-string-swap' ),
			array( 'back_link' => true )
		);

	}  // end if user cap check

	/** Array of the legacy option keys */
	$bbpsswap_legacy_option_keys = array(
		'ddw_bbpress_forums_archive_title',
		'ddw_bbpress_breadcrumb_args_home_text',
		'ddw_bbpress_breadcrumb_args_root_text',
		'ddw_bbpress_breadcrumb_args_separator',
		'ddw_bbpress_user_display_key_master',
		'ddw_bbpress_user_display_moderator',
		'ddw_bbpress_user_display_participant',
		'ddw_bbpress_user_display_spectator',
		'ddw_bbpress_user_display_visitor',
		'ddw_bbpress_user_display_blocked',
		'ddw_bbpress_user_display_member',
		'ddw_bbpress_user_display_guest',
		'ddw_bbpress_display_posts',
		'ddw_bbpress_display_startedby',
		'ddw_bbpress_display_freshness',
		'ddw_bbpress_display_voices',
		'ddw_bbpress_display_submit',
		'ddw_bbpress_topic_pagination_prev_text',
		'ddw_bbpress_topic_pagination_next_text',
		'ddw_bbpress_reply_pagination_prev_text',
		'ddw_bbpress_reply_pagination_next_text'
	);


	/**
	 * Delete our options array (settings field) from the database.
	 *    Note: Respects Multisite setups and single installs.
	 *
	 * @since 1.4.0
	 *
	 * @uses  switch_to_blog()
	 * @uses  restore_current_blog()
	 *
	 * @param array $blogs
	 * @param int 	$blog
	 *
	 * @global $wpdb
	 */
	/** First, check for Multisite, if yes, delete options on a per site basis */
	if ( is_multisite() ) {

		global $wpdb;

		/** Get array of Site/Blog IDs from the database */
		$blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A );

		if ( $blogs ) {

			foreach ( $blogs as $blog ) {

				/** Repeat for every Site ID */
				switch_to_blog( $blog[ 'blog_id' ] );

				foreach ( $bbpsswap_legacy_option_keys as $bbpsswap_legacy_option_key ) {

					delete_option( $bbpsswap_legacy_option_key );

				}  // end foreach

			}  // end foreach

			restore_current_blog();

		}  // end if

	}

	/** Otherwise, delete options from main options table */
	else {

		foreach ( $bbpsswap_legacy_option_keys as $bbpsswap_legacy_option_key ) {

			delete_option( $bbpsswap_legacy_option_key );

		}  // end foreach

	}  // end if

}  // end of function ddw_bbpsswap_delete_legacy_options