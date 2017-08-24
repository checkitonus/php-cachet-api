<?php

namespace CheckItOnUs\Cachet\Request;

use CheckItOnUs\Cachet\Request\GuzzleRequest;

class SpoofedVerbRequest extends GuzzleRequest
{
    /**
     * Performs a DELETE request.
     *
     * @param      string  $url    The URL suffix to send the request to
     */
    public function delete($url)
    {
        return $this->post($url, [
            '_method' => 'DELETE',
        ]);
    }

    /**
     * Performs a PUT request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function put($url, $data)
    {
        $data['_method'] = 'PUT';

        return $this->post($url, $data);
    }

    /**
     * Performs a PATCH request.
     *
     * @param      string  $url   The URL suffix to send the request to
     * @param      array  $data   The data to send
     */
    public function patch($url, $data)
    {
        $data['_method'] = 'PATCH';

        return $this->post($url, $data);
    }
}