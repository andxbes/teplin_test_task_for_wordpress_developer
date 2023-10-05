<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'beta');
/** Database username */
define('DB_USER', 'beta');
/** Database password */
define('DB_PASSWORD', 'beta');
/** Database hostname */
define('DB_HOST', 'mariadb');
/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'tE[ZX,=vGn;%%[|AX=Iev C6C!AX,U2A/2]Gr96oU|s/3k>Z.q6ZvUW|^Tjqajg<');
define('SECURE_AUTH_KEY',  'oCK*|;;R[-.wGXzoL&y_F#&,kE7;Ssh+h?a<y7W/r3Ax+/e_4Q6qxKgJ;M{4Qe-w');
define('LOGGED_IN_KEY',    '=A/~noLbuy-|`ta1l_vW`2-a>dW-Lo<|f_4v4=8@W%+~jj)v]C~T1_||&8u#k:g[');
define('NONCE_KEY',        ' Hw3#5-O+ch6Ro]a=r_.xA;EGTY1KSUv_)zx;Mo+>*g=S|qSCjw,OKDSm8iu:X5&');
define('AUTH_SALT',        '=tG7^3aY551ELi&;eWc%@am]6,OV&&0{F!tay?3R(L^Qq)VlcUd:ey+|T5Ee|z1R');
define('SECURE_AUTH_SALT', '4nu!G/K2d8ytqTV=z%:{RTc23F^f?L{dfr~.4WT}$#3Fk7{Y`/9$YSv,.W|H%5&-');
define('LOGGED_IN_SALT',   'Yz]BHVQPy]=2R~8Ltk yR[Pb5,3Uj6tIL&VtA>l&R<bZw.`JC8ff,6.bkEHgVi~k');
define('NONCE_SALT',       '(3a6A1.%|cjsZJ3;Z/i_3!<mq~hjhZeaWIc `B1|@f~2%CW#-g3<c [xIm g(wyr');
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_HOME', 'http://localhost/');
define('WP_SITEURL', 'http://localhost/');
define('WP_DEBUG', true);
// Дополнительные параметры для отладки
if (WP_DEBUG) {
	define('WP_DEBUG_DISPLAY', false);
	define('WP_DEBUG_LOG', true);
	error_reporting(E_ALL);
	//    error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);
}
define('FS_METHOD', "direct");
// define('DISABLE_WP_CRON', true);
define('ALTERNATE_WP_CRON', true);

define('WP_MEMORY_LIMIT', '1024M');
ini_set('memory_limit', '1024M');




/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
