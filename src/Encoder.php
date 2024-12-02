<?php

namespace Stoakes\Kmip;

use Stoakes\Kmip\Type\Type;
use Stoakes\Kmip\Tag\Tag;

/**
 * Encoder encodes a data structure into KMIP TTLV bytes
 * Usage:
 *  $encoder = new Encoder()
 *  $encodedResult = $encoder->encode([...]);
 *  // $encodedResult is now ready to be sent on the wire to a KMIP server
 *
 * Use one new encoder for each new message.
 */
class Encoder
{
    private $output = '';

    public function getEncodedData(): string
    {
        return $this->output;
    }

    public function encode($data): string
    {
        if (!$data) {
            return '';
        }
        // temporary encoder to know the size
        $buff = new Encoder();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // if $value is a list, append every of its fields as item of $key
                if (array_is_list($value)) {
                    foreach ($value as $index => $val2) {
                        $buff->encodeValue(Tag::fromName($key), $val2, $this->getTypeForValue($val2));
                    }
                    continue;
                }
                // if $value is a map ([key => value]), append every of its fields as individual field
                foreach ($value as $index => $val2) {
                    $buff->encodeValue(Tag::fromName($index), $val2, $this->getTypeForValue($val2));
                }
                continue;
            }


            $buff->encodeValue(Tag::fromName($key), $value, $this->getTypeForValue($value));
        }

        $reflectionClass = (new \ReflectionClass($data));
        $class = $reflectionClass->getShortName();

        /* Tag doesn't exist. Maybe we're dealing with a class extending a standard Kmip class.
         * Trying again with parent class. If any error, this will raise an exception at the fromName
         * call anyway.
         */
        if (!Tag::hasName($class)) {
            $class = $reflectionClass->getParentClass() ? $reflectionClass->getParentClass()?->getShortName() : $class;
        };
        $res = $buff->getEncodedData();
        $this->writeTagTypeLength(Tag::fromName($class), Type::Structure, strlen($res));
        $this->output .= $res;

        return $this->output;
    }

    private function writeTagTypeLength(Tag $tag, Type $type, $length)
    {
        $tagBytes = pack('N', $tag->value);
        $this->output .= substr($tagBytes, 1, 3);
        $this->output .= pack('C', $type->value);
        $this->output .= pack('N', $length);
    }

    private function writeInteger(Tag $tag, $value)
    {
        $this->writeTagTypeLength($tag, Type::Integer, 4);

        // always write by chunk of 8 bytes => complement to 8 through pack('N',0)
        $this->output .= pack('N', $value).pack('N', 0);
    }


    private function writeLongInteger(Tag $tag, $value)
    {
        $this->writeTagTypeLength($tag, Type::Long_Integer, 8);
        $this->output .= pack('J', $value);
    }

    private function writeEnum(Tag $tag, \BackedEnum $value)
    {
        $this->writeTagTypeLength($tag, Type::Enumeration, 4);

        // always write by chunk of 8 bytes => complement to 8 through pack('N',0)
        $this->output .= pack('N', $value->value).pack('N', 0);
    }

    private function writeBool(Tag $tag, $value)
    {
        $this->writeTagTypeLength($tag, Type::Boolean, 8);
        /**
         * pack('C7x', $value ? 1 : 0) is creating a binary string:
         *
         * 'C' in the format string means "unsigned char" (1 byte)
         * '7x' means "7 null bytes"
         * So 'C7x' together means "1 unsigned char followed by 7 null bytes"
         *
         *
         * $value ? 1 : 0 is a ternary operator that converts the boolean $value to either 1 (true) or 0 (false)
         *
         * This line is specifically encoding a boolean value in the KMIP format. In KMIP, booleans are represented as 8 bytes:
         *
         * The first byte is either 0 (false) or 1 (true)
         * The remaining 7 bytes are always zero (padding)
         *
         * So pack('C7x', $value ? 1 : 0) creates an 8-byte string where:
         *
         * The first byte is 1 if $value is true, 0 if it's false
         * The next 7 bytes are all zero
         *
         * var b [8]byte
         * if v {
         * b[7] = 1
         * }
         * The difference in byte order (first byte in PHP, last byte in Go) is due to how each
         * language typically handles byte order, but the end result is equivalent in the KMIP encoding.
         */
        $this->output .= pack('C*', $value ? 1 : 0, 0, 0, 0, 0, 0, 0, 0);
    }

    private function writeByteSlice(Tag $tag, $type, string $bytes)
    {
        $length = strlen($bytes);
        $this->writeTagTypeLength($tag, $type, $length);
        $this->output .= $bytes;

        if ($length % 8 != 0) {
            $padding = str_repeat("\0", 8 - ($length % 8));
            $this->output .= $padding;
        }
    }

    private function writeBytes(Tag $tag, string $bytes)
    {
        $this->writeByteSlice($tag, Type::Byte_String, $bytes);
    }

    private function writeString(Tag $tag, string $string)
    {
        $this->writeByteSlice($tag, Type::Text_String, $string);
    }

    private function writeTime(Tag $tag, $timestamp)
    {
        $this->writeTagTypeLength($tag, Type::Date_Time, 8);
        $this->output .= pack('J', $timestamp);
    }

    private function writeDuration($tag, $seconds)
    {
        $this->writeTagTypeLength($tag, Type::Interval, 4);

        // always write by chunk of 8 bytes => complement to 8 through pack('N',0)
        $this->output .= pack('N', $seconds).pack('N', 0);
    }

    // TODO this function is incomplete and we'll have an issue to deal with byte[] & string
    private function getTypeForValue($value): Type
    {
        if (is_int($value)) {
            return Type::Integer;
        }
        if (is_string($value)) {
            return Type::Text_String;
        }
        if (is_array($value)) {
            return Type::Structure;
        }
        if (is_bool($value)) {
            return Type::Boolean;
        }
        if ($value instanceof \BackedEnum) {
            return Type::Enumeration;
        }

        return Type::Structure; // Default to Structure
    }


    public function encodeValue(Tag $tag, $value, Type $type)
    {
        switch ($type) {
            case Type::Integer:
                $this->writeInteger($tag, $value);
                break;
            case Type::Boolean:
                $this->writeBool($tag, $value ? 1 : 0);
                break;
            case Type::Text_String:
                $this->writeString($tag, $value);
                break;
            case Type::Enumeration:
                $this->writeEnum($tag, $value);
                break;
            case Type::Structure:
                $this->encode($value);
                break;
        }
    }
}
