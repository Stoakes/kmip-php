<?php

namespace Stoakes\Kmip\Protocol;

use ReflectionProperty;
use Stoakes\Kmip\Decoder;
use Stoakes\Kmip\Tag\Tag;

/**
 * A quick way to implement SetInterface when there's no polymorphism in any of the parameters of the class.
 */
trait SetTrait
{
    public function set(Tag $tag, $value)
    {
        $propertyName = lcfirst($tag->name);
        if (!property_exists($this, $propertyName)) {
            throw new \LogicException("Cannot assign $tag->name in a ".get_class($this));
        }
        if ($value instanceof Decoder) { // dealing with a KMIP structure => unmarshall
            $this->$propertyName = $value->unmarshallInner('Stoakes\Kmip\Protocol\\'.$tag->name);
        } else { // basic KMIP type => direct assignation

            // deal with enum
            $reflectionProperty = new ReflectionProperty($this, $propertyName);
            $reflectionType = $reflectionProperty->getType();
            if ($reflectionType && enum_exists($reflectionType->getName())) {
                /** @var \BackedEnum $typeName */
                $typeName = $reflectionProperty->getType()->getName();
                $this->$propertyName = $typeName::from($value);

                return;
            }

            $this->$propertyName = $value;
        }
    }
}
