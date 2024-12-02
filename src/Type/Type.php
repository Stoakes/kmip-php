<?php

namespace Stoakes\Kmip\Type;

// Type is a byte containing a coded value that indicates the data type of the data object
enum Type: int
{
    case Structure = 0x01;
    case Integer = 0x02;
    case Long_Integer = 0x03;
    case Big_Integer = 0x04;
    case Enumeration = 0x05;
    case Boolean = 0x06;
    case Text_String = 0x07;
    case Byte_String = 0x08;
    case Date_Time = 0x09;
    case Interval = 0x0A;

    public function valueToCanonicalName(self $value): string
    {
        return match($value) {
            self::Structure => 'Structure',
            self::Integer => 'Integer',
            self::Long_Integer => 'Long Integer',
            self::Big_Integer => 'Big Integer',
            self::Enumeration => 'Enumeration',
            self::Boolean => 'Boolean',
            self::Text_String => 'Text String',
            self::Byte_String => 'Byte String',
            self::Date_Time => 'Date Time',
            self::Interval => 'Interval',
        };
    }

    public function canonicalName(): string
    {
        return self::valueToCanonicalName($this);
    }
}
