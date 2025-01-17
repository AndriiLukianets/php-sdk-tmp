# Upmind - SDK - PHP

## Requirements

- PHP 7.4
- Composer
- [Upmind Starter](https://upmind.com/pricing) plan or higher

## Usage

### Getting Started

To use the SDK you will need to first create an API token in your Upmind admin area settings. You should also make note of your brand ID.

First you will need to create a `Config` instance with your API token and brand ID. Then, use that to create an instance of the `Api` client. Set the `debug` option to `true` to stream API requests and responses to STDERR; alternatively you can pass an alternative PSR-3 compliant logger when instantiating the API.

You can then get an instance of a service to start making API requests.

```php
use Upmind\Sdk\Api;
use Upmind\Sdk\Config;

$config = new Config(
    token: 'your-api-token',
    brandId: 'your-brand-id',
    withoutNotifications: true, // don't trigger notifications for create/update/delete requests
    debug: true, // stream api requests + responses to STDERR by default
);
$api = new Api($config);
$service = $api->clientService();

$clientId = '467029e9-d574-1484-680f-e10683283ed5';
$response = $service->getClient($clientId);
if ($response->isSuccessful()) {
    $clientData = $response->getResponseData();
    // ...
} else {
    $error = $response->getResponseError();
    // ...
}
```

### Pagination

Most list requests will return paginated results. The SDK will allow you to pass a `QueryParams` object to control pagination by setting `limit` (default 10) and `offset` (default 0) query parameters.

```php
use Upmind\Sdk\Data\QueryParams;

$queryParams = QueryParams::new()
    ->setLimit(20) // returns up to 20 results
    ->setOffset(100); // skips the first 100 results
$response = $api->clientService()->listClients($queryParams);
```

### Relations

Some resources have relationships with other resources. You can specify relationships to load by setting the `with` query parameter when making GET requests. This reduces the number of API requests needed to fetch related resources.

```php
use Upmind\Sdk\Data\QueryParams;

$clientId = '467029e9-d574-1484-680f-e10683283ed5';
$queryParams = QueryParams::new()
    ->setWith(['emails', 'addresses']); // load the client's emails and addresses
$response = $api->clientService()->getClient($clientId, $queryParams);
if ($response->isSuccessful()) {
    $clientData = $response->getResponseData();
    foreach ($clientData['emails'] as $emailData) {
        // ...
    }
}
```

### Creating Resources

Create methods are typed with DTOs containing setter methods to help you identify which parameters are available. When a resource is created successfully, an `id` will be returned which can be used to fetch and manage the resource later.

```php
use Upmind\Sdk\Data\CreateEmailParams;

$clientId = '467029e9-d574-1484-680f-e10683283ed5';
$createEmail = CreateEmailParams::new()
    ->setEmail('harry@upmind.com')
    ->setDefault(true);
$response = $api->emailService()->createEmail($clientId, $createEmail);
if ($response->isSuccessful()) {
    $emailId = $response->getResponseData()['id'];
    // ...
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

 - [Harry Lewis](https://github.com/uphlewis)
 - [All Contributors](../../contributors)

## License

GNU General Public License version 3 (GPLv3). Please see [License File](LICENSE.md) for more information.

## Upmind

Sell, manage and support web hosting, domain names, ssl certificates, website builders and more with [Upmind.com](https://upmind.com/start).
