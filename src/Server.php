<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Component;
use CheckItOnUs\Cachet\ComponentGroup;
use CheckItOnUs\Cachet\Request\GuzzleRequest;

class Server
{
    /**
     * The configuration object
     *
     * @var        \CheckItOnUs\Cachet\Configuration
     */
    private $_configuration;

    /**
     * The object which will be used for any web requests
     * 
     * @var \CheckItOnUs\Cachet\Request\WebRequest
     */
    private $_webRequest;

    /**
     * Initializes the Cachet component
     *
     * @param      $configuration  The configuration
     */
    public function __construct($configuration = null, $webRequest = null)
    {
        if(is_a($configuration, Configuration::class)) {
            $this->_configuration = $configuration;    
        }
        else if(!empty($configuration) && is_array($configuration)) {
            $this->_configuration = new Configuration($configuration);
        }

        if(!is_a($webRequest, WebRequest::class)) {
            $webRequest = (new GuzzleRequest())
                            ->setConfiguration($this->_configuration);
        }

        $this->_webRequest = $webRequest;
    }

    /**
     * Sets the configuration.
     *
     * @param      Configuration  $value  The value
     *
     * @return     \CheckItOnUs\Cachet\Cachet
     */
    public function setConfiguration(Configuration $value)
    {
        $this->_configuration = $value;

        $this->request()
            ->setConfiguration($value);

        return $this;
    }

    /**
     * Retrieves the configuration object
     *
     * @return     \CheckItOnUs\Cachet\Configuration  The configuration.
     */
    public function getConfiguration()
    {
        return $this->_configuration;
    }

    /**
     * Retrieves the web request object
     *
     * @return \CheckItOnUs\Cachet\Request\WebRequest
     */
    public function request()
    {
        return $this->_webRequest;
    }

    /**
     * Sends a ping request to the server (verifies connectivity to the server)
     *
     * @ref https://docs.cachethq.io/reference#ping
     * @return     stdClass
     */
    public function ping()
    {
        return $this->request()
                ->get('/v1/ping')
                ->data;
    }

    /**
     * Gets the version of Cachet currently installed on the server
     *
     * @ref https://docs.cachethq.io/reference#version
     * @return     stdClass 
     */
    public function version()
    {
        return $this->request()
                ->get('/v1/version')
                ->data;    
    }

    public function components()
    {
        return Component::on($this)
                ->all();
    }

    public function componentGroups()
    {
        return ComponentGroup::on($this)
            ->all();
    }
}