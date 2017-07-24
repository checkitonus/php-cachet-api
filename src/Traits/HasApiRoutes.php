<?php

namespace CheckItOnUs\Cachet\Traits;

use CheckItOnUs\Cachet\Server;

trait HasApiRoutes
{
    /**
     * The server that the component is linked to.
     * 
     * @var \CheckItOnUs\Cachet\Server
     */
    private $_server;

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
                ->post($this->getApiRootPath(), $this->getMetadata());
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
                ->put($this->getApiRootPath() . '/' . $this['id'], $this->getMetadata());
    }

    /**
     * Processes the deletion of a component.
     *
     * @return     stdClass
     */
    public function delete()
    {
        return $this->_server
            ->request()
            ->delete($this->getApiRootPath() . '/' . $this['id']);
    }
}