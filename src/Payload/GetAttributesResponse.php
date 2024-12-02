<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\Attributes;
use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;

class GetAttributesResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public string $uniqueIdentifier;
    public Attributes $attributes;
}
