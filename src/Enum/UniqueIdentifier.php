<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum UniqueIdentifier: int
{
    /** 0x00000001 */
    case IDPlaceholder = 1;

    /** 0x00000002 */
    case Certify = 2;

    /** 0x00000003 */
    case Create = 3;

    /** 0x00000004 */
    case CreateKeyPair = 4;

    /** 0x00000005 */
    case CreateKeyPairPrivateKey = 5;

    /** 0x00000006 */
    case CreateKeyPairPublicKey = 6;

    /** 0x00000007 */
    case CreateSplitKey = 7;

    /** 0x00000008 */
    case DeriveKey = 8;

    /** 0x00000009 */
    case Import = 9;

    /** 0x0000000A */
    case JoinSplitKey = 10;

    /** 0x0000000B */
    case Locate = 11;

    /** 0x0000000C */
    case Register = 12;

    /** 0x0000000D */
    case Rekey = 13;

    /** 0x0000000E */
    case Recertify = 14;

    /** 0x0000000F */
    case RekeyKeyPair = 15;

    /** 0x00000010 */
    case RekeyKeyPairPrivateKey = 16;

    /** 0x00000011 */
    case RekeyKeyPairPublicKey = 17;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::IDPlaceholder => 'ID Placeholder',
            self::Certify => 'Certify',
            self::Create => 'Create',
            self::CreateKeyPair => 'Create Key Pair',
            self::CreateKeyPairPrivateKey => 'Create Key Pair Private Key',
            self::CreateKeyPairPublicKey => 'Create Key Pair Public Key',
            self::CreateSplitKey => 'Create Split Key',
            self::DeriveKey => 'Derive Key',
            self::Import => 'Import',
            self::JoinSplitKey => 'Join Split Key',
            self::Locate => 'Locate',
            self::Register => 'Register',
            self::Rekey => 'Re-key',
            self::Recertify => 'Re-certify',
            self::RekeyKeyPair => 'Re-key Key Pair',
            self::RekeyKeyPairPrivateKey => 'Re-key Key Pair Private Key',
            self::RekeyKeyPairPublicKey => 'Re-key Key Pair Public Key',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}