<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Enum\ObjectType;
use Stoakes\Kmip\Protocol\ReceivedStructureInterface;
use Stoakes\Kmip\Protocol\SetTrait;
use Stoakes\Kmip\Protocol\TemplateAttribute;

class CreateResponse implements ReceivedStructureInterface
{
    use SetTrait;

    public ObjectType $objectType;
    public string $uniqueIdentifier;
    public ?TemplateAttribute $templateAttribute = null;
}
