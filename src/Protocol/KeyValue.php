<?php

namespace Stoakes\Kmip\Protocol;

class KeyValue implements ReceivedStructureInterface
{
    use SetTrait;

    /**
     * @var mixed
     */
    public $keyMaterial;

    /**
     * @var Attribute[]
     */
    public $attribute;

    public static function new($keyMaterial, $attribute = [])
    {
        $res = new self();
        $res->keyMaterial = $keyMaterial;
        $res->attribute = $attribute;

        return $res;
    }
}
