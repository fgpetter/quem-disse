<?php
/**
 * Plugin Quem Disse
 *
 * @since             1.0
 * @package           Quemdisse
 *
 * @wordpress-plugin
 * Plugin Name:       Quem Disse - Folha do Mate
 * Plugin URI:        https://www.folhadomate.com.br
 * Description:       Plugin para apresentação de editores e fontes em sites de notícias e portais de comunicação
 * Version:           1.1
 * Requires at least: 6.3
 * Requires PHP:      8.0
 * Author:            Escritório Móvel
 * Author URI:        https://escritoriomovel.com
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.pt-br.html
 * Text Domain:       quemdisse
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) || !function_exists( 'add_action' ) ) {
  die;
}

define( 'QUEMDISSE_VERSION', '1.1' );
define( 'QUEMDISSE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QUEMDISSE__MINIMUM_WP_VERSION', '6.3' );

require_once( QUEMDISSE__PLUGIN_DIR . 'class.quemdisse.php' );
require_once( QUEMDISSE__PLUGIN_DIR . 'class.quemdisse-admin.php' );
require_once( QUEMDISSE__PLUGIN_DIR . 'class.quemdisse-front.php' );

register_activation_hook( __FILE__, array( 'QuemDisse', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'QuemDisse', 'plugin_deactivation' ) );