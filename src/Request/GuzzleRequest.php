<?php

namespace CheckItOnUs\Cachet\Request;

use GuzzleHttp\Client;

class GuzzleRequest implements WebRequest
{
    /**
     * The 
     */
    private $_client;

    /**
     * The configuration object
     * 
     * @var \CheckItOnUs\Cachet\Configuration
     */
    private $_configuration;

    public function __construct()
    {
        $this->_client = new Client();
    }

    /**
     * Sets up the configuration for the web request.
     *
     * @param      \CheckItOnUs\Cachet\Configuration  $configuration  The configuration
     * @return     \CheckItOnUs\Cachet\Request\WebRequest
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->_configuration = $configuration;

        if(isset($configuration['base-url'])) {
            $this->_client = new Client([
                'base_uri' => $configuration['base-url'],
            ]);
        }

        return $this;
    }

    /**
     * Performs a GET request.
     *
     * @param      string  $url    The URL suffix to send the request to
     */
    public function get($url)
    {

    }

    /**
     * Performs a DELETE request.
     *
     * @param      string  $url    The URL suffix to send the request to
     */
    public function delete($url)
    {

    }

    /**
     * Performs a POST request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function post($url, $data)
    {

    }

    /**
     * Performs a PUT request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function put($url, $data)
    {

    }

    /**
     * Performs a PATCH request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function patch($url, $data)
    {

    }

    private function raw($method, $url, $data = null)
    {

    }
}