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
define('DB_NAME', 'ss_dbname_df4jc17f2m');

/** MySQL database username */
define('DB_USER', 'f9lJ59EvMnCRy0d');

/** MySQL database password */
define('DB_PASSWORD', 'BCbSjERMKm0I6TjS');

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
define('AUTH_KEY', 'ljF;k}]/H_jRKQiOAKrb&t/hzWTbP!hi+!$FN]H<{h{LqoAz/KwfHs+X[GgYi!L<+}f*;GD-CCPFQY?_N+$HP[lXmAwn;+Wm=p$-IosHI-Y=WV@BV_blnn&Zzt/f<H|i');
define('SECURE_AUTH_KEY', 'oUbspl|fv[rDv?gNu>so;lu&k)YeWu->>MmxT!NpMz}d<$@;E$DJZ;jeiTXOvnV^_w=&(H&US^zs!!co+Aq(iGx(O_=mkW>WGbd<Hysv|/!OI@k&@&S=a!@w[mV!s?bK');
define('LOGGED_IN_KEY', 'FV%p!!gZlFRN?ddJa@BgSq+cabl>S(g+-*;B)IW;[k(WkTi%YnzVlce;T$KoJxDh[_)))P|xr^_-BEp^Evu@{&uDMiTXq?pCP?Aa/H^Q-a&zyOi}*G;sDy_-%wxEpXii');
define('NONCE_KEY', 'l$)*bDF}qZqWW*@Y)f{_o$MoOUIBxYoZzboJZQ<zM)ciq?=V@@[Xjd?eJvKqE>f$E/nOAeTCSIeVs[;dPFfilDEbcrB%cLnOLLjg|Y!/TsYF<aMYB=f>tzS/E!llvKJ!');
define('AUTH_SALT', 'atnjN^X*+E]WL*vaf]P]/a]<pn-mA^oOk(H[|rsQqYQqB$)ushuce-Ld*usP|idWxNmKP$gF(zQQj/E]n-yc]-S>rNoT?^gN@!gvl;o$/Fhocusk[cS@M|BP!;]ek-<^');
define('SECURE_AUTH_SALT', '[q=%MXysySewnjmt&}QQe+_jAYI=LdaLag]CPgUcpXvWZ[Xy|W?uy&L!lQ<L$x-rsDa{P/*SM{EMNtEPPk]!^ILkzloIztOXRhcp*FnkEs-@Qd*kG?K|sI&m*[iQNccc');
define('LOGGED_IN_SALT', '|q$q?K]Q&nQjLJEEN@+PHk{+xwvm}m?q&>{ecKusw^|o=wr%-[F[;Ax$?^}Rp=?A%d-W=EP*CFrB|nzl}Cx+mXW{CV=QuwyqK$hFUgBIN@>wAuf^eRqZWVCa[RFzvtiE');
define('NONCE_SALT', 'Cd|Wp-Bnwm^bRQhBq</*yB>*UPGP|uxkCv*GBkNU|ktTW)OqROwMY>Qe&xDWk)MwpMoHCiGOD/(?WhnrOA[a)V)<AagJ>m=<LX=&Sxqk]%n)Zsn*wXQl(UGkNj^K$Oxx');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_rqhx_';

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
