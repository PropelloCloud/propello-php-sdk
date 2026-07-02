<?php

declare(strict_types=1);

namespace PropelloCloud;

use PropelloCloud\Abstracts\ClientAbstract;
use stdClass;
use Throwable;

class GroupClient extends ClientAbstract
{
    /**
     * @throws Throwable
     */
    public function get(?int $organisationGroupId = null): stdClass
    {
        $this->url = 'group';
        $this->body = array_filter(['organisation_group_id' => $organisationGroupId]);

        return $this->call();
    }

    /**
     * @throws Throwable
     */
    public function list(): stdClass
    {
        $this->url = 'group/list';
        $this->body = [];

        return $this->call();
    }
}
