<?php
/**
 * Helper function to delete plugin's options array on plugin deletion.
 *
 * @package    bbPress String Swap
 * @subpackage Uninstall
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/bbpress-string-swap/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.4.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * If uninstall not called from WordPress, exit.
 *
 * @since 1.4.0
 *
 * @uses  WP_UNINSTALL_PLUGIN
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
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
	if ( ! is_user_logged_in() ) {

		wp_die(
			__( 'You must be logged in to run this script.', 'bbpress-string-swap' ),
			__( 'bbPress String Swap', 'bbpress-string-swap' ),
			array( 'back_link' => true )
		);

	}  // end if user login check

	if ( ! current_user_can( 'install_plugins' ) ) {

		wp_die(
			__( 'You do not have permission to run this script.', 'bbpress-string-swap' ),
			__( 'bbPress String Swap', 'bbpress-string-swap' ),
			array( 'back_link' => true )
		);

	}  // end if user cap check


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

			delete_option( 'bbpsswap-options' );

		}  // end foreach

		restore_current_blog();

	}  // end if

}

/** Otherwise, delete options from main options table */
else {

	delete_option( 'bbpsswap-options' );

}  // end if