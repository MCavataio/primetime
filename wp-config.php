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

define('DB_NAME', getenv("DB_NAME"));

/** MySQL database username */
define('DB_USER', getenv("DB_USER"));

/** MySQL database password */
define('DB_PASSWORD', getenv("DB_PASS"));

/** MySQL hostname */
define('DB_HOST', getenv("DB_HOST"));

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
define('AUTH_KEY',         'o!^I%yKV~0 (>e*t_0{Jvf,v/.).(:dTi(VP+%0n(W<6MaZ)wDTfHfLu/@4VQ^l7');
define('SECURE_AUTH_KEY',  'dGYkc5i!xKbjl1+gew|=R%l!;J+&Z:@{-L<<KW4zbT_Y,`WKZN%5zN#+sjr-;p-[');
define('LOGGED_IN_KEY',    'uM&9.$}Xt?[u?*Rn:fUoSaReyBNz4{<$z.wacrWhm)[c#?!wbL(<Y@VE{)nNyhL(');
define('NONCE_KEY',        '?fyvoPO;5]V_zJ )&-JW*E^q.N`5LI!ubZ`=v|Rogy (JH(R*I4(?M<I1&f@/&s2');
define('AUTH_SALT',        'oP<O D6#X8O/^trP,)>0mfb0RTl_ls?;-hXsoZt!`]/][(eOzN#*(BR`cc(?{;8e');
define('SECURE_AUTH_SALT', 'Yfw4},kVy@|0M;[&m3h2dcr eLXS/2.[n-n039|3;DkK!20! P3EE/843*kj|sv2');
define('LOGGED_IN_SALT',   '8 o.L%whkaZc$bGNZ^0)/.6Lv5`=Nen[~OAot{wlEKEF~;&i#],pX?!z2O,REO-(');
define('NONCE_SALT',       'P2xk[c@n!:NoI)0oFWPZaA00Tn4TDlz15ip$Y;v@Ct>#/QUj`1Pr|R%@]5.R|KZg');

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
