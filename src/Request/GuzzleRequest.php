<?php

namespace CheckItOnUs\Cachet\Request;

use GuzzleHttp\Client;
use CheckItOnUs\Request\PagedResponse;

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

    /**
     * Initialize the object.
     */
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
        return new PagedResponse(
            $this,
            $url
        );
    }

    /**
     * Performs a DELETE request.
     *
     * @param      string  $url    The URL suffix to send the request to
     */
    public function delete($url)
    {
        return $this->raw('DELETE', $url);
    }

    /**
     * Performs a POST request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function post($url, $data)
    {
        return $this->raw('POST', $url, $data);
    }

    /**
     * Performs a PUT request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function put($url, $data)
    {
        return $this->raw('PUT', $url, $data);
    }

    /**
     * Performs a PATCH request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function patch($url, $data)
    {
        return $this->raw('PATCH', $url, $data);
    }

    /**
     * Processes a raw request.
     *
     * @param      string  $method  The method
     * @param      string  $url     The url
     * @param      mixed  $data    The data
     *
     * @return     Object
     */
    private function raw($method, $url, $data = null)
    {
        $headers = [
            'X-Cachet-Token' => $this->_configuration['api-key'],
        ];

        if(!empty($data)) {
            $headers['form_data'] = $data;
        }

        return json_decode(
            $this->_client->request($method, $url, $headers)
        );
    }
}