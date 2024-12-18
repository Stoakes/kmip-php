<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum CertificateRequestType: int
{
    /** 0x00000001 */
    case CRMF = 1;

    /** 0x00000002 */
    case PKCS_10 = 2;

    /** 0x00000003 */
    case PEM = 3;

    /** 0x00000004 */
    case PGP = 4;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::CRMF => 'CRMF',
            self::PKCS_10 => 'PKCS#10',
            self::PEM => 'PEM',
            self::PGP => 'PGP',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
