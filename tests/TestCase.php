<?php

declare(strict_types=1);

namespace PropelloCloud\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;
use PropelloCloud\Client;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{
    protected Client $client;

    protected MockHandler $mock;

    protected function setUp(): void
    {
        $this->mock = new MockHandler();
        $handlerStack = HandlerStack::create($this->mock);
        $httpClient = new HttpClient([
            'handler' => $handlerStack,
            'base_uri' => 'https://api.yourperx.com/v3/',
        ]);

        $this->client = new Client(bearerToken: 'test-token');

        // Inject the mock HTTP client
        $reflection = new ReflectionClass($this->client);
        $httpProp = $reflection->getProperty('http');
        $httpProp->setAccessible(true);
        $httpProp->setValue($this->client, $httpClient);
    }

    protected function mockResponse(array $data, int $status = 200): void
    {
        $this->mock->append(
            new Response($status, ['Content-Type' => 'application/json'], json_encode($data))
        );
    }
}
