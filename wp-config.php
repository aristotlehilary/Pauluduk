<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/** Enable W3 Total Cache */

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
define('DB_NAME', 'ss_dbname_ea4amji2a7');

/** MySQL database username */
define('DB_USER', 'i2o83mV35P9i4Fa');

/** MySQL database password */
define('DB_PASSWORD', 'K3VtyRjdMrRNHMuN');

/** MySQL hostname */
define('DB_HOST', 'pauludukcom.ipagemysql.com');

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
define('AUTH_KEY', '}+w*_x@ldkyGTrRdXwybDpu@BDilGfeVw{?sdN(vpIrlHnpTxXU[wlpX}^XHxhEfb_@xX=h%V>gg+<NDxxuuC&L<?BFdHawu!EA__GV^hKK^ZQeN]AC]xr?tNTSt*G%}');
define('SECURE_AUTH_KEY', '{esv^%l;|cpe+Sf}d%@zo!DrV&drx+*<V>D^&CJOHYSIfS[H$Teiu}XhL/pV|F]zO-V+&teS&?%zc{pOel^/{oB>vsL$fa&t{l[rsNaYXr>*Owe^rOQFSw!tMw!wWEmP');
define('LOGGED_IN_KEY', 'wFg&=!hix@VNR%KbGqa?kVYTsvdwZOhigRhFX@Eg<X]&|^zUkk?zHAtIn}eT*KDimrHponwE(kJDc}{[CEpywEhCoERO=V&]bI^?Kd-FugkaMalXfecL@etFZ[*/Bcp;');
define('NONCE_KEY', 'SDGMfM{-HhW]o_qE+DBE[(C_Izx!)$!hLbtA)ACBo=B/s}(K{dMTO)Ao(wWBfLvR{N=j|+/T&X=N$X^/!R/M)LGb?=]EFO_I$-USvW<UrIdXmyGYGw]=|-FHnJQj/]^M');
define('AUTH_SALT', '!qeAhfu&qH@Dh?=(ZRqjI&hH}^z@@{p-mkSfB}lklrydmhNX/Lj(M*eEfDz&JobKtb&xO|qcLCJk-+W=rIma%ccoUsTX]Lihizk]([p*l<lb%Ac{m+Fw<T(|GwK_=W;>');
define('SECURE_AUTH_SALT', 'Lt-]EuojByx/ys>LAIT@tKXwo*ROmT@OOr[_T(sK%Z<}bs)S[X[Wkf<AgybikMRaVbr_M%oRjQFcM>YtVcmLsjYXip@y^@@(iuIc?Us/oF{|)JPkQp?qOdhx-WeBvN]!');
define('LOGGED_IN_SALT', '^-U{ERFkO$hBFCoTtbI+}O<ZP]abUjr_WO+JN>KCEy<>lmDJ!eOy*HRN_DB]p{k<HDIuNN!SL-Cobc;&wIssWulRSiZaaJX+jh/Z/In)@FKJ]VjY/lN)cQ+(ILhl$R&?');
define('NONCE_SALT', '/U)y=hS(YqM?xlVpQo;$tQTW(QIW%}X?TSW@RpUZi%F]PNm!CtqsCp@?RM;LdZr/K^b_i*cfjum&{HA@O?NiYNJliGnDlYz^U!wq]{awO&p<r@gWU^]iol<_=BE=&u<r');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_qebo_';

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

