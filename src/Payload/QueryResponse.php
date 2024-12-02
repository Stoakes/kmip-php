<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Enum\ObjectType;
use Stoakes\Kmip\Enum\Operation;

class QueryResponse
{
    /** @var Operation[] */
    public array $operations = [];
    /** @var ObjectType[] */
    public array $objectTypes = [];
    public ?string $vendorIdentification = null;
}
