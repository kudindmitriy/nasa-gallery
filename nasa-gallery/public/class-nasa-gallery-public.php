<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/kudindmitriy
 * @since      1.0.0
 *
 * @package    Nasa_Gallery
 * @subpackage Nasa_Gallery/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nasa_Gallery
 * @subpackage Nasa_Gallery/public
 * @author     Kudin Dmitry <kudin.dima@gmail.com>
 */
class Nasa_Gallery_Public {

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

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->plugin_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name . 'slick', plugin_dir_url( __FILE__ ) . 'css/slick.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . 'slick-theme', plugin_dir_url( __FILE__ ) . 'css/slick-theme.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nasa-gallery-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name . 'slick', plugin_dir_url( __FILE__ ) . 'js/slick.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nasa-gallery-public.js', array( 'jquery' ), $this->version, true );

	}

    public function register_shortcodes() {
        add_shortcode('nasa_apod', array($this, 'shortcode_apod'));
    }

    public function shortcode_apod($atts)
    {
        $atts = shortcode_atts(array(
            'images' => 5,
            'width' => 500,
            'height' => 300,
        ),$atts);

        $posts = get_posts( array(
            'post_type'   => 'post-nasa-gallery',
            'post_status' => 'publish',
        ) );

        if (empty($posts)) {
            return 'No images to display';
        }

        $html = '<div class="nasa-slider">';
        foreach ($posts as $post) {
            $thumbnail = get_the_post_thumbnail( $post->ID, array($atts['width'], $atts['height']) );
            $html .= '<div><div class="nasa-slider-item">'.$thumbnail.'</div></div>';
        }
        $html  .= '</div>';

        return $html;
    }


}
