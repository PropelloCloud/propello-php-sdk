<?php

declare(strict_types=1);

namespace PropelloCloud;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use PropelloCloud\Abstracts\ClientAbstract;
use stdClass;
use Throwable;
use TypeError;

class Client
{
    private const string BASE_URL = 'https://api.yourperx.com/v3/';

    private AuthClient $auth;

    private HttpClient $http;

    public UserClient $user;

    public function __construct(
        public ?int $clientId = null,
        public ?string $clientSecret = null,
        public ?string $bearerToken = null,
    ) {
        $this->http = new HttpClient([
            'base_uri' => self::BASE_URL,
            RequestOptions::SYNCHRONOUS => true,
            RequestOptions::ALLOW_REDIRECTS => false,
            RequestOptions::TIMEOUT => 2,
            RequestOptions::VERIFY => false,
        ]);

        $this->auth = new AuthClient($this);
        $this->user = new UserClient($this);
    }

    public static function configure(
        ?int $clientId = null,
        ?string $clientSecret = null,
        ?string $bearerToken = null,
    ): self {
        return new self($clientId, $clientSecret, $bearerToken);
    }

    /**
     * @throws Throwable
     */
    public function call(ClientAbstract $client): stdClass
    {
        $this->auth->setHeaders($client);

        try {
            return $this->post($client);
        } catch (TypeError $e) {
            throw new Exception('Invalid response received');
        }
    }

    /**
     * @throws Throwable
     */
    public function post(ClientAbstract $client): stdClass
    {
        try {
            $response = $this->http->post(
                $client->url,
                [
                    'headers' => $client->headers,
                    'json' => $client->body,
                ]
            );

            return json_decode($response->getBody()->getContents());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getBearerToken(): ?string
    {
        return $this->auth->getBearerToken();
    }
}
