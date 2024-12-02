<?php

/**
 * DO NOT EDIT. This file is auto-generated by stoakes/kmip-php code generator
 */

declare(strict_types=1);

namespace Stoakes\Kmip\Enum;

enum ObjectGroupMember: int
{
    /** 0x00000001 */
    case GroupMemberFresh = 1;

    /** 0x00000002 */
    case GroupMemberDefault = 2;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::GroupMemberFresh => 'Group Member Fresh',
            self::GroupMemberDefault => 'Group Member Default',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}