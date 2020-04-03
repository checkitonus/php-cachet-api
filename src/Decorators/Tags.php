<?php

namespace CheckItOnUs\Cachet\Decorators;

use CheckItOnUs\Cachet\ApiRequest;
use CheckItOnUs\Cachet\Server;
use Illuminate\Support\Collection;

class Tags extends Collection implements ApiRequest
{
    /**
     * Converts the object to a format which can be used when making an API
     * request.
     *
     * @return mixed
     */
    public function toApi(Server $server = null)
    {
        return [
            'tags' => $this->all(),
        ];
    }
}
