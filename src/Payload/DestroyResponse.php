<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;

class DestroyResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public string $uniqueIdentifier;
}
