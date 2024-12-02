<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Enum\ObjectType;
use Stoakes\Kmip\Protocol\PrivateKey;
use Stoakes\Kmip\Protocol\PublicKey;
use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;
use Stoakes\Kmip\Protocol\SymmetricKey;

class GetResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public ObjectType $objectType;
    public string $uniqueIdentifier;
    public ?SymmetricKey $symmetricKey = null;
    public ?PrivateKey $privateKey = null;
    public ?PublicKey $publicKey = null;
}
