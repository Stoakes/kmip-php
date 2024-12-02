<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\ObjectType;

class ResponsePayload implements ReceivedStructureInterface
{
    use SetTrait;

    public ObjectType $objectType;
    public string $uniqueIdentifier;

    public ?TemplateAttribute $templateAttribute;
}
