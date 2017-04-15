<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'jsf');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'NkEe[M52^s<zs`j<qTd @6R,:;|HwW4?M=qnxa:`nT)6;oGP-t~ylmw0H;*ZYlN#');
define('SECURE_AUTH_KEY',  'N5ueOAtD !72$8pc~6[uJgFpq_^Xcsn4hweU@(B_vcxk]$-$`9s-mi7F:>mn:$-q');
define('LOGGED_IN_KEY',    'qU0g41U.0*KiF@7U%<[R9[Te]7?LB6EpV[vofO,_][7#VY2(t|y],sf<Un~v?qkf');
define('NONCE_KEY',        'k@4Y81>OPf;wuqcr]8-95(uK5V4~D*Ot_CTmyKR},<~ZPF{2?A-#MJuD?z%cohOW');
define('AUTH_SALT',        'g:f;S>K}+{W;qHwg;nO3DXAjN3w|ydxCMD1ey9CH!<-c9.+J{}<@mwD<Q^sT&MJ*');
define('SECURE_AUTH_SALT', '|SyL$9^pfB:BO5~]H/Q`%Ybp^WfNheiSW+;;nL7FInxr<O!S,/,CkFO={Al0h}_1');
define('LOGGED_IN_SALT',   '0*lv,KP<^ sE!KHR){C|v}w>pQR:Rf1=t1$R7]O{PJ`=t0=Az[@**g<86yhrUL[K');
define('NONCE_SALT',       ' ikMHY,sD ?X+|nLNu6~p~zb}4yUKs-8S#`pw|OVvvkps*hy@kTkh_Q..-B^w_lf');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
