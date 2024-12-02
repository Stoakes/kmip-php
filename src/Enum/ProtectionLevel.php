<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum ProtectionLevel: int
{
    /** 0x00000001 */
    case High = 1;

    /** 0x00000002 */
    case Low = 2;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::High => 'High',
            self::Low => 'Low',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
