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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',          'yZg3;~(q&0_nT6H,GYK+-3c<eZAm&ujB]ZmKr#LwI[=7+cJGFS O&is5X+P}{*F{' );
define( 'SECURE_AUTH_KEY',   'kC|bzlv<e,YjR|76%8H(p5uHItEGK 2Jis+pGpEHa6::f<EXs1;3lIR8I/JQ|0_k' );
define( 'LOGGED_IN_KEY',     '59r8rN$JL02slWBi3rf/=wTdsyk:2/0*<1:<,Y;jSb8Hsb3}2)Ra_>tpfgK+h%yV' );
define( 'NONCE_KEY',         '!1)AL^cabp$B;;,uoH^hnY79)@:eNn._ru^!.fShugf<.}A>Mj]c1tI+wBhK.cHb' );
define( 'AUTH_SALT',         '2:y*$eiW<l&~#M&dmz*FL(*:#6o<W`cGjBk2-7=wxUe#,t>={lq(baqOqbe-_v}a' );
define( 'SECURE_AUTH_SALT',  'JEK4@T1pwo_+LkSZW.NH-S{!A5w?`|).~>)ipKXfX{sZYW]jZx/v?A.2i9K0C!CC' );
define( 'LOGGED_IN_SALT',    'l]m:n)8vw@x*C]T%B3JXB2<+P@wU(#^CCUkn(rwr7v;h5jpq5.$SQB6k2]{W58R^' );
define( 'NONCE_SALT',        'dW29blc~G6d6z<(C7Ysyh:R[l0wqpDkX#(Clzi;B[j-<e-y#_~&RcAS!V:XR6fa@' );
define( 'WP_CACHE_KEY_SALT', 'jULIA%,%6~tVzX29yGFpeU]l8#-$7qi/6(BnTcL/0+|@fRtkw1,&z|_9p2FVWOZ!' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
