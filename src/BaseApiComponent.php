<?php

namespace CheckItOnUs\Cachet;

use NotImplementedException;
use CheckItOnUs\Cachet\Server;

class BaseApiComponent
{
    /**
     * The server that the component is linked to.
     * 
     * @var \CheckItOnUs\Cachet\Server
     */
    private $_server;

    /**
     * Hydrates a new instance of a Component
     *
     * @param      array  $metadata  The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        $this->setServer($server)
            ->setMetadata($metadata);
    }

    /**
     * Sets the server.
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     * @return     \CheckItOnUs\Cachet\Component
     */
    public function onServer(Server $server)
    {
        return $this->setServer($server);
    }

    /**
     * Sets the server.
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     * @return     \CheckItOnUs\Cachet\Component
     */
    public function setServer(Server $server)
    {
        $this->_server = $server;
        return $this;
    }

    /**
     * Creates a new component
     *
     * @return     stdClass
     */
    public function create()
    {
        return $this->_server
                ->request()
                ->post($this->getApiCreateUrl(), $this->getMetadata());
    }

    /**
     * Updates the Component
     *
     * @return     mixed
     */
    public function update()
    {
        // Is there an ID stored?
        if(!$this['id']) {
            // There isn't, so we need to look it up
            $component = self::on($this->_server)
                            ->findByName($this['name']);

            // Did we get it?
            if($component && $component['id']) {
                // We did, so we are good
                $this['id'] = $component['id'];
            }
            else {
                // We didn't, so fail
                return false;
            }
        }

        return $this->_server
                ->request()
                ->put($this->getApiUpdateUrl($this['id']), $this->getMetadata());
    }

    /**
     * Processes the deletion of a component.
     *
     * @return     stdClass
     */
    public function delete()
    {
        // Is there an ID stored?
        if(!$this['id']) {
            // There isn't, so we need to look it up
            $component = self::on($this->_server)
                            ->findByName($this['name']);

            // Did we get it?
            if($component && $component['id']) {
                // We did, so we are good
                $this['id'] = $component['id'];
            }
            else {
                // We didn't, so fail
                return false;
            }
        }

        return $this->_server
            ->request()
            ->delete($this->getApiDeleteUrl());
    }

    /**
     * Retrieves the base API URL for the current object
     *
     * @throws     NotImplementedException  (description)
     */
    public static function getApiRootPath()
    {
        throw new NotImplementedException();
    }

    /**
     * The URL which will be used in order to create a new object
     *
     * @return     string  The object's create URL
     */
    public static function getApiCreateUrl()
    {
        return static::buildUrl(':root-path');
    }

    /**
     * The URL which will be used in order to update a new object
     *
     * @return     string  The object's update URL
     */
    public function getApiUpdateUrl()
    {
        return static::buildUrl(':root-path/:id', [
            'id' => $this['id']
        ]);
    }

    /**
     * The URL which will be used in order to delete a new object
     *
     * @return     string  The object's delete URL
     */
    public static function getApiDeleteUrl()
    {
        return static::buildUrl(':root-path/:id', [
            'id' => $this['id']
        ]);
    }

    /**
     * Builds an URL with the related metadata
     *
     * @param      string  $url     The url
     * @param      array   $values  The values
     *
     * @return     string  The url.
     */
    private static function buildUrl($url, array $values)
    {
        $values['root-path'] = static::getApiRootPath();

        foreach($values as $key => $value) {
            $url = str_replace(':' . $key, $value, $url);
        }

        return $url;
    }
}