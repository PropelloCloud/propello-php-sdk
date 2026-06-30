<?php

declare(strict_types=1);

namespace PropelloCloud\Tests;

class OffersClientTest extends TestCase
{
    public function test_list_offers(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1], ['id' => 2]]]);

        $this->client->offers->list();

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/offers/list', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_offers_with_organisation_group_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $this->client->offers->list(5);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/offers/list', $request->getUri()->getPath());
        $this->assertEquals(['organisation_group_id' => 5], json_decode($request->getBody()->getContents(), true));
    }

    public function test_get_offer(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['id' => 5, 'title' => 'Test Offer']]);

        $this->client->offers->get(5);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/offers/get/5', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
    }

    public function test_get_offer_with_organisation_group_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['id' => 5]]);

        $this->client->offers->get(5, 10);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/offers/get/5', $request->getUri()->getPath());
        $this->assertEquals(['organisation_group_id' => 10], json_decode($request->getBody()->getContents(), true));
    }
}
