<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;

class RevokeResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public string $uniqueIdentifier;
}
