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
define( 'DB_NAME', 'printing' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

define('FS_METHOD', 'direct');

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('WP_ALLOW_REPAIR', true);

define( 'UPLOADS', 'wp-content/uploads');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'rfIC1lU}u}QQ3ep1e.1t?1*9N;t.4H,E<y_b)71Aa;v%]y99vJ$p9JNfIaPcyk}0' );
define( 'SECURE_AUTH_KEY',  'SxPe/`RlTJK)uA^9_e7!7E2xr<MjWZa(VBc~cIL & G?=?@rD3cb>vzQpWZTVM!L' );
define( 'LOGGED_IN_KEY',    'VU]6k47K}I{[2,Pgkl!dRjhAKB]Z1s0xIUn]I>}j-X]f(Wi{R{~vOqtt%$p]gKR|' );
define( 'NONCE_KEY',        'HL,HoM2+y-8) ;[6,)lh--U~WXAf]_Xzz&mZEgtRmrS :6;A{:/7SoMFt?fRNXsU' );
define( 'AUTH_SALT',        '*Zo4 [F%y<[!_X%+oTV<g^*+&~U+6(:%czL`7Gklv2K0N}R#P]2ENY#a)x`$,m6 ' );
define( 'SECURE_AUTH_SALT', 'uHg.w^w^1zeY30T$#EuxY CK<)nRNWjUKc}m[9jiB;>+Z$ IffB,DuX-L/g+TgZ^' );
define( 'LOGGED_IN_SALT',   'mU&z@IvzAR>aC:X/XjXOa~Rm+DWnbP*t3hxAZRPX2UQF#Q=#3l2YKbwg8Hq2W*YA' );
define( 'NONCE_SALT',       ',G/RLnPELk{u8*e,9oD4X#0J,f,r2zN]cFT>E9@EH>AF[WZ}^5%e]e6M.o& D%<9' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
