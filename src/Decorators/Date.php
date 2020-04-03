<?php

namespace CheckItOnUs\Cachet\Decorators;

use Carbon\Carbon;
use CheckItOnUs\Cachet\ApiRequest;
use CheckItOnUs\Cachet\Server;

class Date extends Carbon implements ApiRequest
{
    /**
     * Converts the object to a format which can be used when making an API
     * request.
     *
     * @return mixed
     */
    public function toApi(Server $server = null)
    {
        if ($server && stristr('2.4', $server->version())) {
            return $this->format('Y-m-d H:i');
        }

        return $this->format('d/m/Y H:i');
    }
}
