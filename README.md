# KMIP-PHP

_The first KMIP client library for PHP_

## Usage

Install the package:

```bash
composer require stoakes/kmip-php
```

Use it:

```php
<?php

use Stoakes\Kmip\BaseClient;
use Stoakes\Kmip\Enum\CryptographicAlgorithm;
use Stoakes\Kmip\Enum\RevocationReasonCode;

require __DIR__ . '/vendor/autoload.php';

$client = new BaseClient('localhost', 5696,
    './server.crt',
    './server.key',
    './ca.crt',
    '2.0'
);

$client->connect();

$response = $client->createSymmetricKey(CryptographicAlgorithm::AES, 256);

$keyId = $response->batchItem[0]->responsePayload->uniqueIdentifier;

$response = $client->activate($keyId);

$response = $client->get($keyId);

$response = $client->revoke($keyId, RevocationReasonCode::CessationOfOperation);

$response = $client->destroy($keyId);

$client->disconnect();
```
