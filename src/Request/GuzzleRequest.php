<?php

namespace CheckItOnUs\Cachet\Request;

use CheckItOnUs\Cachet\Configuration;
use CheckItOnUs\Cachet\Exceptions\UnauthorizedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GuzzleRequest implements WebRequest
{
    /**
     * The base guzzle HTTP client.
     */
    private $_client;

    /**
     * The configuration object.
     *
     * @var \CheckItOnUs\Cachet\Configuration
     */
    private $_configuration;

    /**
     * Initialize the object.
     */
    public function __construct()
    {
        $this->_client = new Client([
            'http_errors' => false,
        ]);
    }

    /**
     * Sets up the configuration for the web request.
     *
     * @param \CheckItOnUs\Cachet\Configuration $configuration The configuration
     *
     * @return \CheckItOnUs\Cachet\Request\WebRequest
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->_configuration = $configuration;

        if ($configuration->getBaseUrl()) {
            $this->_client = new Client([
                'base_uri'    => $configuration->getBaseUrl(),
                'http_errors' => false,
            ]);
        }

        return $this;
    }

    /**
     * Performs a GET request.
     *
     * @param string $url The URL suffix to send the request to
     */
    public function get($url)
    {
        return new PagedResponse(
            $this,
            $url
        );
    }

    /**
     * Performs a raw GET request.
     *
     * @param string $url THe URL suffix to send the request to
     *
     * @return mixed
     */
    public function getRaw($url)
    {
        try {
            return $this->raw('GET', $url);
        } catch (ClientException $ex) {
            if ($ex->getResponse()->getStatusCode() == 404) {
                return;
            }

            throw $ex;
        }
    }

    /**
     * Performs a DELETE request.
     *
     * @param string $url The URL suffix to send the request to
     */
    public function delete($url)
    {
        return $this->raw('DELETE', $url);
    }

    /**
     * Performs a POST request.
     *
     * @param string $url  The URL suffix to send the request to
     * @param array  $data The data to send
     */
    public function post($url, $data)
    {
        return $this->raw('POST', $url, $data);
    }

    /**
     * Performs a PUT request.
     *
     * @param string $url  The URL suffix to send the request to
     * @param array  $data The data to send
     */
    public function put($url, $data)
    {
        return $this->raw('PUT', $url, $data);
    }

    /**
     * Performs a PATCH request.
     *
     * @param string $url  The URL suffix to send the request to
     * @param array  $data The data to send
     */
    public function patch($url, $data)
    {
        return $this->raw('PATCH', $url, $data);
    }

    /**
     * Processes a raw request.
     *
     * @param string $method The method
     * @param string $url    The url
     * @param mixed  $data   The data
     *
     * @return object
     */
    private function raw($method, $url, $data = null)
    {
        $headers = [
            'headers' => [
                'X-Cachet-Token' => $this->_configuration->getApiKey(),
            ],
        ];

        if (!empty($data)) {
            $headers['form_params'] = $data;
        }

        $response = $this->_client
            ->request($method, '/api'.$url, $headers);

        $data = json_decode(
            $response->getBody()
                ->__toString()
        );

        if ($response->getStatusCode() === 401) {
            throw new UnauthorizedException('There was an issue with Authentication.  Please check your API key and try again.');
        }

        if ($response->getStatusCode() === 500) {
            $error = collect($data->errors)->first();

            throw new \Exception($error->detail);
        }

        return $data;
    }
}
