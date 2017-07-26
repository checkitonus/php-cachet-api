<?php

namespace CheckItOnUs\Cachet;

use ArrayAccess;
use Carbon\Carbon;
use NotImplementedException;
use CheckItOnUs\Cachet\Server;

abstract class BaseApiComponent implements ArrayAccess
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
     * Retrieves the server that the object is related to.
     *
     * @return     CheckItOnUs\Cachet\Server  The server.
     */
    public function getServer()
    {
        return $this->_server;
    }

    /**
     * Gets the created at.
     *
     * @return     <type>  The created at.
     */
    public function getCreatedAt()
    {
        return empty($this->_metadata['created_at']) ? null : Carbon::parse($this->_metadata['created_at']);
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
    public function getApiCreateUrl()
    {
        return static::buildUrl('');
    }

    /**
     * The URL which will be used in order to update a new object
     *
     * @return     string  The object's update URL
     */
    public function getApiUpdateUrl()
    {
        return static::buildUrl('/:id', [
            'id' => $this['id']
        ]);
    }

    /**
     * The URL which will be used in order to delete a new object
     *
     * @return     string  The object's delete URL
     */
    public function getApiDeleteUrl()
    {
        return static::buildUrl('/:id', [
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
    protected static function buildUrl($url, array $values = [])
    {
        $url = static::getApiRootPath() . $url;

        foreach($values as $key => $value) {
            $url = str_ireplace(':' . $key, $value, $url);
        }

        return $url;
    }
}