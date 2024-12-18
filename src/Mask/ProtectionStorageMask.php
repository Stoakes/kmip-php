<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Mask;

enum ProtectionStorageMask: int
{
    /** 0x00000001 */
    case Software = 1;

    /** 0x00000002 */
    case Hardware = 2;

    /** 0x00000004 */
    case OnProcessor = 4;

    /** 0x00000008 */
    case OnSystem = 8;

    /** 0x00000010 */
    case OffSystem = 16;

    /** 0x00000020 */
    case Hypervisor = 32;

    /** 0x00000040 */
    case OperatingSystem = 64;

    /** 0x00000080 */
    case Container = 128;

    /** 0x00000100 */
    case OnPremises = 256;

    /** 0x00000200 */
    case OffPremises = 512;

    /** 0x00000400 */
    case SelfManaged = 1024;

    /** 0x00000800 */
    case Outsourced = 2048;

    /** 0x00001000 */
    case Validated = 4096;

    /** 0x00002000 */
    case SameJurisdiction = 8192;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Software => 'Software',
            self::Hardware => 'Hardware',
            self::OnProcessor => 'On Processor',
            self::OnSystem => 'On System',
            self::OffSystem => 'Off System',
            self::Hypervisor => 'Hypervisor',
            self::OperatingSystem => 'Operating System',
            self::Container => 'Container',
            self::OnPremises => 'On Premises',
            self::OffPremises => 'Off Premises',
            self::SelfManaged => 'Self Managed',
            self::Outsourced => 'Outsourced',
            self::Validated => 'Validated',
            self::SameJurisdiction => 'Same Jurisdiction',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
