<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'stonecera' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         ':s0{O/2W;6*1!q#JRS8[c=HX8S[Arzn@aM*+:96DXd*Tb8ZO~r:5KaGEzG-kDC{u' );
define( 'SECURE_AUTH_KEY',  'p<,RLDxrZ+.};5BfK$QpFrA9REl%Bc~cP(pGW_BeKw1>Xd%~T)nu^m~1j`Ln9)41' );
define( 'LOGGED_IN_KEY',    'n1i{e13#$RdH:vwC),>{aJ}@*EI;<N0kmbS99-d=l(&q3DMFUJMn.NW84QaCn9f-' );
define( 'NONCE_KEY',        'C~mYxO.# ` j>RTdHeeS?~uU0Wsj=v:!%!M:1Jgq31S$H/:=Eul_!<([|Gu>eLn3' );
define( 'AUTH_SALT',        'D!h8;_{DRiuauAR>4p-JUsO/jNSTG)H{/;n-H.$4-9JrItH56Y:wNDolz4Sq%^J4' );
define( 'SECURE_AUTH_SALT', 'Z-i^z()P{bEf&2~-Rwk1]b95Tkb5(F]Z 8:c1G-V}mOR}D0hODV=9)2uMm{4Ht@K' );
define( 'LOGGED_IN_SALT',   'rcp1~zfL9-~!&`k|H}:TE^HH pwVO#:^MKvUso_d%BecUw@[eO,)8f>]oUeB>aOZ' );
define( 'NONCE_SALT',       'd-,wxSWKKC5ZFY}CE_!Q_Ye i+yUvM`78b)IP%1a7=rVL5VLM?Jyfqa*gc$V$HK@' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'stonecera_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
// define( 'WP_DEBUG', false );
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
