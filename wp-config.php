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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'newjandm' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'UM,tflz#uk}iJH%| !7McJU3Zozjj2EBCD|YT:o3g29/lhWn1UxW+H5|~BeDn@h9' );
define( 'SECURE_AUTH_KEY',  '_I B`rB%x,crz&ug/e4ued_>W=|8eVh/)vK _+}v2eyTG6#;/?2gd4D S~u,mW*w' );
define( 'LOGGED_IN_KEY',    'N3.28.;ys<>Zn>|^Z#*F$%Ctx;3*q<Yx*ZxxLt83x.J0RKR$Iy&:a8;X`c.y={-K' );
define( 'NONCE_KEY',        'e2j;sszMRn`7Q4{cNm:wvsbhn<a]/,2Iluo>dF15)2]K-@OA+Ngd:0bWE^9p2NDL' );
define( 'AUTH_SALT',        '*I*cO 5}z&Q=g|>.1A*,D]C,3i!maTp-R?NZ})E_7*#Z2}7ON)lTFGs+=lz48i3g' );
define( 'SECURE_AUTH_SALT', '};Z_X[eQQXnW[ei -<#Pzu[Lv.d,/dQ B8HOn<r7Gide|8a1+b0=8iFTMXn<}~rU' );
define( 'LOGGED_IN_SALT',   'ie;E3$<g21r&lNoA3Fmz4sN:PJXM7FZAPsG^69i:!{r*N=an6(egdsFC`Kii:=Bn' );
define( 'NONCE_SALT',       '}zBm$3{(~[(!Wh*}%6ba0OK!WPYRyl))}K!6}LC`3|lSG>l,D=J${}Ua!ItXN_!;' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
