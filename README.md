# Propello Cloud PHP SDK - API V3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/propellocloud/propello-php-sdk.svg?style=flat-square)](https://packagist.org/packages/propellocloud/propello-php-sdk)

This package is intended to allow clients to integrate with the Propello Cloud API with minimal intervention.

## Requirements

- PHP: 8.3+

## Installation

You can install the package via composer:

```bash
composer require propellocloud/propello-php-sdk
```

Currently, all of Propello Clouds V3 User endpoints have been implemented in this SDK. This functionality will
be expanded as the API is further developed, as such you should aim to make use of the latest version at all times.

## Authentication

In order to connect to the API you will first need to authenticate your instance with either a `Bearer Token`
or a `Client Secret` and `Client ID`.

```php
use PropelloCloud\Client;
// with Bearer Token
$client = new Client(bearerToken: $bearerToken);

// with client secret & ID 
$client = new Client(clientId: $clientId, clientSecret: $clientSecret);
```

##### NOTE: It is highly recommended that you implement the bearer token method as this requires fewer calls to the API and is far less data intensive.

##### Bearer tokens are valid for 1 year and can be obtained as follows:

```php
use PropelloCloud\Client;

$client = new Client(clientId: $clientId, clientSecret: $clientSecret);

$bearerToken = $client->getBearerToken();
```

## Security
Propello cloud does not bear any liability or responsibility for the security of your API credentials; as such 
it is vital that you take all possible steps to prevent unauthorised access.

## Usage

The below are all currently available methods:

```php
use PropelloCloud\Client;
$client = new Client(bearerToken: $bearerToken);

// Creates a user
$client->user->create(array $user);

// Create multiple users (max 100)
$client->user->createBulk(array $users, bool $sendEmails)

// Creates a user and returns user one-time login URL
$client->user->createUserWithLogin(array $user); 

// Returns a users details
$client->user->getUserByEmail(string $email);
$client->user->getUserByUid(string $uniqueId);
$client->user->getUserById(int $id);

// Returns a user one-time login URL
$client->user->getLoginByEmail(string $email);
$client->user->getLoginByUid(string $uniqueId);
$client->user->getLoginById(int $id);

// Deletes a user
$client->user->deleteByEmail(string $email);
$client->user->deleteByUid(string $uniqueId);
$client->user->deleteById(int $id);

// Restores a deleted user
$client->user->restoreByEmail(string $email);
$client->user->restoreByUid(string $uniqueId);
$client->user->restoreById(int $id);

// Anonymises a users details
$client->user->anonymiseByEmail(string $email);
$client->user->anonymiseByUid(string $uniqueId);
$client->user->anonymiseById(int $id);

// Restore anonymised user account with details
$client->user->makeKnownByUid(string $uniqueId, array $userDetails);
$client->user->makeKnownById(int $id, array $userDetails);
```

## Credits

- [Richard Porter](https://github.com/rpwebdevelopment)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
