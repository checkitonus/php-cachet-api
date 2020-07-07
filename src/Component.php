<?php

namespace CheckItOnUs\Cachet;

use CheckItOnUs\Cachet\Builders\ComponentQuery;
use CheckItOnUs\Cachet\Decorators\Tags;

class Component extends BaseApiComponent
{
    const UNKNOWN = 0;
    const OPERATIONAL = 1;
    const PERFORMANCE_ISSUES = 2;
    const PARTIAL_OUTAGE = 3;
    const MAJOR_OUTAGE = 4;

    /**
     * Dictates the server that the Component relates to.
     *
     * @param \CheckItOnUs\Cachet\Server $server The server
     */
    public static function on(Server $server)
    {
        return (new ComponentQuery())
            ->onServer($server);
    }

    public static function getApiRootPath()
    {
        return '/v1/components';
    }

    public function getGroup()
    {
        if (empty($this['group_id'])) {
            return;
        }

        return ComponentGroup::on($this->getServer())
                ->findById($this['group_id']);
    }

    /**
     * Retrieves the current status code of the component.
     *
     * @return int The status.
     */
    public function getStatus()
    {
        return isset($this->_metadata['status']) ? $this->_metadata['status'] : self::OPERATIONAL;
    }

    /**
     * Sets the tags.
     *
     * @param object|array $value The value
     *
     * @return CheckItOnUs\Cachet\Component
     */
    public function setTags($value)
    {
        $this->_metadata['tags'] = new Tags(array_filter((array) $value));

        return $this;
    }

    /**
     * Gets the tags.
     *
     * @return Illuminate\Support\Collection The tags.
     */
    public function getTags()
    {
        return empty($this->_metadata['tags']) ? new Tags() : $this->_metadata['tags'];
    }

    /**
     * Adds a tag to the list.
     *
     * @param string $value The value
     *
     * @return CheckItOnUs\Cachet\Component
     */
    public function addTag($value)
    {
        $this['tags']->push($value);

        return $this;
    }

    /**
     * Converts the status name field into the status code which is required.
     *
     * @param string $value The value
     *
     * @return CheckItOnUs\Cachet\Component
     */
    public function setStatusName($value)
    {
        // Try to translate the status
        if (isset($value)) {
            // It existed, so translate into something we understand
            $status = strtoupper($value);
            $this['status'] = constant(self::class.'::'.str_replace(' ', '_', $status));
        }

        return $this;
    }
}
