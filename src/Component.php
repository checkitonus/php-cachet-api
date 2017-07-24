<?php

namespace CheckItOnUs\Cachet;

use ArrayAccess;
use CheckItOnUs\Cachet\Server;
use CheckItOnUs\Cachet\Traits\HasMetadata;
use CheckItOnUs\Cachet\Builders\ComponentQuery;

class Component implements ArrayAccess
{
    use HasMetadata;

    const OPERATIONAL = 1;
    const PERFORMANCE_ISSUES = 2;
    const PARTIAL_OUTAGE = 3;
    const MAJOR_OUTAGE = 4;

    /**
     * The server that the component is linked to.
     * 
     * @var \CheckItOnUs\Cachet\Server
     */
    private $_server;

    /**
     * Dictates the server that the Component relates to.
     *
     * @param      \CheckItOnUs\Cachet\Server  $server  The server
     */
    public static function on(Server $server)
    {
        return (new ComponentQuery())
            ->onServer($server);
    }

    /**
     * Hydrates a new instance of a Component
     *
     * @param      array  $metadata  The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        $this->setServer($server)
            ->setMetadata($metadata)
            ->setStatus(self::OPERATIONAL);
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
                ->post('/v1/components', $this->getMetadata());
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
                ->put('/v1/components/' . $this['id'], $this->getMetadata());
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
            ->delete('/v1/components/' . $this['id']);
    }
}