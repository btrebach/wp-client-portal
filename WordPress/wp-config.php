<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'clientportal_btrebach_co');

/** MySQL database username */
define('DB_USER', 'clientportalbtre');

/** MySQL database password */
define('DB_PASSWORD', 'gPDh-XGX');

/** MySQL hostname */
define('DB_HOST', 'mysql.clientportal.btrebach.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '~/xnEgek"!pO@Gpclu(Q/Z^u~C)VI;J|:^A*2Rm$5IiJFb)`w9Vo1^m+tKO;HtkR');
define('SECURE_AUTH_KEY',  'P!rP@9uH$8#^DM#XuL(I@0Nf"b0Ho||?8ika|2c`A$ui$e2V&c9c5qn#Yjl:mY"Y');
define('LOGGED_IN_KEY',    'J|93r?%#ZfNcs"TAN^6&fCdA0MCRgiiHbsK+8Dv@5a_$*f(8s@1Xur6kF2X6f?|X');
define('NONCE_KEY',        '%KM`lHSWyAkq86^zq!3T3@k"?#b!45R7PRMvLOeNVvjV947tzxBrTuk/v&!NZvbH');
define('AUTH_SALT',        '_U!7O@H0mM;YtMQnVwKehe%+vsq?Sp;zZ79^ch^#RV/%cclwGCiudPi;%()6l_pI');
define('SECURE_AUTH_SALT', 'oE;z8b+nI|jLoPm926O#;Iw&NcE(F;14yS0"B~#uKOcNmyw4RsUSE(igLZo;Xh*S');
define('LOGGED_IN_SALT',   'Z^!k^%+:PifLV5LNxH+1k&vIf)1#)yMu(GJtxL)1pocOQDBAPQ%!g)J`WAB^tO|Z');
define('NONCE_SALT',       'F!"@ta^jRk2I2MzY:gG?oL^s@yzgIyt7143e7cmn3w8b8rY!Cp|ntY&2oZ#|umvf');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_4e5acj_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

