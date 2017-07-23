<?php

namespace CheckItOnUs\Request;

use Iterator;
use CheckItOnUs\Cachet\Request\WebRequest;

class PagedResponse implements Iterator
{
    /**
     * The configured web request object.
     * 
     * @var \CheckItOnUs\Cachet\Request\WebRequest
     */
    private $_webRequest;

    /**
     * The URL that was previously requested
     * 
     * @var string
     */
    private $_url;

    /**
     * The current page that we are on
     *
     * @var        integer
     */
    private $_page = 1;

    private $_maximumPage = 1;

    /**
     * Internal cached storage of the data which was previously retrieved.
     *
     * @var        array
     */
    private $_pagedData = [];

    public $data;

    public function __construct(WebRequest $webRequest, $url)
    {
        $this->_webRequest = $webRequest;
        $this->_url = $url;
    }

    public function current()
    {
        // Do we already have the current page's data?
        if(isset($this->_pagedData[$this->_page])) {
            // We do, so return it
            return $this->data = $this->_pagedData[$this->_page];
        }

        return $this->data = $this->_pagedData[$this->_page] = $this->sendRequest();
    }

    public function key()
    {
        return $this->_page;
    }

    public function next()
    {
        $this->_page++;
    }

    public function rewind()
    {
        $this->_page = 1;
    }

    public function valid()
    {
        return $this->_page < $this->_maximumPage;
    }

    private function sendRequest()
    {
        $url = $this->_url;

        if($this->_page > 1) {
            $url .= '?page=' . $this->_page;
        }

        $response = $this->_webRequest->get($url);

        // Is there pagination information?
        if(isset($response->meta, $response->meta->pagination)) {
            $this->_maximumPage = $response->meta->pagination->total_pages;
        }

        return is_array($response->data) ? collect($response->data) : $response->data;
    }
}