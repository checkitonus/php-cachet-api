<?php

namespace CheckItOnUs\Cachet;

interface ApiRequest
{
    /**
     * Converts the object to a format which can be used when making an API 
     * request.
     * 
     * @return mixed
     */
    function toApi();
}