<?php

namespace CheckItOnUs\Cachet\Request;

use CheckItOnUs\Cachet\Configuration;

interface WebRequest
{
    /**
     * Sets up the configuration for the web request.
     *
     * @param \CheckItOnUs\Cachet\Configuration $configuration The configuration
     */
    public function setConfiguration(Configuration $configuration);

    /**
     * Performs a GET request.
     *
     * @param string $url The URL suffix to send the request to
     *
     * @return \CheckItOnUs\Cachet\Request\PagedResponse
     */
    public function get($url);

    /**
     * Performs a raw GET request.
     *
     * @param string $url The URL suffix to send the request to
     *
     * @return mixed
     */
    public function getRaw($url);

    /**
     * Performs a DELETE request.
     *
     * @param string $url The URL suffix to send the request to
     */
    public function delete($url);

    /**
     * Performs a POST request.
     *
     * @param string $url  The URL suffix to send the request to
     * @param array  $data The data to send
     */
    public function post($url, $data);

    /**
     * Performs a PUT request.
     *
     * @param string $url  The URL suffix to send the request to
     * @param array  $data The data to send
     */
    public function put($url, $data);

    /**
     * Performs a PATCH request.
     *
     * @param string $url  The URL suffix to send the request to
     * @param array  $data The data to send
     */
    public function patch($url, $data);
}
