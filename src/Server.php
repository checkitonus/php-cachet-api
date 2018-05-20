<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Request\GuzzleRequest;
use CheckItOnUs\Cachet\Request\SpoofedVerbRequest;

class Server
{
    /**
     * The configuration object.
     *
     * @var \CheckItOnUs\Cachet\Configuration
     */
    private $_configuration;

    /**
     * The object which will be used for any web requests.
     *
     * @var \CheckItOnUs\Cachet\Request\WebRequest
     */
    private $_webRequest;

    /**
     * The version of the server.
     */
    private $_version;

    /**
     * Initializes the Cachet component.
     *
     * @param   $configuration The configuration
     */
    public function __construct($configuration = null, $webRequest = null)
    {
        if (is_a($configuration, Configuration::class)) {
            $this->_configuration = $configuration;
        } elseif (!empty($configuration) && is_array($configuration)) {
            $this->_configuration = new Configuration($configuration);
        }

        if (!is_a($webRequest, WebRequest::class)) {
            $webRequest = ($this->_configuration['spoof'] ? new SpoofedVerbRequest() : new GuzzleRequest())
                            ->setConfiguration($this->_configuration);
        }

        $this->_webRequest = $webRequest;
    }

    /**
     * Sets the configuration.
     *
     * @param Configuration $value The value
     *
     * @return \CheckItOnUs\Cachet\Cachet
     */
    public function setConfiguration(Configuration $value)
    {
        $this->_configuration = $value;

        $this->request()
            ->setConfiguration($value);

        return $this;
    }

    /**
     * Retrieves the configuration object.
     *
     * @return \CheckItOnUs\Cachet\Configuration The configuration.
     */
    public function getConfiguration()
    {
        return $this->_configuration;
    }

    /**
     * Retrieves the web request object.
     *
     * @return \CheckItOnUs\Cachet\Request\WebRequest
     */
    public function request()
    {
        return $this->_webRequest;
    }

    /**
     * Sends a ping request to the server (verifies connectivity to the server).
     *
     * @ref https://docs.cachethq.io/reference#ping
     *
     * @return stdClass
     */
    public function ping()
    {
        return $this->request()
                ->get('/v1/ping')
                ->data;
    }

    /**
     * Gets the version of Cachet currently installed on the server.
     *
     * @ref https://docs.cachethq.io/reference#version
     *
     * @return stdClass
     */
    public function version()
    {
        if ($this->_version) {
            return $this->_version;
        }

        return $this->_version = $this->request()
                ->get('/v1/version')
                ->data;
    }

    /**
     * Returns a collection of components.
     *
     * @return Illuminate\Support\Collection
     */
    public function components()
    {
        return Component::on($this)
                ->all();
    }

    /**
     * Retrieves a collection of Component Groups.
     *
     * @return Illuminate\Support\Collection
     */
    public function componentGroups()
    {
        return ComponentGroup::on($this)
            ->all();
    }

    /**
     * Retrieves a list of Incidents.
     *
     * @return Illuminate\Support\Collection
     */
    public function incidents()
    {
        return Incident::on($this)
                ->all();
    }
}
