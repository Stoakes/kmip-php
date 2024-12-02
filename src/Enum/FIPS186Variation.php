<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum FIPS186Variation: int
{
    /** 0x00000001 */
    case Unspecified = 1;

    /** 0x00000002 */
    case GPXOriginal = 2;

    /** 0x00000003 */
    case GPXChangeNotice = 3;

    /** 0x00000004 */
    case XOriginal = 4;

    /** 0x00000005 */
    case XChangeNotice = 5;

    /** 0x00000006 */
    case KOriginal = 6;

    /** 0x00000007 */
    case KChangeNotice = 7;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Unspecified => 'Unspecified',
            self::GPXOriginal => 'GP x-Original',
            self::GPXChangeNotice => 'GP x-Change Notice',
            self::XOriginal => 'x-Original',
            self::XChangeNotice => 'x-Change Notice',
            self::KOriginal => 'k-Original',
            self::KChangeNotice => 'k-Change Notice',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
