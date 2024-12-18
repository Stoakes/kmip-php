<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Mask;

enum StorageStatusMask: int
{
    /** 0x00000001 */
    case OnlineStorage = 1;

    /** 0x00000002 */
    case ArchivalStorage = 2;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::OnlineStorage => 'On-line storage',
            self::ArchivalStorage => 'Archival storage',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
