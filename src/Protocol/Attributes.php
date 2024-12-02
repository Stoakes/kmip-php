<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Tag\Tag;

class Attributes implements ReceivedStructureInterface
{
    /**
     * @var Attribute[]
     */
    public array $attributes;

    /**
     * @param Attribute[] $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }


    public function set(Tag $tag, $value)
    {
        if ($tag !== Tag::Attribute) {
            throw new \LogicException("Cannot assign $tag->name in a Attributes");
        }

        $this->attributes[] = $value;
    }
}
