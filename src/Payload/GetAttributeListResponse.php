<?php

namespace Stoakes\Kmip\Payload;

class GetAttributeListResponse
{
    public string $uniqueIdentifier;
    /** @var string[] */
    public array $attributeNames = [];
}
