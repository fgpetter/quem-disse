<?php

/**
 * The plugin bootstrap file
 *
 * @since             1.0
 * @package           Quemdisse
 *
 * @wordpress-plugin
 * Plugin Name:       Quem Disse - Folha do Mate
 * Plugin URI:        https://www.folhadomate.com.br
 * Description:       Plugin para apresentação de editores e fontes em sites de notícias e portais de comunicação
 * Version:           0.1
 * Requires at least: 6.3
 * Requires PHP:      8.0
 * Author:            Escritório Móvel
 * Author URI:        https://escritoriomovel.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quemdisse
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'QUEMDISSE_VERSION', '0.1' );
define( 'QUEMDISSE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QUEMDISSE__MINIMUM_WP_VERSION', '6.3' );

register_activation_hook( __FILE__, array( 'QuemDisse', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'QuemDisse', 'plugin_deactivation' ) );

require_once( QUEMDISSE__PLUGIN_DIR . 'class.quemdisse.php' );