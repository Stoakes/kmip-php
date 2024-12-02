<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum AlternativeNameType: int
{
    /** 0x00000001 */
    case UninterpretedTextString = 1;

    /** 0x00000002 */
    case URI = 2;

    /** 0x00000003 */
    case ObjectSerialNumber = 3;

    /** 0x00000004 */
    case EmailAddress = 4;

    /** 0x00000005 */
    case DNSName = 5;

    /** 0x00000006 */
    case X_500DistinguishedName = 6;

    /** 0x00000007 */
    case IPAddress = 7;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::UninterpretedTextString => 'Uninterpreted Text String',
            self::URI => 'URI',
            self::ObjectSerialNumber => 'Object Serial Number',
            self::EmailAddress => 'Email Address',
            self::DNSName => 'DNS Name',
            self::X_500DistinguishedName => 'X.500 Distinguished Name',
            self::IPAddress => 'IP Address',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
