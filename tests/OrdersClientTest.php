<?php

declare(strict_types=1);

namespace PropelloCloud\Tests;

class OrdersClientTest extends TestCase
{
    public function test_list_group_orders(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1], ['id' => 2]]]);

        $this->client->orders->listGroupOrders();

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/orders', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_group_orders_with_filters(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $this->client->orders->listGroupOrders(['page' => 1, 'per_page' => 10]);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/orders', $request->getUri()->getPath());
        $this->assertEquals(['page' => 1, 'per_page' => 10], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_group_orders_with_organisation_group_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $this->client->orders->listGroupOrders(['organisation_group_id' => 5]);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/orders', $request->getUri()->getPath());
        $this->assertEquals(['organisation_group_id' => 5], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_user_orders_by_email(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 10]]]);

        $this->client->orders->listUserOrdersByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/orders/email/test@example.com', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_user_orders_by_email_with_organisation_group_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 10]]]);

        $this->client->orders->listUserOrdersByEmail('test@example.com', ['organisation_group_id' => 5]);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/orders/email/test@example.com', $request->getUri()->getPath());
        $this->assertEquals(['organisation_group_id' => 5], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_user_orders_by_uid(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 10]]]);

        $this->client->orders->listUserOrdersByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/orders/UID/abc123', $request->getUri()->getPath());
    }

    public function test_list_user_orders_by_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 10]]]);

        $this->client->orders->listUserOrdersById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/orders/id/42', $request->getUri()->getPath());
    }

}
