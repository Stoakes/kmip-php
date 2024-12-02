<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;

class SignResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public string $uniqueIdentifier;
    public ?string $signatureData = null;
    public ?string $correlationValue = null;
}
