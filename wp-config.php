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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define('NOBLOGREDIRECT', '');
define('WP_SITEURL', 'http://wp.p.h9k.lan');
define('WP_HOME', 'http://wp.p.h9k.lan');

define( 'DB_NAME', 'wp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '1redneck' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', '' );

/*
define('WP_ALLOW_REPAIR', true);
define('WP_ALLOW_MULTISITE', false);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'wp.p.h9k.lan');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
*/
define('FS_METHOD', 'direct');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'tO9@57%akQ@8$%j[+OnAe!]9WluVAWz>_7^Amv&IWAPqaxyUkAl[.Q wT+cSWgOT' );
define( 'SECURE_AUTH_KEY',  '.?*Fq^.;8!,)E6rTO31hNhbFsrd} !pDmuO5()9b(%t+4/iq$1]B|aSDUOzs,G@O' );
define( 'LOGGED_IN_KEY',    'I%x<gya%<n(sQrEx vUl40Zw*:m}?vmW7f:OolOcveQdkAQUA@a!=`I(#,a=gq`2' );
define( 'NONCE_KEY',        'dp2eP.&F~4b _c@4A#4{7B0|gIx[5WxlW44$0ju><0p8%N0t6hD}EmCNZXyD2b:k' );
define( 'AUTH_SALT',        '}(cG&zJN+Yo&Z6YQ!PC4w/%OnA_*<gQ(;@8bzTUqIwe-33G7eaBUGMoP/hki_#)r' );
define( 'SECURE_AUTH_SALT', '=>>RH*$s<YqA3xM4Q#/ nZ/96$Cn?AP|s~ROjA(+ChMV5w::.`ebvbx9Q$hT8Ltt' );
define( 'LOGGED_IN_SALT',   'hX{xr< jPc6/pV~tN?B|@z:NQ6g:z%3@AucQ0wR)Dx[;fI@#>]WIjQ?^b,4l3NbF' );
define( 'NONCE_SALT',       '7?WtF[?.8cizk5Y,h8Cv`9g[R=W_Ypwmg~X#z!&suD4n+rlmqO=uta*f0&>K2uR5' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
