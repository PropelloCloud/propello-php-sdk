<?php

declare(strict_types=1);

namespace PropelloCloud\Tests;

class GroupClientTest extends TestCase
{
    public function test_get_group(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['id' => 1, 'name' => 'Test Group']]);
        $this->client->group->get();
        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/group', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
    }

    public function test_get_group_with_organisation_group_id(): void
    {
        $this->mockResponse(['success' => true, 'data' => ['id' => 5, 'name' => 'Specific Group']]);
        $this->client->group->get(5);
        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/group', $request->getUri()->getPath());
        $this->assertEquals(['organisation_group_id' => 5], json_decode($request->getBody()->getContents(), true));
    }

    public function test_list_groups(): void
    {
        $this->mockResponse(['success' => true, 'data' => [['id' => 1], ['id' => 2]]]);
        $result = $this->client->group->list();
        $request = $this->mock->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v3/group/list', $request->getUri()->getPath());
        $this->assertEquals([], json_decode($request->getBody()->getContents(), true));
        $this->assertTrue($result->success);
        $this->assertCount(2, $result->data);
    }
}
