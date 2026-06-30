<?php

declare(strict_types=1);

namespace PropelloCloud\Tests;

class InteractionsClientTest extends TestCase
{
    private array $interactionPayload = [
        'interaction_id' => 'unique-id-123',
        'interaction_type' => 'purchase',
        'interaction_at' => '2024-01-01 12:00:00',
        'interaction_details' => ['amount' => 100],
    ];

    public function test_list_interactions_by_email(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $this->client->interactions->listByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/interactions/list/email/test@example.com', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_interactions_by_uid(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $this->client->interactions->listByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/interactions/list/UID/abc123', $request->getUri()->getPath());
    }

    public function test_list_interactions_by_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $this->client->interactions->listById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/interactions/list/id/42', $request->getUri()->getPath());
    }

    public function test_list_interactions_with_filters(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $filters = [
            'interactions_from' => '2024-01-01 00:00:00',
            'interactions_to' => '2024-12-31 23:59:59',
            'per_page' => 25,
        ];

        $this->client->interactions->listByEmail('test@example.com', $filters);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/interactions/list/email/test@example.com', $request->getUri()->getPath());
        $this->assertEquals($filters, json_decode($request->getBody()->getContents(), true));
    }

    public function test_store_interaction_by_email(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->interactions->storeByEmail('test@example.com', $this->interactionPayload);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/interactions/email/test@example.com', $request->getUri()->getPath());
        $this->assertEquals($this->interactionPayload, json_decode($request->getBody()->getContents(), true));
    }

    public function test_store_interaction_by_uid(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->interactions->storeByUid('abc123', $this->interactionPayload);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/interactions/UID/abc123', $request->getUri()->getPath());
        $this->assertEquals($this->interactionPayload, json_decode($request->getBody()->getContents(), true));
    }

    public function test_store_interaction_by_id(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->interactions->storeById(42, $this->interactionPayload);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/interactions/id/42', $request->getUri()->getPath());
        $this->assertEquals($this->interactionPayload, json_decode($request->getBody()->getContents(), true));
    }
}
