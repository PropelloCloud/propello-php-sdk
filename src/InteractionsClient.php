<?php

declare(strict_types=1);

namespace PropelloCloud;

use PropelloCloud\Abstracts\ClientAbstract;
use stdClass;
use Throwable;

class InteractionsClient extends ClientAbstract
{
    /**
     * @throws Throwable
     */
    public function listByEmail(string $email, array $filters = []): stdClass
    {
        return $this->list('email', $email, $filters);
    }

    /**
     * @throws Throwable
     */
    public function listByUid(string $uid, array $filters = []): stdClass
    {
        return $this->list('UID', $uid, $filters);
    }

    /**
     * @throws Throwable
     */
    public function listById(int|string $id, array $filters = []): stdClass
    {
        return $this->list('id', $id, $filters);
    }

    /**
     * @throws Throwable
     */
    public function storeByEmail(string $email, array $interaction): stdClass
    {
        return $this->store('email', $email, $interaction);
    }

    /**
     * @throws Throwable
     */
    public function storeByUid(string $uid, array $interaction): stdClass
    {
        return $this->store('UID', $uid, $interaction);
    }

    /**
     * @throws Throwable
     */
    public function storeById(int|string $id, array $interaction): stdClass
    {
        return $this->store('id', $id, $interaction);
    }

    /**
     * @throws Throwable
     */
    private function list(string $identifier, string|int $value, array $filters = []): stdClass
    {
        $this->url = "interactions/list/{$identifier}/{$value}";
        $this->body = $filters;

        return $this->call();
    }

    /**
     * @throws Throwable
     */
    private function store(string $identifier, string|int $value, array $interaction): stdClass
    {
        $this->url = "interactions/{$identifier}/{$value}";
        $this->body = $interaction;

        return $this->call();
    }
}
