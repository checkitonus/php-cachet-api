<?php

namespace CheckItOnUs\Cachet\Builders;

use CheckItOnUs\Cachet\Server;

abstract class BaseQuery
{
    /**
     * The server that the component is linked to.
     *
     * @var \CheckItOnUs\Cachet\Server
     */
    private $_server;

    /**
     * Sets the server which we will be looking at.
     *
     * @param \CheckItOnUs\Cachet\Server $server The server
     */
    public function onServer(Server $server)
    {
        $this->_server = $server;

        return $this;
    }

    /**
     * Retrieves the server we are currently associated with.
     *
     * @return \CheckItOnUs\Cachet\Server The server.
     */
    protected function getServer()
    {
        return $this->_server;
    }
}
