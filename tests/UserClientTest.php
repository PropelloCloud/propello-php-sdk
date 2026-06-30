<?php

declare(strict_types=1);

namespace PropelloCloud\Tests;

class UserClientTest extends TestCase
{
    public function test_create_user(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['id' => 1]]);

        $result = $this->client->user->create(['email' => 'test@example.com', 'first_name' => 'Test']);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/create', $request->getUri()->getPath());
        $this->assertEquals(['email' => 'test@example.com', 'first_name' => 'Test'], json_decode($request->getBody()->getContents(), true));
        $this->assertTrue($result->success);
        $this->assertEquals(1, $result->data->id);
    }

    public function test_create_bulk_users(): void
    {
        $this->mockResponse(['success' => true, 'queued' => 2]);

        $this->client->user->createBulk(
            [['email' => 'a@example.com'], ['email' => 'b@example.com']],
            false
        );

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/create/bulk', $request->getUri()->getPath());
        $body = json_decode($request->getBody()->getContents(), true);
        $this->assertFalse($body['send_activation_email']);
        $this->assertCount(2, $body['data']);
    }

    public function test_create_with_login(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['login_url' => 'https://example.com/login']]);

        $this->client->user->createWithLogin(['email' => 'test@example.com']);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/create/login-url', $request->getUri()->getPath());
        $this->assertEquals(['email' => 'test@example.com'], json_decode($request->getBody()->getContents(), true));
    }

    public function test_get_user_by_email(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['email' => 'test@example.com']]);

        $result = $this->client->user->getUserByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/get/email/test@example.com', $request->getUri()->getPath());
        $this->assertTrue($result->success);
        $this->assertEquals('test@example.com', $result->data->email);
    }

    public function test_get_user_by_uid(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['uid' => 'abc123']]);

        $this->client->user->getUserByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/get/UID/abc123', $request->getUri()->getPath());
    }

    public function test_get_user_by_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['id' => 42]]);

        $this->client->user->getUserById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/get/id/42', $request->getUri()->getPath());
    }

    public function test_get_login_by_email(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['login_url' => 'https://example.com/login']]);

        $this->client->user->getLoginByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/login-url/email/test@example.com', $request->getUri()->getPath());
    }

    public function test_get_login_by_uid(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['login_url' => 'https://example.com/login']]);

        $this->client->user->getLoginByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/login-url/UID/abc123', $request->getUri()->getPath());
    }

    public function test_get_login_by_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['login_url' => 'https://example.com/login']]);

        $this->client->user->getLoginById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/login-url/id/42', $request->getUri()->getPath());
    }

    public function test_delete_by_email(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->deleteByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/delete/email/test@example.com', $request->getUri()->getPath());
    }

    public function test_delete_by_uid(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->deleteByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/delete/UID/abc123', $request->getUri()->getPath());
    }

    public function test_delete_by_id(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->deleteById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/delete/id/42', $request->getUri()->getPath());
    }

    public function test_restore_by_email(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->restoreByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/restore/email/test@example.com', $request->getUri()->getPath());
    }

    public function test_restore_by_uid(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->restoreByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/restore/UID/abc123', $request->getUri()->getPath());
    }

    public function test_restore_by_id(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->restoreById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/restore/id/42', $request->getUri()->getPath());
    }

    public function test_anonymise_by_email(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->anonymiseByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/anonymise/email/test@example.com', $request->getUri()->getPath());
    }

    public function test_anonymise_by_uid(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->anonymiseByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/anonymise/UID/abc123', $request->getUri()->getPath());
    }

    public function test_anonymise_by_id(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->anonymiseById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/anonymise/id/42', $request->getUri()->getPath());
    }

    public function test_make_known_by_uid(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->makeKnownByUid('abc123', ['first_name' => 'Test']);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/make-known/UID/abc123', $request->getUri()->getPath());
        $this->assertEquals(['first_name' => 'Test'], json_decode($request->getBody()->getContents(), true));
    }

    public function test_make_known_by_id(): void
    {
        $this->mockResponse(['success' => true]);

        $this->client->user->makeKnownById(42, ['first_name' => 'Test']);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/make-known/id/42', $request->getUri()->getPath());
        $this->assertEquals(['first_name' => 'Test'], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_users(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1], ['id' => 2]]]);

        $result = $this->client->user->list();

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/list', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
        $this->assertTrue($result->success);
        $this->assertCount(2, $result->data);
    }

    public function test_list_users_with_filters(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1]]]);

        $this->client->user->list(['updated_from' => '2024-01-01', 'per_page' => 10]);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/list', $request->getUri()->getPath());
        $this->assertEquals(['updated_from' => '2024-01-01', 'per_page' => 10], json_decode($request->getBody()->getContents(), true));
    }

    public function test_get_redemption_stats_by_email(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['total_redemptions' => 5]]);

        $result = $this->client->user->getRedemptionStatsByEmail('test@example.com');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/stats/email/test@example.com', $request->getUri()->getPath());
        $this->assertTrue($result->success);
        $this->assertEquals(5, $result->data->total_redemptions);
    }

    public function test_get_redemption_stats_by_uid(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['total_redemptions' => 3]]);

        $this->client->user->getRedemptionStatsByUid('abc123');

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/stats/UID/abc123', $request->getUri()->getPath());
    }

    public function test_get_redemption_stats_by_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['total_redemptions' => 7]]);

        $this->client->user->getRedemptionStatsById(42);

        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/user/stats/id/42', $request->getUri()->getPath());
    }
}
