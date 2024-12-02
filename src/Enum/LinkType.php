<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum LinkType: int
{
    /** 0x00000101 */
    case CertificateLink = 257;

    /** 0x00000102 */
    case PublicKeyLink = 258;

    /** 0x00000103 */
    case PrivateKeyLink = 259;

    /** 0x00000104 */
    case DerivationBaseObjectLink = 260;

    /** 0x00000105 */
    case DerivedKeyLink = 261;

    /** 0x00000106 */
    case ReplacementObjectLink = 262;

    /** 0x00000107 */
    case ReplacedObjectLink = 263;

    /** 0x00000108 */
    case ParentLink = 264;

    /** 0x00000109 */
    case ChildLink = 265;

    /** 0x0000010A */
    case PreviousLink = 266;

    /** 0x0000010B */
    case NextLink = 267;

    /** 0x0000010C */
    case PKCS_12CertificateLink = 268;

    /** 0x0000010D */
    case PKCS_12PasswordLink = 269;

    /** 0x0000010E */
    case WrappingKeyLink = 270;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::CertificateLink => 'Certificate Link',
            self::PublicKeyLink => 'Public Key Link',
            self::PrivateKeyLink => 'Private Key Link',
            self::DerivationBaseObjectLink => 'Derivation Base Object Link',
            self::DerivedKeyLink => 'Derived Key Link',
            self::ReplacementObjectLink => 'Replacement Object Link',
            self::ReplacedObjectLink => 'Replaced Object Link',
            self::ParentLink => 'Parent Link',
            self::ChildLink => 'Child Link',
            self::PreviousLink => 'Previous Link',
            self::NextLink => 'Next Link',
            self::PKCS_12CertificateLink => 'PKCS#12 Certificate Link',
            self::PKCS_12PasswordLink => 'PKCS#12 Password Link',
            self::WrappingKeyLink => 'Wrapping Key Link',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
