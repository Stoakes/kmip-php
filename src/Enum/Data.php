<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum Data: int
{
    /** 0x00000001 */
    case Decrypt = 1;

    /** 0x00000002 */
    case Encrypt = 2;

    /** 0x00000003 */
    case Hash = 3;

    /** 0x00000004 */
    case MACMACData = 4;

    /** 0x00000005 */
    case RNGRetrieve = 5;

    /** 0x00000006 */
    case SignSignatureData = 6;

    /** 0x00000007 */
    case SignatureVerify = 7;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Decrypt => 'Decrypt',
            self::Encrypt => 'Encrypt',
            self::Hash => 'Hash',
            self::MACMACData => 'MAC MAC Data',
            self::RNGRetrieve => 'RNG Retrieve',
            self::SignSignatureData => 'Sign Signature Data',
            self::SignatureVerify => 'Signature Verify',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
