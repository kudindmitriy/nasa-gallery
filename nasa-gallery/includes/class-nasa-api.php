<?php
class Nasa_API {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    // url to  Astronomy Picture of the Day api
    protected $apiUrl = 'https://api.nasa.gov/planetary/apod';

    // Nasa API Key
    protected $api_key;

    public function __construct($api_key, $plugin_name)
    {
        $this->api_key = $api_key;
        $this->plugin_name = $plugin_name;
    }

    // Get Astronomy Picture of the Day
    public function getAPOD($date)
    {
        $api_key = $this->api_key;

        if (empty($api_key)) {
            return new WP_Error('no_api_key', __('',  $this->plugin_name));
        }

        $json = wp_remote_get($this->apiUrl . '?api_key=' . $api_key . '&date=' . $date);

        return json_decode($json['body']);
    }
}