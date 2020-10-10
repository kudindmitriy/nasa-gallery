<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://github.com/kudindmitriy
 * @since      1.0.0
 *
 * @package    Nasa_Gallery
 */
global $wpdb, $gllr_BWS_demo_data;

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$option_name = 'nasa-gallery';

delete_option($option_name);

// for site options in Multisite
delete_site_option($option_name);
