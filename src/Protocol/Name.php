<?php

namespace Stoakes\Kmip\Protocol;

// Name 3.2 Table 57
//
// The Name attribute is a structure (see Table 57) used to identify and locate an object.
// This attribute is assigned by the client, and the Name Value is intended to be in a form that
// humans are able to interpret. The key management system MAY specify rules by which the client
// creates valid names. Clients are informed of such rules by a mechanism that is not specified by
// this standard. Names SHALL be unique within a given key management domain,
// but are NOT REQUIRED to be globally unique.
use Stoakes\Kmip\Enum\NameType;

class Name implements ReceivedStructureInterface
{
    use SetTrait;
    public string $nameValue;
    public NameType $nameType;

    /**
     * @param string   $nameValue
     * @param NameType $nameType
     */
    public function __construct(string $nameValue, NameType $nameType)
    {
        $this->nameValue = $nameValue;
        $this->nameType = $nameType;
    }


}
