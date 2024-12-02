<?php

namespace Stoakes\Kmip\Protocol;

// TemplateAttribute 2.1.8 Table 29
//
// The Template Managed Object is deprecated as of version 1.3 of this specification and MAY be removed from
// subsequent versions of the specification. Individual Attributes SHOULD be used in operations which currently
// support use of a Name within a Template-Attribute to reference a Template.
//
// These structures are used in various operations to provide the desired attribute values and/or template
// names in the request and to return the actual attribute values in the response.
//
// The Template-Attribute, Common Template-Attribute, Private Key Template-Attribute, and Public Key
// Template-Attribute structures are defined identically as follows:
// type TemplateAttribute struct {
//	Attribute []Attribute
// }
// TemplateAttribute MUST include CryptographicAlgorithm (3.4) and CryptographicUsageMask (3.19).
class TemplateAttribute implements ReceivedStructureInterface
{
    use SetTrait;

    public array $name;

    /**
     * @var Attribute[]
     */
    public array $attribute;

    /**
     * @param array       $name
     * @param Attribute[] $attribute
     */
    public function __construct(array $name = [], array $attribute = [])
    {
        $this->name = $name;
        $this->attribute = $attribute;
    }
}
