<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum SecretDataType: int
{
    /** 0x00000001 */
    case Password = 1;

    /** 0x00000002 */
    case Seed = 2;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Password => 'Password',
            self::Seed => 'Seed',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
