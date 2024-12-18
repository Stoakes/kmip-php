<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum RNGMode: int
{
    /** 0x00000001 */
    case Unspecified = 1;

    /** 0x00000002 */
    case SharedInstantiation = 2;

    /** 0x00000003 */
    case NonSharedInstantiation = 3;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Unspecified => 'Unspecified',
            self::SharedInstantiation => 'Shared Instantiation',
            self::NonSharedInstantiation => 'Non-Shared Instantiation',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
