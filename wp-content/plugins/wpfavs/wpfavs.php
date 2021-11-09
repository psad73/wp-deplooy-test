<?php
/**
 * Wp Favs Plugin
 *
 * @package   Wpfavs
 * @author    Ido Navarro <dev@wpnavarro.com>
 * @license   GPL-2.0+
 * @link      https://wpfavs.com
 * @copyright 2021 Wpfavs
 *
 * @wordpress-plugin
 * Plugin Name:       Wp Favs
 * Plugin URI:        https://wpfavs.com
 * Description:       Create and import your favorites plugins lists from wpfavs.com
 * Version:           1.2.1.1
 * Author:            Ido Navarro
 * Author URI:        https://wpfavs.com
 * Text Domain:       wpfavs
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/timersys/wpfavs
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define('WPFAVS_VERSION', '1.2.1.1');
/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-wpfavs-admin.php' );
	add_action( 'plugins_loaded', array( 'Wpfavs_Admin', 'get_instance' ) );

}
