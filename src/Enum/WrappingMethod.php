<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum WrappingMethod: int
{
    /** 0x00000001 */
    case Encrypt = 1;

    /** 0x00000002 */
    case MACsign = 2;

    /** 0x00000003 */
    case EncryptThenMACsign = 3;

    /** 0x00000004 */
    case MACsignThenEncrypt = 4;

    /** 0x00000005 */
    case TR31 = 5;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Encrypt => 'Encrypt',
            self::MACsign => 'MAC/sign',
            self::EncryptThenMACsign => 'Encrypt then MAC/sign',
            self::MACsignThenEncrypt => 'MAC/sign then encrypt',
            self::TR31 => 'TR-31',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}