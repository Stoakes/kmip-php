<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Enum\ObjectType;
use Stoakes\Kmip\Protocol\Attributes;
use Stoakes\Kmip\Protocol\TemplateAttribute;

class RequestPayload
{
    public ObjectType $objectType;

    public ?TemplateAttribute $templateAttribute;

    public ?Attributes $attributes;

    // KMIP 2

    public function __construct(
        ObjectType $objectType,
        TemplateAttribute $kmip1TemplateAttribute = null,
        Attributes $kmip2Attributes = null
    ) {
        if ($kmip1TemplateAttribute && $kmip2Attributes) {
            throw new \LogicException('attributes & template attributes are exclusive');
        }
        $this->objectType = $objectType;
        $this->templateAttribute = $kmip1TemplateAttribute;
        $this->attributes = $kmip2Attributes;
    }
}
