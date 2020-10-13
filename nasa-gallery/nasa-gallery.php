<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kudindmitriy
 * @since             1.0.0
 * @package           Nasa_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       NASA Gallery
 * Plugin URI:        https://github.com/kudindmitriy/nasa-gallery
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Kudin Dmitry
 * Author URI:        https://github.com/kudindmitriy
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nasa-gallery
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NASA_GALLERY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nasa-gallery-deactivator.php
 */
function deactivate_nasa_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nasa-gallery-deactivator.php';
	Nasa_Gallery_Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_nasa_gallery' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nasa-gallery.php';


require plugin_dir_path( __FILE__ ) . 'includes/class-nasa-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nasa_gallery() {

	$plugin = new Nasa_Gallery();
	$plugin->run();

}
run_nasa_gallery();
