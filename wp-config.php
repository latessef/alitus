<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'landing_page' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|1hUck@k-&|`Sh5aW8Bg|x <|G:)M,#{:R_vt<I+n4v38KlEF#Ior?H)/U]auVl|' );
define( 'SECURE_AUTH_KEY',  '>z-Uul(=|sK+{$l|W@8`e5jihHND;i#-hS4--64j%GgBrus@>BYz;%Fuzh>P}A:U' );
define( 'LOGGED_IN_KEY',    '1&:j75)0P$<hM, /+Dw6u4CfPg-zd6z`0~TTbGG.lGzdY0p*2xBY_~-~$^NbE!fh' );
define( 'NONCE_KEY',        '`6(Bq<j]-:jCTO$0|E*.fbc=fGVn;g`Fu([mArDIglWK1F^RT5~n~wZa7ro*WS)$' );
define( 'AUTH_SALT',        'cbbn2pThc3|Fy}*[8sV;T|W^}==OAs4ceUm]_LG f;h J%Uu:prIkS3G}./?5=Bz' );
define( 'SECURE_AUTH_SALT', 'RY`Ihv_9H2LH:26-ECJszvJZdQ5wzNtlwAEfx}f,]RnZLgK+eC_zOnyuo`}^3@,V' );
define( 'LOGGED_IN_SALT',   'mNaYR+K~SGH>TR[w9@PJ=Gn@ic!vzp~8Y[,k!fzGGVe7!<@P,jwULGPEy2iKZ^GX' );
define( 'NONCE_SALT',       'Qy#a2$@o$|uX2SC;n^_Wo*~3v2{/F-Y=RfAJ5Q~^;G`g|sdLY|=F^Vl;hwXd FWH' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
