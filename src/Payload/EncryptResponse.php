<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;

class EncryptResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public string $uniqueIdentifier;
    public ?string $data = null;
    public ?string $ivCounterNonce = null;
    public ?string $correlationValue = null;
    public ?string $authTag = null;
}
