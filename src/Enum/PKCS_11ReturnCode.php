<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum PKCS_11ReturnCode: int
{
    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            default => '',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
