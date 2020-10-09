<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/kudindmitriy
 * @since      1.0.0
 *
 * @package    Nasa_Gallery
 * @subpackage Nasa_Gallery/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Nasa_Gallery
 * @subpackage Nasa_Gallery/includes
 * @author     Kudin Dmitry <kudin.dima@gmail.com>
 */
class Nasa_Gallery_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        wp_clear_scheduled_hook( 'nasa_cron' );
        wp_clear_scheduled_hook( 'check_nasa_gallery' );
	}

}
