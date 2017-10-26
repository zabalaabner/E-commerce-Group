

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
define('DB_NAME', 'ecommerce');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '((C?E|/]Dy,tB v(wEL.?vOsg1:~/`s%^vwJ@d^%Z6WdKc4,herlYu>wIoU8)r1X');
define('SECURE_AUTH_KEY',  'I.ll9>B:d)&Pf]cF[CB`j(!FMI{+2Ys?HOqP2!OR>*ph!qlhT2o,Vmpg{?t$Xcg~');
define('LOGGED_IN_KEY',    '8d1!IfDF7=q4BkaQ/l{i!K/R2}OgZJ{he>4nT@}tM1f`*v=X,&te;eTJ*9A+Z,]Y');
define('NONCE_KEY',        'yUH: L4WZ}8ct{X?~b*X2$;S?Eum#Iv))fXTjx9`[RH3O7&>Qfm{h$czDWP!v8di');
define('AUTH_SALT',        'Tnz/,:i| NY}}%DvP#R*r`^FT43]ZAptVpuf?*%J}Kv-/kd(Ogw.mO@C+oGg%Cu7');
define('SECURE_AUTH_SALT', 'K]C?X6P#:;<W/:ctGKYH3xze:zz]u[^&{)${lKWhs%mvt?ohR[;PE1e.`MSWR0I>');
define('LOGGED_IN_SALT',   '9ui_h9KI^cL%xj+M-CA/MBf!-)[0{9uQ--vev]ag$jhgLaHQz4`Hg?wRB:/zn2JT');
define('NONCE_SALT',       '$>lLGDv88 Uh]5@O=lYxD bhqP9K2nDNnQAff:09Om6o7Fjm~:}2]9|&PNXQ<0f&');

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

define( 'CUSTOM_TAGS', true );