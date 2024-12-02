<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;
use Stoakes\Kmip\Protocol\TemplateAttribute;

class CreateKeyPairResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public string $privateKeyUniqueIdentifier;
    public string $publicKeyUniqueIdentifier;
    public ?TemplateAttribute $privateKeyTemplateAttribute = null;
    public ?TemplateAttribute $publicKeyTemplateAttribute = null;
}
