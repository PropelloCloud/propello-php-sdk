<?php

declare(strict_types=1);

namespace PropelloCloud;

use PropelloCloud\Abstracts\ClientAbstract;
use stdClass;
use Throwable;

class OffersClient extends ClientAbstract
{
    /**
     * @throws Throwable
     */
    public function list(?int $organisationGroupId = null): stdClass
    {
        $this->url = 'offers/list';
        $this->body = array_filter(['organisation_group_id' => $organisationGroupId]);

        return $this->call();
    }

    /**
     * @throws Throwable
     */
    public function get(int $id, ?int $organisationGroupId = null): stdClass
    {
        $this->url = "offers/get/{$id}";
        $this->body = array_filter(['organisation_group_id' => $organisationGroupId]);

        return $this->call();
    }
}
