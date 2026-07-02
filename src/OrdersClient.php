<?php

declare(strict_types=1);

namespace PropelloCloud;

use PropelloCloud\Abstracts\ClientAbstract;
use stdClass;
use Throwable;

class OrdersClient extends ClientAbstract
{
    /**
     * @throws Throwable
     */
    public function listGroupOrders(array $filters = []): stdClass
    {
        $this->url = 'orders';
        $this->body = $filters;

        return $this->call();
    }

    /**
     * @throws Throwable
     */
    public function listUserOrdersByEmail(string $email, array $filters = []): stdClass
    {
        return $this->listUserOrders('email', $email, $filters);
    }

    /**
     * @throws Throwable
     */
    public function listUserOrdersByUid(string $uid, array $filters = []): stdClass
    {
        return $this->listUserOrders('UID', $uid, $filters);
    }

    /**
     * @throws Throwable
     */
    public function listUserOrdersById(int|string $id, array $filters = []): stdClass
    {
        return $this->listUserOrders('id', $id, $filters);
    }

    /**
     * @throws Throwable
     */
    private function listUserOrders(string $identifier, string|int $value, array $filters = []): stdClass
    {
        $this->url = "orders/{$identifier}/{$value}";
        $this->body = $filters;

        return $this->call();
    }
}
