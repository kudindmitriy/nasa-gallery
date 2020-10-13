<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/kudindmitriy
 * @since      1.0.0
 *
 * @package    Nasa_Gallery
 * @subpackage Nasa_Gallery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nasa_Gallery
 * @subpackage Nasa_Gallery/admin
 * @author     Kudin Dmitry <kudin.dima@gmail.com>
 */
class Nasa_Gallery_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    /**
     * @var false|mixed|void
     */

    private $plugin_options;
    private $ajax_nonce_action;

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->plugin_options = get_option($this->plugin_name);
        $this->ajax_nonce_action = $this->plugin_name . 'ajax-nonce';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nasa_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nasa_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nasa-gallery-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nasa_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nasa_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nasa-gallery-admin.js', array( 'jquery' ), $this->version, false );

        wp_localize_script( $this->plugin_name, 'localize',
            array(
                'nonce' => wp_create_nonce($this->ajax_nonce_action)
            )
        );



    }


    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     */

    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
        */
        add_options_page( 'Nasa Gallery Setup', 'Nasa Gallery', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     */

    public function add_action_links( $links ) {

        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     */

    public function display_plugin_setup_page() {

        include_once( 'partials/nasa-gallery-admin-display.php' );

    }

    /**
     * Validate options
     */
    public function validate($input) {
        $valid = array();
        $valid['api_key'] = (isset($input['api_key']) && !empty($input['api_key'])) ? $input['api_key'] : '';

        if (!empty($valid['api_key'])) {
            $this->check_uploaded_nasa_gallery();
        }

        return $valid;
    }

    /**
     * Update all options
     */
    public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    /**
     * Create custom post type
     */
    function nasa_gallery_post_type() {
        $labels = array(
            'name'               => __( 'NASA gallery', $this->plugin_name),
            'singular_name'      => __( 'NASA gallery', $this->plugin_name),
            'menu_name'          => __( 'NASA gallery', $this->plugin_name),
            'name_admin_bar'     => __( 'NASA gallery', $this->plugin_name),
            'add_new'            => __( 'Add New', $this->plugin_name),
            'add_new_item'       => __( 'Add New NASA gallery', $this->plugin_name),
            'new_item'           => __( 'New NASA gallery', $this->plugin_name),
            'edit_item'          => __( 'Edit NASA gallery', $this->plugin_name),
            'view_item'          => __( 'View NASA gallery', $this->plugin_name),
            'all_items'          => __( 'All NASA gallery', $this->plugin_name),
            'search_items'       => __( 'Search NASA gallery', $this->plugin_name),
            'parent_item_colon'  => __( 'Parent NASA gallery:', $this->plugin_name),
            'not_found'          => __( 'No NASA gallery found.', $this->plugin_name),
            'not_found_in_trash' => __( 'No NASA gallery found in Trash.', $this->plugin_name),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-format-gallery',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'post-nasa-gallery' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => array( 'title', 'editor', 'thumbnail' )
        );
        register_post_type( 'post-nasa-gallery', $args );
    }

    /**
     * Create posts with images
     * @param string $date
     */
    function get_nasa_apod($date = '') {
        if (empty($date)) {
            $date = wp_date( 'Y-m-d' );
        }
        $api_key = $this->plugin_options['api_key'];
        $NasaAPI = new Nasa_API($api_key, $this->plugin_name);

        $post = get_page_by_title($date, OBJECT, 'post-nasa-gallery');
        if (!empty($post)) {
            return;
        }

        $nasa_image = $NasaAPI->getAPOD($date);

        if (!empty($nasa_image) && !empty($nasa_image->url) && !is_wp_error($nasa_image)) {

            if (isset($nasa_image->media_type) && $nasa_image->media_type === 'video') {
                return;
            }

            $post_id = wp_insert_post(array(
                'post_title' => $nasa_image->date,
                'post_type' => 'post-nasa-gallery',
                'post_status' => 'publish',
            ));

            $upload_dir = wp_upload_dir();
            $image_data = file_get_contents($nasa_image->url);
            $filename = basename($nasa_image->url);
            if (wp_mkdir_p($upload_dir['path'])) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }
            file_put_contents($file, $image_data);

            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            set_post_thumbnail( $post_id, $attach_id );
        }

    }

    public function check_uploaded_nasa_gallery() {

        $posts = get_posts( array(
            'post_type'   => 'post-nasa-gallery',
            'post_status' => 'publish',
        ) );

        if (count($posts) < 5) {
            for ($i = 1; $i <= 5 - count($posts); $i++) {
                $response[] = $this->get_nasa_apod(wp_date( 'Y-m-d' ,  strtotime('-'. $i . ' day')));
            }
        }
    }

    public function ajax_upload_images() {

        if( ! wp_verify_nonce( $_POST['nonce_code'], $this->ajax_nonce_action ) ) {
            wp_die( __('Invalid nonce code', $this->plugin_name) , 403 );
        }

        $this->check_uploaded_nasa_gallery();
        die( json_encode( __('Images uploaded', $this->plugin_name) ) );
    }

}
