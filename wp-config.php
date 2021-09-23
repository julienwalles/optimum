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
define( 'DB_NAME', 'optimum' );

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
define( 'AUTH_KEY',         '[H9wzIbAZ1ygs]>fobLy9R{&bnYCrME:5m)w2m~bMR5V}FpGh(_e_WgQKW}Fx?)P' );
define( 'SECURE_AUTH_KEY',  'MziD`G`L%M<AHj&E#vI[B5Op0#T0rJ){V7W6?<k5~f_ud0bu^{v%*N|%7QFmzVV@' );
define( 'LOGGED_IN_KEY',    '&[H7G66{__ fA4=!O6kW5V_{w^h-v# =*=mkVw{ B&wk~Im!nqk?Z><`t!HTosVw' );
define( 'NONCE_KEY',        'ji#13q}LOIEg/`mst`,/g45f=2K2/3-mGHS+;HIS[y06$<JGnv3Np/4~2C+ys=K<' );
define( 'AUTH_SALT',        'kT[uGW/{G=Ho[;TY=qob}`A+f{0{i-4%i1$y`Rg2?Aw4:}E6@8AL0o3Q s&(vr^/' );
define( 'SECURE_AUTH_SALT', 'SDS#dKD|(GRlq+MG}%tvD`iyfnj_~x=+eU%RmEi8Laq?-r/~W<7WTYk#wDjy6jWR' );
define( 'LOGGED_IN_SALT',   '9?DIhn]^]vI<yPC;+%?5; lxCY?zAvr697aA2uu9_)p<|xQjM;=5[@pw6spv),7K' );
define( 'NONCE_SALT',       '}:CNX2fmHCvz7PH&.|-RQX?=kkkg-vOC33^J3QKyc>[DMVxG_lbBFm!k{D:oc~7X' );
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
