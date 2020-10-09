<?php
class Nasa_API {
    // url to  Astronomy Picture of the Day api
    protected $apiUrl = 'https://api.nasa.gov/planetary/apod';

    // Nasa API Key
    protected $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    // Get Astronomy Picture of the Day
    public function getAPOD($date)
    {
        $api_key = $this->api_key;

        $json = wp_remote_get($this->apiUrl . '?api_key=' . $api_key . '&date=' . $date);

        return json_decode($json['body']);
    }
}