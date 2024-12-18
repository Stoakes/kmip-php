<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum NameType: int
{
    /** 0x00000001 */
    case UninterpretedTextString = 1;

    /** 0x00000002 */
    case URI = 2;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::UninterpretedTextString => 'Uninterpreted Text String',
            self::URI => 'URI',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
