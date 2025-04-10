<?php

declare(strict_types=1);

namespace PropelloCloud\Abstracts;

use PropelloCloud\Client;
use stdClass;
use Throwable;

abstract class ClientAbstract
{
    public string $url = '';

    public array $body = [];
    public array $headers = [];

    public function __construct(protected Client $client)
    {
        //
    }

    /**
     * @throws Throwable
     */
    protected function call(): stdClass
    {
        return $this->client->call($this);
    }
}
