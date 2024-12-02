<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Tag\Tag;

class Attribute implements ReceivedStructureInterface
{
    use SetTrait;

    public string $attributeName;

    public ?int $attributeIndex = null;

    public mixed $attributeValue;

    public function __construct($attributeName, $attributeValue, $attributeIndex = null)
    {
        $this->attributeName = $attributeName;
        $this->attributeIndex = $attributeIndex;
        $this->attributeValue = $attributeValue;
    }

    public static function fromTag(Tag $tag, $value, int $index = 0): Attribute
    {
        return new Attribute($tag->canonicalName(), $index, $value);
    }
}
