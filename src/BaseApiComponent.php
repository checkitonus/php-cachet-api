<?php

namespace CheckItOnUs\Cachet;

use ArrayAccess;
use CheckItOnUs\Cachet\Traits\HasDates;
use CheckItOnUs\Cachet\Traits\HasMetadata;
use NotImplementedException;

abstract class BaseApiComponent implements ArrayAccess, ApiRequest
{
    use HasDates
        ,HasMetadata;

    /**
     * The server that the component is linked to.
     *
     * @var \CheckItOnUs\Cachet\Server
     */
    private $_server;

    /**
     * Hydrates a new instance of a Component.
     *
     * @param array $metadata The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        $this->setServer($server)
            ->setMetadata($metadata);
    }

    /**
     * Sets the server.
     *
     * @param \CheckItOnUs\Cachet\Server $server The server
     *
     * @return \CheckItOnUs\Cachet\Component
     */
    public function onServer(Server $server)
    {
        return $this->setServer($server);
    }

    /**
     * Sets the server.
     *
     * @param \CheckItOnUs\Cachet\Server $server The server
     *
     * @return \CheckItOnUs\Cachet\Component
     */
    public function setServer(Server $server)
    {
        $this->_server = $server;

        return $this;
    }

    /**
     * Retrieves the server that the object is related to.
     *
     * @return CheckItOnUs\Cachet\Server The server.
     */
    public function getServer()
    {
        return $this->_server;
    }

    /**
     * Converts the object to a format which can be used when making an API
     * request.
     *
     * @return mixed
     */
    public function toApi()
    {
        $metadata = $this->getMetadata();

        $apiRequest = [];

        foreach ($metadata as $key => $value) {
            if (empty($value)) {
                continue;
            }

            // Do we have a special mutator for the API requests?
            if (is_a($value, ApiRequest::class)) {
                // We do, so adjust
                $value = $value->toApi();
            }

            // Is the value an array?
            if (!is_array($value)) {
                // It isn't, so make it one
                $value = [
                    $key => $value,
                ];
            }

            foreach ($value as $actual => $data) {
                $apiRequest[$actual] = $data;
            }
        }

        return $apiRequest;
    }

    /**
     * Creates a new component.
     *
     * @return stdClass
     */
    public function create()
    {
        $object = $this->_server
                ->request()
                ->post($this->getApiCreateUrl(), $this->toApi());

        if (isset($object->data, $object->data->id)) {
            $this->setId($object->data->id);
        }

        return $object;
    }

    /**
     * Updates the Component.
     *
     * @return mixed
     */
    public function update()
    {
        // Is there an ID stored?
        if (!$this['id']) {
            // There isn't, so we need to look it up
            $component = self::on($this->_server)
                            ->findByName($this['name']);

            // Did we get it?
            if ($component && $component['id']) {
                // We did, so we are good
                $this['id'] = $component['id'];
            } else {
                // We didn't, so fail
                return false;
            }
        }

        return $this->_server
                ->request()
                ->put($this->getApiUpdateUrl($this['id']), $this->toApi());
    }

    /**
     * Saves the object (either creates or updates).
     *
     * @return stdClass
     */
    public function save()
    {
        if ($this['id']) {
            return $this->update();
        }

        return $this->create();
    }

    /**
     * Processes the deletion of a component.
     *
     * @return stdClass
     */
    public function delete()
    {
        // Is there an ID stored?
        if (!$this['id']) {
            // There isn't, so we need to look it up
            $component = self::on($this->_server)
                            ->findByName($this['name']);

            // Did we get it?
            if ($component && $component['id']) {
                // We did, so we are good
                $this['id'] = $component['id'];
            } else {
                // We didn't, so fail
                return false;
            }
        }

        return $this->_server
            ->request()
            ->delete($this->getApiDeleteUrl());
    }

    /**
     * Retrieves the base API URL for the current object.
     *
     * @throws NotImplementedException (description)
     */
    public static function getApiRootPath()
    {
        throw new NotImplementedException();
    }

    /**
     * The URL which will be used in order to create a new object.
     *
     * @return string The object's create URL
     */
    public function getApiCreateUrl()
    {
        return static::buildUrl('');
    }

    /**
     * The URL which will be used in order to update a new object.
     *
     * @return string The object's update URL
     */
    public function getApiUpdateUrl()
    {
        return static::buildUrl('/:id', [
            'id' => $this['id'],
        ]);
    }

    /**
     * The URL which will be used in order to delete a new object.
     *
     * @return string The object's delete URL
     */
    public function getApiDeleteUrl()
    {
        return static::buildUrl('/:id', [
            'id' => $this['id'],
        ]);
    }

    /**
     * Builds an URL with the related metadata.
     *
     * @param string $url    The url
     * @param array  $values The values
     *
     * @return string The url.
     */
    protected static function buildUrl($url, array $values = [])
    {
        $url = static::getApiRootPath().$url;

        foreach ($values as $key => $value) {
            $url = str_ireplace(':'.$key, $value, $url);
        }

        return $url;
    }
}
