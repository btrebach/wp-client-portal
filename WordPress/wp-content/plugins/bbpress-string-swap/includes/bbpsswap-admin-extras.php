<?php
/**
 * Helper functions for the admin - plugin links and help tabs.
 *
 * @package    bbPress String Swap
 * @subpackage Admin
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
 * Setting helper links constants.
 *
 * @since 1.0.0
 *
 * @uses  get_locale()
 */
define( 'BBPSSWAP_URL_TRANSLATE',	'http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/bbpress-string-swap' );
define( 'BBPSSWAP_URL_WPORG_FAQ',	'http://wordpress.org/extend/plugins/bbpress-string-swap/faq/' );
define( 'BBPSSWAP_URL_WPORG_FORUM',	'http://wordpress.org/support/plugin/bbpress-string-swap' );
define( 'BBPSSWAP_PLUGIN_LICENSE', 	'GPL-2.0+' );
if ( get_locale() == 'de_DE' || get_locale() == 'de_AT' || get_locale() == 'de_CH' || get_locale() == 'de_LU' ) {
	define( 'BBPSSWAP_URL_DONATE', 	'http://genesisthemes.de/spenden/' );
	define( 'BBPSSWAP_URL_PLUGIN',	'http://genesisthemes.de/plugins/bbpress-string-swap/' );
} else {
	define( 'BBPSSWAP_URL_DONATE', 	'http://genesisthemes.de/en/donate/' );
	define( 'BBPSSWAP_URL_PLUGIN', 	'http://genesisthemes.de/en/wp-plugins/bbpress-string-swap/' );
}


add_filter( 'plugin_row_meta', 'ddw_bbpsswap_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page.
 *
 * @since  1.0.0
 *
 * @param  $bbpsswap_links
 * @param  $bbpsswap_file
 *
 * @return strings plugin links
 */
function ddw_bbpsswap_plugin_links( $bbpsswap_links, $bbpsswap_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {

		return $bbpsswap_links;

	}  // end-if cap check

	/** List additional links only for this plugin */
	if ( $bbpsswap_file == BBPSSWAP_PLUGIN_BASEDIR . '/bbpress-string-swap.php' ) {

		$bbpsswap_links[] = '<a href="' . esc_url_raw( BBPSSWAP_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'bbpress-string-swap' ) . '">' . __( 'FAQ', 'bbpress-string-swap' ) . '</a>';

		$bbpsswap_links[] = '<a href="' . esc_url_raw( BBPSSWAP_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'bbpress-string-swap' ) . '">' . __( 'Support', 'bbpress-string-swap' ) . '</a>';

		$bbpsswap_links[] = '<a href="' . esc_url_raw( BBPSSWAP_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'bbpress-string-swap' ) . '">' . __( 'Translations', 'bbpress-string-swap' ) . '</a>';

		$bbpsswap_links[] = '<a href="' . esc_url_raw( BBPSSWAP_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'bbpress-string-swap' ) . '">' . __( 'Donate', 'bbpress-string-swap' ) . '</a>';

	}  // end-if plugin links

	/** Output the links */
	return apply_filters( 'bbpsswap_filter_plugin_links', $bbpsswap_links );

}  // end of function ddw_bbpsswap_plugin_links


add_action( 'load-settings_page_bbpress', 'ddw_bbpsswap_bbpress_help_tab', 20 );
/**
 * Create and display plugin help tab content.
 *
 * @since  1.0.0
 *
 * @uses   get_current_screen()
 * @uses   WP_Screen::add_help_tab()
 *
 * @global mixed $bbpsswap_bbpress_screen
 */
function ddw_bbpsswap_bbpress_help_tab() {

	global $bbpsswap_bbpress_screen;

	$bbpsswap_bbpress_screen = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if ( ! class_exists( 'WP_Screen' )
		|| ! $bbpsswap_bbpress_screen
		|| ! class_exists( 'bbPress' )
	) {
		return;
	}

	/** Add the help tab */
	$bbpsswap_bbpress_screen->add_help_tab( array(
		'id'       => 'bbpsswap-bbpress-help',
		'title'    => __( 'bbPress String Swap', 'bbpress-string-swap' ),
		'callback' => 'ddw_bbpsswap_bbpress_help_content',
	) );

}  // end of function ddw_bbpsswap_bbpress_help_tab


/**
 * Create and display plugin help tab content.
 *
 * @since 1.0.0
 *
 * @uses ddw_bbpsswap_plugin_get_data() To display various data of this plugin.
 */
function ddw_bbpsswap_bbpress_help_content() {

	echo '<h3>' . __( 'Plugin', 'bbpress-string-swap' ) . ': ' . __( 'bbPress String Swap', 'bbpress-string-swap' ) . ' <small>v' . ddw_bbpsswap_plugin_get_data( 'Version' ) . '</small></h3>' .
		'<p><strong><a href="' . admin_url( 'options-general.php?page=bbpress#bbpress-string-swap' ). '" title="' . esc_attr__( 'Settings', 'bbpress-string-swap' ) . '">' . __( 'Currently changeable via the plugin', 'bbpress-string-swap' ) . ':</a></strong><ul>' .
			'<li><em>' . __( 'Forums Archive Title', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Forums', 'bbpress-string-swap' ) . '</code></li>' .
			'<li><em>' . __( 'Breadcrumb: Home Text', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Home', 'bbpress-string-swap' ) . '</code></li>' .
			'<li><em>' . __( 'Breadcrumb: Root Text', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Forums', 'bbpress-string-swap' ) . '</code></li>' .
			'<li><em>' . __( 'Breadcrumb: Separator String', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Recommeded to enter string value like one of the following:', 'bbpress-string-swap' ). ' <code>&gt;</code>, <code>&raquo;</code>, <code>&rarr;</code>, <code>|</code> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>&rsaquo;</code></li>' .
			'<li><em>' . __( 'User Role Display: Key Master', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Key Master', 'bbpress-string-swap' ) . '</code></li>' .
			'<li><em>' . __( 'User Role Display: Moderator', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Moderator', 'bbpress-string-swap' ) . '</code></li>';

	/** Check for 'Member'/ 'Participant' */
	if ( function_exists( 'bbp_get_dynamic_roles' ) && function_exists( 'bbp_get_participant_role' ) ) {

		$bbpsswap_helper_string = __( 'Participant', 'bbpress-string-swap' );

	} elseif ( ! function_exists( 'bbp_get_dynamic_roles' ) && function_exists( 'bbp_get_participant_role' ) ) {

		$bbpsswap_helper_string = __( 'Member', 'bbpress-string-swap' );

	}  // end-if bbpress versions check

		echo '<li><em>' . sprintf( __( 'User Role Display: %s', 'bbpress-string-swap' ), $bbpsswap_helper_string ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . $bbpsswap_helper_string . '</code></li>';

	/** Check for 'Spectator' */
	if ( function_exists( 'bbp_get_spectator_role' ) ) {

		echo '<li><em>' . __( 'User Role Display: Spectator', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Spectator', 'bbpress-string-swap' ) . '</code></li>';

	}  // end-if spectator check

	/** Check for 'Visitor' */
	if ( function_exists( 'bbp_get_visitor_role' ) ) {

		echo '<li><em>' . __( 'User Role Display: Visitor', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Visitor', 'bbpress-string-swap' ) . '</code></li>';

	}  // end-if visitor check

	/** Check for 'Blocked' */
	if ( function_exists( 'bbp_get_blocked_role' ) ) {

		echo '<li><em>' . __( 'User Role Display: Blocked', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Blocked', 'bbpress-string-swap' ) . '</code></li>';

	}  // end-if blocked check

	/** Check for 'Guest' */
	if ( function_exists( 'bbp_get_anonymous_role' ) ) {

		echo '<li><em>' . __( 'User Role Display: Guest', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Guest', 'bbpress-string-swap' ) . '</code></li>';

	}  // end-if guest check

	echo '<li><em>' . __( 'Forum String: Posts', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Posts', 'bbpress-string-swap' ) . '</code>' .
			'<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used as the overall count of posts in a Topic. That means the initial starting Topic plus all its Replies.', 'bbpress-string-swap' ) . '</small></li>' .
			'<li><em>' . __( 'Forum String: Started by (user)', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Started by: %1$s', 'bbpress-string-swap' ) . '</code>' .
			'<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in a single Forum presentation of all its Topics to represent the user who posted the initial starting Topic.', 'bbpress-string-swap' ) .
			'<br />' . sprintf( __( 'It\'s very important to include the Gettext placeholder string %s here. Otherwise the the actual user name cannot be displayed!', 'bbpress-string-swap' ), '<code>%1$s</code>' ) . '</small></li>' .
			'<li><em>' . __( 'Forum String: Freshness', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Freshness', 'bbpress-string-swap' ) . '</code>' .
			'<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in several overview presentions of Forums and Topics.', 'bbpress-string-swap' ) . '</small></li>' .
			'<li><em>' . __( 'Forum String: Voices', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Voices', 'bbpress-string-swap' ) . '</code>' .
			'<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in several overview presentions of Forums and Topics.', 'bbpress-string-swap' ) . '</small></li>' .
			'<li><em>' . __( 'Forum String: Submit', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Submit', 'bbpress-string-swap' ) . '</code>' .
			'<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used as the submit button string in Topics and Replies.', 'bbpress-string-swap' ) . '</small></li>' .
			'<li><em>' . __( 'Topic Pagination: Prev String/Text', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&larr;', 'bbpress-string-swap' ) . '</code>' .
			'<li><em>' . __( 'Topic Pagination: Next String/Text', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&rarr;', 'bbpress-string-swap' ) . '</code>' .
			'<li><em>' . __( 'Reply Pagination: Prev String/Text', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&larr;', 'bbpress-string-swap' ) . '</code>' .
			'<li><em>' . __( 'Reply Pagination: Next String/Text', 'bbpress-string-swap' ) . '</em> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&rarr;', 'bbpress-string-swap' ) . '</code>' .
		'</ul></p>';

	echo '<p><strong>' . __( 'Important notes', 'bbpress-string-swap' ) . ':</strong>' .
		'<ul>' .
			'<li>' . __( 'Leave any field blank to display the default value.', 'bbpress-string-swap' ) . '</li>' .
			'<li>' . sprintf( __( 'Some themes (especially bbPress compatible ones from %s marketplace) come with own templates for bbPress and also change other display things (for example breadcrumb behavior) and functions... This could lead to not display any or all changes made by this plugin. You then have to make the wished changes manually via the theme\'s templates or simply just call the support of its creator for further advise.', 'bbpress-string-swap' ), '<em>ThemeForest</em>' ) . '</li>' .
		'</ul></p>';

	echo '<p><strong>' . __( 'Important plugin links:', 'bbpress-string-swap' ) . '</strong>' . 
		'<br /><a href="' . esc_url_raw( BBPSSWAP_URL_PLUGIN ) . '" target="_new" title="' . __( 'Plugin website', 'bbpress-string-swap' ) . '">' . __( 'Plugin website', 'bbpress-string-swap' ) . '</a> | <a href="' . esc_url_raw( BBPSSWAP_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'bbpress-string-swap' ) . '">' . __( 'FAQ', 'bbpress-string-swap' ) . '</a> | <a href="' . esc_url_raw( BBPSSWAP_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'bbpress-string-swap' ) . '">' . __( 'Support', 'bbpress-string-swap' ) . '</a> | <a href="' . esc_url_raw( BBPSSWAP_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'bbpress-string-swap' ) . '">' . __( 'Translations', 'bbpress-string-swap' ) . '</a> | <a href="' . esc_url_raw( BBPSSWAP_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'bbpress-string-swap' ) . '">' . __( 'Donate', 'bbpress-string-swap' ) . '</a></p>' .
		'<p><a href="http://www.opensource.org/licenses/gpl-license.php" target="_new" title="' . esc_attr( BBPSSWAP_PLUGIN_LICENSE ). '">' . esc_attr( BBPSSWAP_PLUGIN_LICENSE ). '</a> &copy; ' . date( 'Y' ) . ' <a href="' . esc_url_raw( ddw_bbpsswap_plugin_get_data( 'AuthorURI' ) ) . '" target="_new" title="' . esc_attr__( ddw_bbpsswap_plugin_get_data( 'Author' ) ) . '">' . esc_attr__( ddw_bbpsswap_plugin_get_data( 'Author' ) ) . '</a></p>';

}  // end of function ddw_bbpsswap_bbpress_help_content