<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum KeyRoleType: int
{
    /** 0x00000001 */
    case BDK = 1;

    /** 0x00000002 */
    case CVK = 2;

    /** 0x00000003 */
    case DEK = 3;

    /** 0x00000004 */
    case MKAC = 4;

    /** 0x00000005 */
    case MKSMC = 5;

    /** 0x00000006 */
    case MKSMI = 6;

    /** 0x00000007 */
    case MKDAC = 7;

    /** 0x00000008 */
    case MKDN = 8;

    /** 0x00000009 */
    case MKCP = 9;

    /** 0x0000000A */
    case MKOTH = 10;

    /** 0x0000000B */
    case KEK = 11;

    /** 0x0000000C */
    case MAC16609 = 12;

    /** 0x0000000D */
    case MAC97971 = 13;

    /** 0x0000000E */
    case MAC97972 = 14;

    /** 0x0000000F */
    case MAC97973 = 15;

    /** 0x00000010 */
    case MAC97974 = 16;

    /** 0x00000011 */
    case MAC97975 = 17;

    /** 0x00000012 */
    case ZPK = 18;

    /** 0x00000013 */
    case PVKIBM = 19;

    /** 0x00000014 */
    case PVKPVV = 20;

    /** 0x00000015 */
    case PVKOTH = 21;

    /** 0x00000016 */
    case DUKPT = 22;

    /** 0x00000017 */
    case IV = 23;

    /** 0x00000018 */
    case TRKBK = 24;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::BDK => 'BDK',
            self::CVK => 'CVK',
            self::DEK => 'DEK',
            self::MKAC => 'MKAC',
            self::MKSMC => 'MKSMC',
            self::MKSMI => 'MKSMI',
            self::MKDAC => 'MKDAC',
            self::MKDN => 'MKDN',
            self::MKCP => 'MKCP',
            self::MKOTH => 'MKOTH',
            self::KEK => 'KEK',
            self::MAC16609 => 'MAC16609',
            self::MAC97971 => 'MAC97971',
            self::MAC97972 => 'MAC97972',
            self::MAC97973 => 'MAC97973',
            self::MAC97974 => 'MAC97974',
            self::MAC97975 => 'MAC97975',
            self::ZPK => 'ZPK',
            self::PVKIBM => 'PVKIBM',
            self::PVKPVV => 'PVKPVV',
            self::PVKOTH => 'PVKOTH',
            self::DUKPT => 'DUKPT',
            self::IV => 'IV',
            self::TRKBK => 'TRKBK',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
