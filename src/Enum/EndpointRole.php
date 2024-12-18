<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum EndpointRole: int
{
    /** 0x00000001 */
    case Client = 1;

    /** 0x00000002 */
    case Server = 2;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Client => 'Client',
            self::Server => 'Server',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
