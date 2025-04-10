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

## Usage

```php
$client = new PropelloCloud(bearerToken: $bearerToken);

$newUser = $client->user->create(['email' => 'example.user@example.org'])
```

## Credits

- [Richard Porter](https://github.com/rpwebdevelopment)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
