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
        public int|null $clientId = null,
        public string|null $clientSecret = null,
        public string|null $bearerToken = null,
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
        int|null $clientId = null,
        string|null $clientSecret = null,
        string|null $bearerToken = null,
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
}
