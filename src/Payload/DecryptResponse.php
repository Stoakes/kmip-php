<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;

class DecryptResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public string $uniqueIdentifier;
    public ?string $data = null;
    public ?string $correlationValue = null;
}
