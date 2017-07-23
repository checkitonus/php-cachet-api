<?php

namespace CheckItOnUs\Cachet;

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
    public function getWebRequest()
    {
        return $this->_webRequest;
    }
}