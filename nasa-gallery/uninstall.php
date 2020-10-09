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

if ( ! function_exists( 'get_plugins' ) )
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$all_plugins = get_plugins();

if ( ! array_key_exists( 'nasa-gallery/nasa-gallery.php', $all_plugins ) ) {
    if ( function_exists( 'is_multisite' ) && is_multisite() ) {
        $old_blog = $wpdb->blogid;
        /* Get all blog ids */
        $blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
        foreach ( $blogids as $blog_id ) {
            switch_to_blog( $blog_id );
            delete_option( 'nasa-gallery' );
        }
        switch_to_blog( $old_blog );
    } else {
        delete_option( 'nasa-gallery' );
    }
}

if ( is_multisite() )
    delete_site_option( 'nasa-gallery' );