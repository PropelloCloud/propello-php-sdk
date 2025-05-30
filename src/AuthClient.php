<?php

declare(strict_types=1);

namespace PropelloCloud;

use Exception;
use PropelloCloud\Abstracts\ClientAbstract;
use Throwable;

class AuthClient extends ClientAbstract
{
    /**
     * @throws Throwable
     */
    public function setHeaders(ClientAbstract &$client): void
    {
        $token = $this->getBearerToken();

        $client->headers = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ];
    }

    /**
     * @throws Throwable
     */
    public function getBearerToken(): string
    {
        if ($this->client->bearerToken) {
            return $this->client->bearerToken;
        }

        if (! $this->client->clientId || ! $this->client->clientSecret) {
            throw new Exception('Missing API credentials', 401);
        }

        $this->url = 'oauth/token';
        $this->body = [
            'client_id' => $this->client->clientId,
            'client_secret' => $this->client->clientSecret,
            'grant_type' => 'client_credentials',
            'scope' => '*',
        ];

        $response = $this->client->post($this);
        if (! isset($response->access_token)) {
            throw new Exception('Failed to get bearer token', 500);
        }

        $this->client->bearerToken = $response->access_token;

        return $this->client->bearerToken;
    }
}
