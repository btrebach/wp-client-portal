<?php
/**
 * Main plugin file.
 * In bbPress 2.1+, change Forums Archive Title (forums main page), some
 *   Breadcrumbs arguments, User Role display names plus a few other
 *   Forums Strings.
 *
 * @package   bbPress String Swap
 * @author    David Decker
 * @link      http://deckerweb.de/twitter
 * @copyright Copyright (c) 2012-2013, David Decker - DECKERWEB
 *
 * Plugin Name: bbPress String Swap
 * Plugin URI: http://genesisthemes.de/en/wp-plugins/bbpress-string-swap/
 * Description: In bbPress 2.1+, change Forums Archive Title (forums main page), some Breadcrumbs arguments, User Role display names plus a few other Forums Strings.
 * Version: 1.4.0
 * Author: David Decker - DECKERWEB
 * Author URI: http://deckerweb.de/
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: bbpress-string-swap
 * Domain Path: /languages/
 *
 * Copyright (c) 2012-2013 David Decker - DECKERWEB
 *
 *     This file is part of bbPress String Swap,
 *     a plugin for WordPress.
 *
 *     bbPress String Swap is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     bbPress String Swap is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
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
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin directory */
define( 'BBPSSWAP_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'BBPSSWAP_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since 1.0.0
 *
 * @uses  get_plugins()
 *
 * @param $bbpsswap_plugin_value
 *
 * @return string Plugin data.
 */
function ddw_bbpsswap_plugin_get_data( $bbpsswap_plugin_value ) {

	/** Bail early if we are not it wp-admin */
	if ( ! is_admin() ) {
		return;
	}

	/** Include WordPress plugin data */
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$bbpsswap_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$bbpsswap_plugin_file = basename( ( __FILE__ ) );

	return $bbpsswap_plugin_folder[ $bbpsswap_plugin_file ][ $bbpsswap_plugin_value ];

}  // end of function ddw_bbpsswap_plugin_get_data


/**
 * Plugin's main class.
 *
 * @since 1.0.0
 */
class DDW_bbPress_String_Swap {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $_this;


	/**
	 * Constructor. Hooks all interactions into correct areas to start the class.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		/**
		 * Disallowing a Second Instantiation of our class.
		 *
		 * @link  http://hardcorewp.com/2013/using-singleton-classes-for-wordpress-plugins/
		 *
		 * @since 1.3.0
		 *
		 * @uses  wp_die()
		 */
		if ( isset( self::$_this ) ) {

			$bbpsswap_notice = sprintf(
				__( '%s is a singleton class and you cannot create a second instance.', 'bbpress-string-swap' ),
				get_class( $this )
			);

			wp_die( $bbpsswap_notice );

		}  // end if

		/** Store the object in a static property */
		self::$_this = $this;
		
		/** Load admin area stuff */
		add_action( 'admin_init', array( $this, 'admin_settings' ), 15 );

		/** Load further plugin init methods */
		add_action( 'init', array( $this, 'bbpsswap_init' ), 1 );

		/**
		 * Triggers our string swap filters for bbPress
		 *
		 * Note: Not using class methods here, to have non-anonymous filter callbacks
		 *   in order to let them still be removable by other plugins etc.
		 * Note: The Gettext filters are loaded seperately for proper priorities and display.
		 *   (see plugin file '/includes/bbpsswap-frontend.php')
		 */
		add_filter( 'bbp_get_forum_archive_title',			'ddw_bbpsswap_display_bbpress_forum_archive_title'	);
		add_filter( 'bbp_before_get_breadcrumb_parse_args',	'ddw_bbpsswap_display_bbpress_breadcrumb_home_text'	);
		add_filter( 'bbp_before_get_breadcrumb_parse_args',	'ddw_bbpsswap_display_bbpress_breadcrumb_root_text'	);
		add_filter( 'bbp_before_get_breadcrumb_parse_args',	'ddw_bbpsswap_display_bbpress_breadcrumb_sep',		1 );
		add_filter( 'bbp_topic_pagination',					'ddw_bbpsswap_display_topic_pagination_prev'		);
		add_filter( 'bbp_topic_pagination',					'ddw_bbpsswap_display_topic_pagination_next'		);
		add_filter( 'bbp_replies_pagination',				'ddw_bbpsswap_display_reply_pagination_prev'		);
		add_filter( 'bbp_replies_pagination',				'ddw_bbpsswap_display_reply_pagination_next'		);

		/** Triggers plugin activation check */
		register_activation_hook( __FILE__, array( $this, 'activation_hook' ) );

	}  // end of method __construct


	/**
	 * Returns the value of "self::$_this".
	 *    This function will be public by default
	 *    providing read-only access to the single instance used by the plugin's
	 *    class.
	 *
	 * @link   http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 *
	 * @since  1.3.0
	 *
	 * @return the value of self::$_this.
	 */
	static function this() {

		return $_this;

	}  // end of method this


	/**
	 * Plugin class activation
	 *
	 * Check to see if bbPress is activated, if not display error message.
	 *   If bbPress is already active setup default values for our options.
	 *
	 * @since 1.0.0
	 *
	 * @uses  deactivate_plugins()
	 * @uses  wp_die()
	 */
	function activation_hook() {

		/** Obviously, this wouldn't work to well without bbPress 2.x */
		if ( ! class_exists( 'bbPress' ) ) {

			/** Deactivate ourself */
			deactivate_plugins( plugin_basename( __FILE__ ) );

			$bbpsswap_deactivation_message = sprintf(
				__( 'Sorry, you need to install and/or activate %s plugin version first.', 'bbpress-string-swap' ),
				'<a href="http://wordpress.org/extend/plugins/bbpress/" target="_new" title="bbPress 2.x">bbPress 2.x</a>'
			);

			/** WordPress error message output */
			wp_die(
				$bbpsswap_deactivation_message,
				__( 'Plugin', 'bbpress-string-swap' ) . ': ' . __( 'bbPress String Swap', 'bbpress-string-swap' ),
				array( 'back_link' => true )
			);

		}  // end-if bbPress check

	}  // end of method activation_hook


	/**
	 * Plugin init functions.
	 *
	 * Load Translations and plugin settings links.
	 *
	 * @since 1.0.0
	 *
	 * @uses  apply_filters() For filtering translations file directories
	 * @uses  load_plugin_textdomain() For loading the translations
	 * @uses  is_admin()
	 * @uses  current_user_can()
	 *
	 * @param string $bbpsswap_wp_lang_dir
	 * @param string $bbpsswap_lang_dir
	 */
	function bbpsswap_init() {

		/** Set unique textdomain string */
		$bbpsswap_textdomain = 'bbpress-string-swap';

		/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
		$locale = apply_filters( 'plugin_locale', get_locale(), $bbpsswap_textdomain );

		/** Set filter for WordPress languages directory */
		$bbpsswap_wp_lang_dir = apply_filters(
			'bbpsswap_filter_wp_lang_dir',
			trailingslashit( WP_LANG_DIR ) . 'bbpress-string-swap/' . $bbpsswap_textdomain . '-' . $locale . '.mo'
		);

		/** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
		load_textdomain( $bbpsswap_textdomain, $bbpsswap_wp_lang_dir );

		/** Translations: Secondly, look in plugin's "languages" folder = default */
		load_plugin_textdomain(
			$bbpsswap_textdomain,
			FALSE,
			apply_filters( 'bbpsswap_filter_lang_dir', BBPSSWAP_PLUGIN_BASEDIR . 'languages' )
		);


		/** Load the admin and frontend functions only when needed */
		if ( is_admin() ) {

			require_once( BBPSSWAP_PLUGIN_DIR . 'includes/bbpsswap-admin-extras.php' );

		} else {

			require_once( BBPSSWAP_PLUGIN_DIR . 'includes/bbpsswap-frontend.php' );

		}  // end-if is_admin() check

		/** Add "Settings Page" link to plugin page */
		if ( is_admin() && current_user_can( 'manage_options' ) ) {

			add_filter(
				'plugin_action_links_' . plugin_basename( __FILE__ ),
				array( $this, 'add_settings_link' ), 10, 2
			);

		}  // end if is_admin() & cap check

	}  // end of method bbpsswap_init


	/**
	 * Add "Settings Page" link to plugin page
	 *
	 * @since  1.0.0
	 *
	 * @param  $bbpsswap_links
	 * @param  $bbpsswap_settings_link
	 *
	 * @return strings Settings link
	 */
	function add_settings_link( $bbpsswap_links ) {

		/** Settings page Admin link */
		$bbpsswap_settings_link = sprintf(
			'<a href="%s" title="%s">%s</a>',
			admin_url( 'options-general.php?page=bbpress#bbpress-string-swap' ),
			__( 'Go to the bbPress settings page', 'bbpress-string-swap' ),
			__( 'Settings', 'bbpress-string-swap' )
		);
	
		/** Set the order of the links */
		array_unshift( $bbpsswap_links, $bbpsswap_settings_link );

		/** Display plugin settings links */
		return apply_filters( 'bbpsswap_filter_settings_page_link', $bbpsswap_links );

	}  // end of method add_settings_link


	/**
	 * Default values of the plugin's options.
	 *    NOTE: Refactored in v1.4.0 of the plugin to use array in options, and
	 *          NOT single option for each value!
	 *
	 * @since 1.4.0
	 */
	function default_options() {
		
		/** Legacy prefix (plugin prior v1.4.0) */
		$prefix = 'ddw_bbpress_';

		/**
		 * Array of default options, including legacy compat for plugin prior v1.4.0.
		 */
		$bbpsswap_default_options = array(

			/** Breadcrumb */
			'forums_archive_title'       => ( get_option( $prefix . 'forums_archive_title' ) ) ? get_option( $prefix . 'forums_archive_title' ) : esc_attr__( 'Forums', 'bbpress-string-swap' ),

			'breadcrumb_args_home_text'  => ( get_option( $prefix . 'breadcrumb_args_home_text' ) ) ? get_option( $prefix . 'breadcrumb_args_home_text' ) : esc_attr__( 'Home', 'bbpress-string-swap' ),

			'breadcrumb_args_root_text'  => ( get_option( $prefix . 'breadcrumb_args_root_text' ) ) ? get_option( $prefix . 'breadcrumb_args_root_text' ) : esc_attr__( 'Forums', 'bbpress-string-swap' ),

			'breadcrumb_args_sep'        => ( get_option( $prefix . 'breadcrumb_args_separator' ) ) ? get_option( $prefix . 'breadcrumb_args_separator' ) : esc_attr__( '&rsaquo;', 'bbpress-string-swap' ),


			/** User roles */
			'user_display_key_master'    => ( get_option( $prefix . 'user_display_key_master' ) ) ? get_option( $prefix . 'user_display_key_master' ) : esc_attr__( 'Key Master', 'bbpress-string-swap' ),

			'user_display_moderator'     => ( get_option( $prefix . 'user_display_moderator' ) ) ? get_option( $prefix . 'user_display_moderator' ) : esc_attr__( 'Moderator', 'bbpress-string-swap' ),

			'user_display_member'        => ( get_option( $prefix . 'user_display_member' ) ) ? get_option( $prefix . 'user_display_member' ) : esc_attr__( 'Member', 'bbpress-string-swap' ),

			'user_display_guest'         => ( get_option( $prefix . 'user_display_guest' ) ) ? get_option( $prefix . 'user_display_guest' ) : esc_attr__( 'Guest', 'bbpress-string-swap' ),


			/** New, since bbPress 2.2+ */
			'user_display_participant'   => ( get_option( $prefix . 'user_display_participant' ) ) ? get_option( $prefix . 'user_display_participant' ) : esc_attr__( 'Participant', 'bbpress-string-swap' ),

			'user_display_spectator'     => ( get_option( $prefix . 'user_display_spectator' ) ) ? get_option( $prefix . 'user_display_spectator' ) : esc_attr__( 'Spectator', 'bbpress-string-swap' ),

			'user_display_visitor'       => ( get_option( $prefix . 'user_display_visitor' ) ) ? get_option( $prefix . 'user_display_visitor' ) : esc_attr__( 'Visitor', 'bbpress-string-swap' ),

			'user_display_blocked'       => ( get_option( $prefix . 'user_display_blocked' ) ) ? get_option( $prefix . 'user_display_blocked' ) : esc_attr__( 'Blocked', 'bbpress-string-swap' ),


			/** Various strings */
			'display_posts'              => ( get_option( $prefix . 'display_posts' ) ) ? get_option( $prefix . 'display_posts' ) : esc_attr__( 'Posts', 'bbpress-string-swap' ),

			'display_startedby'          => ( get_option( $prefix . 'display_startedby' ) ) ? get_option( $prefix . 'display_startedby' ) : esc_attr__( 'Started by: %1$s', 'bbpress-string-swap' ),

			'display_freshness'          => ( get_option( $prefix . 'display_freshness' ) ) ? get_option( $prefix . 'display_freshness' ) : esc_attr__( 'Freshness', 'bbpress-string-swap' ),

			'display_voices'             => ( get_option( $prefix . 'display_voices' ) ) ? get_option( $prefix . 'display_voices' ) : esc_attr__( 'Voices', 'bbpress-string-swap' ),

			'display_submit'             => ( get_option( $prefix . 'display_submit' ) ) ? get_option( $prefix . 'display_submit' ) : esc_attr__( 'Submit', 'bbpress-string-swap' ),


			/** Pagination */
			'topic_pagination_prev_text' => ( get_option( $prefix . 'topic_pagination_prev_text' ) ) ? get_option( $prefix . 'topic_pagination_prev_text' ) : esc_attr__( '&larr;', 'bbpress-string-swap' ),

			'topic_pagination_next_text' => ( get_option( $prefix . 'topic_pagination_next_text' ) ) ? get_option( $prefix . 'topic_pagination_next_text' ) : esc_attr__( '&rarr;', 'bbpress-string-swap' ),

			'reply_pagination_prev_text' => ( get_option( $prefix . 'reply_pagination_prev_text' ) ) ? get_option( $prefix . 'reply_pagination_prev_text' ) : esc_attr__( '&larr;', 'bbpress-string-swap' ),

			'reply_pagination_next_text' => ( get_option( $prefix . 'reply_pagination_next_text' ) ) ? get_option( $prefix . 'reply_pagination_next_text' ) : esc_attr__( '&rarr;', 'bbpress-string-swap' ),


			/** 'Oh bother' strings */
			'display_no_forums'          => esc_attr__(
				'Oh bother! No forums were found here!',
				'bbpress-string-swap'
			),
			'display_no_topics'          => esc_attr__(
				'Oh bother! No topics were found here!',
				'bbpress-string-swap'
			),
			'display_no_replies'         => esc_attr__(
				'Oh bother! No replies were found here!',
				'bbpress-string-swap'
			),
			'display_no_search_results'  => esc_attr__(
				'Oh bother! No search results were found here!',
				'bbpress-string-swap'
			)

		);  // end of array

		$bbpsswap_defaults = wp_parse_args(
			get_option( 'bbpsswap-options' ),
			apply_filters( 'bbpsswap_filter_default_options', $bbpsswap_default_options )
		);

		/** Return the settings defaults */
		return $bbpsswap_defaults;

	}  // end of method default_options


	/**
	 * Setup and register Admin Settings.
	 *
	 * Setup all the settings on the main bbPress forum settings page.
	 *    Hooking in our own section.
	 *
	 * @since 1.0.0
	 */
	function admin_settings() {

		$bbpsswap_defaults = DDW_bbPress_String_Swap::default_options();

		/** If options do not exist (on first run), update them with default values */
		if ( ! get_option( 'bbpsswap-options' ) ) {
			update_option( 'bbpsswap-options', $bbpsswap_defaults );
		}

		/** After saving our new options array, delete the old legacy options */
		if ( get_option( 'ddw_bbpress_forums_archive_title' ) ) {

			include_once( BBPSSWAP_PLUGIN_DIR . 'includes/bbpsswap-functions.php' );
			ddw_bbpsswap_delete_legacy_options();

		}  // end if

		/** Register our settings with the bbPress forum settings page */
		register_setting(
			'bbpress',
			'bbpsswap-options',
			array( $this, 'validate_settings' )
		); 


		/** Add the section to primary bbPress options */
		$bbpsswap_settings_header =
				'<div id="bbpress-string-swap"><br />' .
				'<em>' . __( 'Plugin', 'bbpress-string-swap' ) . ':</em> ' . __( 'bbPress String Swap', 'bbpress-string-swap' ) . ' <small>v' . ddw_bbpsswap_plugin_get_data( 'Version' ) . '</small>' .
				'<br />&rarr; ' . __( 'Change Forums Archive Title, some Breadcrumb Arguments, User Role display names, some Topics & Replies pagination parameters, some other Forums Strings', 'bbpress-string-swap' ) . '</div>';

		add_settings_section(
			'ddw_bbpress_string_swap_options',
			$bbpsswap_settings_header,
			array( $this, 'section_heading' ),
			'bbpress'
		);

		/** Add Forums Archive Title settings field */
		add_settings_field(
			'forums_archive_title',
			__( 'Forums Archive Title', 'bbpress-string-swap' ),
			array( $this, 'forums_archive_title_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add Breadcrumb Home Text settings field */
		add_settings_field(
			'breadcrumb_args_home_text',
			__( 'Breadcrumb: Home Text', 'bbpress-string-swap' ),
			array( $this, 'breadcrumb_args_home_text_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add Breadcrumb Root Text settings field */
		add_settings_field(
			'breadcrumb_args_root_text',
			__( 'Breadcrumb: Root Text', 'bbpress-string-swap' ),
			array( $this, 'breadcrumb_args_root_text_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add Breadcrumb Separator String settings field */
		add_settings_field(
			'breadcrumb_args_separator',
			__( 'Breadcrumb: Separator String', 'bbpress-string-swap' ),
			array( $this, 'breadcrumb_args_sep_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add User Display 'Key Master' settings field */
		add_settings_field(
			'user_display_key_master',
			__( 'User Role Display: Key Master', 'bbpress-string-swap' ),
			array( $this, 'user_display_key_master_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add User Display 'Moderator' settings field */
		add_settings_field(
			'user_display_moderator',
			__( 'User Role Display: Moderator', 'bbpress-string-swap' ),
			array( $this, 'user_display_moderator_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Check for bbPress v2.2 / v2.1 functions */
		if ( function_exists( 'bbp_get_dynamic_roles' ) && function_exists( 'bbp_get_participant_role' ) ) {

			/** Add User Display 'Participant' settings field */
			add_settings_field(
				'user_display_participant',
				__( 'User Role Display: Participant', 'bbpress-string-swap' ),
				array( $this, 'user_display_participant_input' ),
				'bbpress',
				'ddw_bbpress_string_swap_options'
			);

		} elseif ( ! function_exists( 'bbp_get_dynamic_roles' )
					&& function_exists( 'bbp_get_participant_role' )
		) {

			/** Add User Display 'Member' settings field */
			add_settings_field(
				'user_display_member',
				__( 'User Role Display: Member', 'bbpress-string-swap' ),
				array( $this, 'user_display_member_input' ),
				'bbpress',
				'ddw_bbpress_string_swap_options'
			);

		}  // end-if bbPress versions check

		/** Add User Display 'Spectator' settings field */
		if ( function_exists( 'bbp_get_spectator_role' ) ) {
			add_settings_field(
				'user_display_spectator',
				__( 'User Role Display: Spectator', 'bbpress-string-swap' ),
				array( $this, 'user_display_spectator_input' ),
				'bbpress',
				'ddw_bbpress_string_swap_options'
			);
		}

		/** Add User Display 'Visitor' settings field */
		if ( function_exists( 'bbp_get_visitor_role' ) ) {
			add_settings_field(
				'user_display_visitor',
				__( 'User Role Display: Visitor', 'bbpress-string-swap' ),
				array( $this, 'user_display_visitor_input' ),
				'bbpress',
				'ddw_bbpress_string_swap_options'
			);
		}

		/** Add User Display 'Blocked' settings field */
		if ( function_exists( 'bbp_get_blocked_role' ) ) {
			add_settings_field(
				'user_display_blocked',
				__( 'User Role Display: Blocked', 'bbpress-string-swap' ),
				array( $this, 'user_display_blocked_input' ),
				'bbpress',
				'ddw_bbpress_string_swap_options'
			);
		}

		/** Add User Display 'Guest' settings field */
		if ( function_exists( 'bbp_get_anonymous_role' ) ) {
			add_settings_field(
				'user_display_guest',
				__( 'User Role Display: Guest', 'bbpress-string-swap' ),
				array( $this, 'user_display_guest_input' ),
				'bbpress',
				'ddw_bbpress_string_swap_options'
			);
		}

		/** Add 'Posts' String settings field */
		add_settings_field(
			'display_posts',
			__( 'Forum String: Posts', 'bbpress-string-swap' ),
			array( $this, 'forum_display_posts_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Started by' String settings field */
		add_settings_field(
			'display_startedby',
			__( 'Forum String: Started by (user)', 'bbpress-string-swap' ),
			array( $this, 'forum_display_startedby_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Freshness' String settings field */
		add_settings_field(
			'display_freshness',
			__( 'Forum String: Freshness', 'bbpress-string-swap' ),
			array( $this, 'forum_display_freshness_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Voices' String settings field */
		add_settings_field(
			'display_voices',
			__( 'Forum String: Voices', 'bbpress-string-swap' ),
			array( $this, 'forum_display_voices_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Submit' String settings field */
		add_settings_field(
			'display_submit',
			__( 'Forum String: Submit', 'bbpress-string-swap' ),
			array( $this, 'forum_display_submit_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Topic Pagination Prev' string settings field */
		add_settings_field(
			'topic_pagination_prev_text',
			__( 'Topic Pagination: Prev String/Text', 'bbpress-string-swap' ),
			array( $this, 'topic_pagination_prev_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Topic Pagination Next' string settings field */
		add_settings_field(
			'topic_pagination_next_text',
			__( 'Topic Pagination: Next String/Text', 'bbpress-string-swap' ),
			array( $this, 'topic_pagination_next_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Reply Pagination Prev' string settings field */
		add_settings_field(
			'reply_pagination_prev_text',
			__( 'Reply Pagination: Prev String/Text', 'bbpress-string-swap' ),
			array( $this, 'reply_pagination_prev_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add 'Reply Pagination Next' string settings field */
		add_settings_field(
			'reply_pagination_next_text',
			__( 'Reply Pagination: Next String/Text', 'bbpress-string-swap' ),
			array( $this, 'reply_pagination_next_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add string settings field: "Oh bother! No forums were found here!" */
		add_settings_field(
			'display_no_forums',
			sprintf( __( 'Forum String: Oh bother no %s...', 'bbpress-string-swap' ), __( 'forums', 'bbpress-string-swap' ) ),
			array( $this, 'forum_display_no_forums_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add string settings field: "Oh bother! No topics were found here!" */
		add_settings_field(
			'display_no_topics',
			sprintf( __( 'Forum String: Oh bother no %s...', 'bbpress-string-swap' ), __( 'topics', 'bbpress-string-swap' ) ),
			array( $this, 'forum_display_no_topics_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add string settings field: "Oh bother! No replies were found here!" */
		add_settings_field(
			'display_no_replies',
			sprintf( __( 'Forum String: Oh bother no %s...', 'bbpress-string-swap' ), __( 'replies', 'bbpress-string-swap' ) ),
			array( $this, 'forum_display_no_replies_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

		/** Add string settings field: "Oh bother! No search results were found here!" */
		add_settings_field(
			'display_no_search_results',
			sprintf( __( 'Forum String: Oh bother no %s...', 'bbpress-string-swap' ), __( 'search results', 'bbpress-string-swap' ) ),
			array( $this, 'forum_display_no_search_results_input' ),
			'bbpress',
			'ddw_bbpress_string_swap_options'
		);

	}  // end of method admin_settings


	/**
	 * Section heading information
	 *
	 * Output description and hints for this settings area within the bbPress Main Settings page.
	 *
	 * @since 1.0.0
	 */
	function section_heading() {

		echo '<p id="bbpress-string-swap-info">' . __( 'Set the the Forums Archive title for the forums main page. Change some important Breadcrumb values within the bbPress Breadcrumb display. Change displayed User Role names. Change a few important other Forum strings. Change some Pagination parameters for Topics &amp; Replies.', 'bbpress-string-swap' ) .
			'<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Leave any field blank to display the default value.', 'bbpress-string-swap' ) . '</small></p>';

	}  // end of method section_heading

	
	/**
	 * Forums Archive Title input field.
	 *
	 * @since 1.0.0
	 */
	function forums_archive_title_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-forums_archive_title" name="bbpsswap-options[forums_archive_title]" value="' . $bbpsswap_options[ 'forums_archive_title' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[forums_archive_title]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Forums', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method forums_archive_title_input


	/**
	 * Breadcrumb: Home Text input field.
	 *
	 * @since 1.0.0
	 */
	function breadcrumb_args_home_text_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-breadcrumb_args_home_text" name="bbpsswap-options[breadcrumb_args_home_text]" value="' . $bbpsswap_options[ 'breadcrumb_args_home_text' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[breadcrumb_args_home_text]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Home', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method breadcrumb_args_home_text_input


	/**
	 * Breadcrumb: Root Text input field.
	 *
	 * @since 1.0.0
	 */
	function breadcrumb_args_root_text_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-breadcrumb_args_root_text" name="bbpsswap-options[breadcrumb_args_root_text]" value="' . $bbpsswap_options[ 'breadcrumb_args_root_text' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[breadcrumb_args_root_text]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Forums', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method breadcrumb_args_root_text_input


	/**
	 * Breadcrumb: Separator String input field.
	 *
	 * @since 1.0.0
	 */
	function breadcrumb_args_sep_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-breadcrumb_args_sep" name="bbpsswap-options[breadcrumb_args_sep]" value="' . $bbpsswap_options[ 'breadcrumb_args_sep' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[breadcrumb_args_sep]">' . __( 'Recommeded to enter string value like one of the following:', 'bbpress-string-swap' ). ' <code>&gt;</code>, <code>&raquo;</code>, <code>&rarr;</code>, <code>|</code> &mdash; ' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>&rsaquo;</code></label>';

	}  // end of method breadcrumb_args_sep_input


	/**
	 * User Display: 'Key Master' input field.
	 *
	 * @since 1.0.0
	 */
	function user_display_key_master_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_key_master" name="bbpsswap-options[user_display_key_master]" value="' . $bbpsswap_options[ 'user_display_key_master' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_key_master]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Key Master', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_key_master_input


	/**
	 * User Display: 'Moderator' input field.
	 *
	 * @since 1.0.0
	 */
	function user_display_moderator_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_moderator" name="bbpsswap-options[user_display_moderator]" value="' . $bbpsswap_options[ 'user_display_moderator' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_moderator]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Moderator', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_moderator_input


	/**
	 * User Display: 'Participant' input field.
	 *
	 * @since 1.2.0
	 */
	function user_display_participant_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_participant" name="bbpsswap-options[user_display_participant]" value="' . $bbpsswap_options[ 'user_display_participant' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_participant]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Participant', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_participant_input


	/**
	 * User Display: 'Spectator' input field.
	 *
	 * @since 1.2.0
	 */
	function user_display_spectator_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_spectator" name="bbpsswap-options[user_display_spectator]" value="' . $bbpsswap_options[ 'user_display_spectator' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_spectator]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Spectator', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_spectator_input


	/**
	 * User Display: 'Visitor' input field.
	 *
	 * @since 1.2.0
	 */
	function user_display_visitor_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_visitor" name="bbpsswap-options[user_display_visitor]" value="' . $bbpsswap_options[ 'user_display_visitor' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_visitor]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Visitor', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_visitor_input


	/**
	 * User Display: 'Blocked' input field.
	 *
	 * @since 1.2.0
	 */
	function user_display_blocked_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_blocked" name="bbpsswap-options[user_display_blocked]" value="' . $bbpsswap_options[ 'user_display_blocked' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_blocked]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Blocked', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_blocked_input


	/**
	 * User Display: 'Member' input field.
	 *
	 * @since 1.0.0
	 */
	function user_display_member_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_member" name="bbpsswap-options[user_display_member]" value="' . $bbpsswap_user_display_member . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_member]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Member', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_member_input


	/**
	 * User Display: 'Guest' input field.
	 *
	 * @since 1.0.0
	 */
	function user_display_guest_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-user_display_guest" name="bbpsswap-options[user_display_guest]" value="' . $bbpsswap_options[ 'user_display_guest' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[user_display_guest]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Guest', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method user_display_guest_input


	/**
	 * Forum Display: 'Posts' input field.
	 *
	 * @since 1.0.0
	 */
	function forum_display_posts_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_posts" name="bbpsswap-options[display_posts]" value="' . $bbpsswap_options[ 'display_posts' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[display_posts]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Posts', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used as the overall count of posts in a Topic. That means the initial starting Topic plus all its Replies.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_posts_input


	/**
	 * Forum Display: 'Started by: %1$s' input field.
	 *
	 * @since 1.0.0
	 */
	function forum_display_startedby_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_startedby" name="bbpsswap-options[display_startedby]" value="' . $bbpsswap_options[ 'display_startedby' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[display_startedby]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Started by: %1$s', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in a single Forum presentation of all its Topics to represent the user who posted the initial starting Topic.', 'bbpress-string-swap' ) .
			'<br />' . sprintf( __( 'It\'s very important to include the Gettext placeholder string %s here. Otherwise the the actual user name cannot be displayed!', 'bbpress-string-swap' ), '<code>%1$s</code>' ) . '</small>';

	}  // end of method forum_display_startedby_input


	/**
	 * Forum Display: 'Freshness' input field.
	 *
	 * @since 1.0.0
	 */
	function forum_display_freshness_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_freshness" name="bbpsswap-options[display_freshness]" value="' . $bbpsswap_options[ 'display_freshness' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[display_freshness]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Freshness', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in several overview presentions of Forums and Topics.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_freshness_input


	/**
	 * Forum Display: 'Voices' input field.
	 *
	 * @since 1.0.0
	 */
	function forum_display_voices_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_voices" name="bbpsswap-options[display_voices]" value="' . $bbpsswap_options[ 'display_voices' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[display_voices]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Voices', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used in several overview presentions of Forums and Topics.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_voices_input


	/**
	 * Forum Display: 'Submit' input field.
	 *
	 * @since 1.0.0
	 */
	function forum_display_submit_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_submit" name="bbpsswap-options[display_submit]" value="' . $bbpsswap_options[ 'display_submit' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[display_submit]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Submit', 'bbpress-string-swap' ) . '</code></label>';

		echo '<br /><small><strong>' . __( 'Note', 'bbpress-string-swap' ) . ':</strong> ' . __( 'Used as the submit button string in Topics and Replies.', 'bbpress-string-swap' ) . '</small>';

	}  // end of method forum_display_submit_input


	/**
	 * Topic Pagination: 'Prev Text' input field.
	 *
	 * @since 1.1.0
	 */
	function topic_pagination_prev_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-topic_pagination_prev_text" name="bbpsswap-options[topic_pagination_prev_text]" value="' . $bbpsswap_options[ 'topic_pagination_prev_text' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[topic_pagination_prev_text]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&larr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_prev_input


	/**
	 * Topic Pagination: 'Next Text' input field.
	 *
	 * @since 1.1.0
	 */
	function topic_pagination_next_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-topic_pagination_next_text" name="bbpsswap-options[topic_pagination_next_text]" value="' . $bbpsswap_options[ 'topic_pagination_next_text' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[topic_pagination_next_text]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&rarr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_next_input


	/**
	 * Reply Pagination: 'Prev Text' input field.
	 *
	 * @since 1.1.0
	 */
	function reply_pagination_prev_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-reply_pagination_prev_text" name="bbpsswap-options[reply_pagination_prev_text]" value="' . $bbpsswap_options[ 'reply_pagination_prev_text' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[reply_pagination_prev_text]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&larr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_reply_input


	/**
	 * Reply Pagination: 'Next Text' input field.
	 *
	 * @since 1.1.0
	 */
	function reply_pagination_next_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-reply_pagination_next_text" name="bbpsswap-options[reply_pagination_next_text]" value="' . $bbpsswap_options[ 'reply_pagination_next_text' ] . '" type="text" class="text" />';

		echo ' <label for="bbpsswap-options[reply_pagination_next_text]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( '&rarr;', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method topic_pagination_reply_input


	/**
	 * Forum Display: input field for: "Oh bother! No forums were found here!".
	 *
	 * @since 1.4.0
	 */
	function forum_display_no_forums_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_no_forums" name="bbpsswap-options[display_no_forums]" value="' . $bbpsswap_options[ 'display_no_forums' ] . '" type="text" class="regular-text" />';

		echo ' <label for="bbpsswap-options[display_no_forums]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Oh bother! No forums were found here!', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method forum_display_no_forums_input


	/**
	 * Forum Display: input field for: "Oh bother! No topics were found here!".
	 *
	 * @since 1.4.0
	 */
	function forum_display_no_topics_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_no_topics" name="bbpsswap-options[display_no_topics]" value="' . $bbpsswap_options[ 'display_no_topics' ] . '" type="text" class="regular-text" />';

		echo ' <label for="bbpsswap-options[display_no_topics]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Oh bother! No topics were found here!', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method forum_display_no_topics_input


	/**
	 * Forum Display: input field for: "Oh bother! No replies were found here!".
	 *
	 * @since 1.4.0
	 */
	function forum_display_no_replies_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_no_replies" name="bbpsswap-options[display_no_replies]" value="' . $bbpsswap_options[ 'display_no_replies' ] . '" type="text" class="regular-text" />';

		echo ' <label for="bbpsswap-options[display_no_replies]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Oh bother! No replies were found here!', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method forum_display_no_replies_input


	/**
	 * Forum Display: input field for: "Oh bother! No search results were found here!".
	 *
	 * @since 1.4.0
	 */
	function forum_display_no_search_results_input() {

		$bbpsswap_options = get_option( 'bbpsswap-options' );

		echo '<input id="bbpsswap-options-display_no_search_results" name="bbpsswap-options[display_no_search_results]" value="' . $bbpsswap_options[ 'display_no_search_results' ] . '" type="text" class="regular-text" />';

		echo ' <label for="bbpsswap-options[display_no_search_results]">' . __( 'Default value:', 'bbpress-string-swap' ) . ' <code>' . __( 'Oh bother! No search results were found here!', 'bbpress-string-swap' ) . '</code></label>';

	}  // end of method forum_display_no_search_results_input


	/**
	 * Validate user input data.
	 *
	 * Returns sanitized results.
	 *
	 * @since  1.4.0
	 * 
	 * @param  string $input The user input string.
	 *
	 * @return string Sanitized string.
	 */
	function validate_settings( $input ) {

		/** Get our default option values */
		$bbpsswap_default_options = DDW_bbPress_String_Swap::default_options();

		/** Parse input values */
		$parsed = wp_parse_args( $input, $bbpsswap_default_options );


		/** Save empty text fields with default options */
		$textfields = array(
			'forums_archive_title',
			'breadcrumb_args_home_text',
			'breadcrumb_args_root_text',
			'breadcrumb_args_sep',
			'user_display_key_master',
			'user_display_moderator',
			'user_display_member',
			'user_display_guest',
			'user_display_participant',
			'user_display_spectator',
			'user_display_visitor',
			'user_display_blocked',
			'display_posts',
			'display_startedby',
			'display_freshness',
			'display_voices',
			'display_submit',
			'topic_pagination_prev_text',
			'topic_pagination_next_text',
			'reply_pagination_prev_text',
			'reply_pagination_next_text',
			'display_no_forums',
			'display_no_topics',
			'display_no_replies',
			'display_no_search_results'
		);

		foreach( $textfields as $textfield ) {

			$parsed[ $textfield ] = sanitize_text_field( $input[ $textfield ] );
			//$parsed[ $textfield ] = wp_filter_nohtml_kses( $input[ $textfield ] );

		}  // end foreach

		/** Return the sanitized user input value(s) */
		return $parsed;

	}  // end of method validate_settings

}  // end of class DDW_bbPress_String_Swap


/** Instantiate the class */
new DDW_bbPress_String_Swap();