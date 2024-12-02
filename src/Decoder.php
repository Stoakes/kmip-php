<?php

namespace Stoakes\Kmip;

use Stoakes\Kmip\Type\Type;
use Stoakes\Kmip\Tag\Tag;

/**
 * Decoder is a byte array on steroids. Create it with binary data from a KMIP and use it to retrieve the result
 * in KMIP PHP structures.
 */
class Decoder
{
    private const HEADER_LENGTH = 8;
    private string $input;

    /**
     * @var Type|null cache for type value. Populated the first time getType is called.
     */
    private ?Type $type = null;
    /**
     * @var int|null cache for buffer length. Populated first time getLength is called.
     */
    private ?int $length = null;

    public function __construct(string $data)
    {
        $this->input = $data;
    }

    /**
     * Maps a KMIP structure to a PHP class.
     * For example, maps a:
     *  ProtocolVersion (Structure/32):
     *       ProtocolVersionMajor (Integer/4): 2
     *       ProtocolVersionMinor (Integer/4): 0
     * to a Stoakes\Kmip\Protocol\ProtocolVersion.
     *
     * @return mixed
     * @throws \Exception
     */
    public function decode(string $className): mixed
    {
        if ($this->next() !== null) {
            throw new \LogicException('unmarshall doesn\'t support buffer with multiple structures (ie where next() is not null). Have a look at unmarshallInner instead.');
        }

        $value = $this->getValue();
        if ($value instanceof Decoder) {
            return $value->unmarshallInner($className);
        }

        return $value;
    }

    /**
     * Read the buffer and try to map the fields into the fields of a class.
     *
     * For example unmarshallInner maps:
     *  ProtocolVersionMajor (Integer/4): 2
     *  ProtocolVersionMinor (Integer/4): 0
     * to the fields of a Stoakes\Kmip\Protocol\ProtocolVersion.
     *
     * To have a function which maps the outer object to a class, please see unmarshall
     *
     * @param string $className
     *
     * @return void
     */
    public function unmarshallInner(string $className): mixed
    {
        $result = new $className();
        $reading = $this;
        do {
            $next = $reading?->next();
            $reading->validateHeader();
            $result->set($reading->getTag(), $reading->getValue());

            $reading = $next;
        } while ($next);

        return $result;
    }

    public function getType(): Type
    {
        if ($this->type) {
            return $this->type;
        }
        $this->type = $this->validateHeader();

        return $this->type;
    }

    /**
     * Validates that header contains valid data. If it does, it returns the header type.
     * If it doesn't, it throws an Exception
     * @return Type
     */
    public function validateHeader(): Type
    {
        $header = substr($this->input, 0, self::HEADER_LENGTH);
        if (!$this->validTag($header)) {
            throw new \LogicException('Invalid tag');
        }


        $type = Type::tryFrom(ord($header[3]));
        if (!$type) {
            throw new \LogicException('Invalid type');
        }


        // equivalent to int(binary.BigEndian.Uint32(t[4:8]))
        $length = ((ord($header[4]) & 0xFF) << 24) |
            ((ord($header[5]) & 0xFF) << 16) |
            ((ord($header[6]) & 0xFF) << 8) |
            (ord($header[7]) & 0xFF);

        switch ($type) {
            case Type::Structure:
            case Type::Text_String:
            case Type::Byte_String:
                // any length is valid
                break;
            case Type::Integer:
            case Type::Enumeration:
            case Type::Interval:
                if ($length != 4) {
                    throw new \LogicException('Invalid length. Got '.$length.' instead of 4');
                }
                break;
            case Type::Long_Integer:
            case Type::Boolean:
            case Type::Date_Time:
                if ($length != 8) {
                    throw new \LogicException('Invalid length. Got '.$length.' instead of 8');
                }
                break;
            case Type::Big_Integer:
                if ($length % 8 != 0) {
                    throw new \LogicException('Invalid length. Should be multiple of 8. Got '.$length);
                }
                break;
            default: // future proofing here. Never executed because all current types are enumerated above
                throw new \LogicException('Invalid type');
                break;
        }

        $this->length = $length;

        return $type;
    }

    /** Length as read from header bytes */
    public function getLength(): int
    {
        if ($this->length) {
            return $this->length;
        }
        $this->validateHeader();

        return $this->length;
    }

    public function getTag(): Tag
    {
        // KMIP tags are 3 bytes
        $tag = substr($this->input, 0, 3);

        // Prepend a null byte to make it 4 bytes
        // Unpack as big-endian 32-bit integer
        $formatted = unpack('N', "\x00".$tag)[1];

        return Tag::tryFrom($formatted);
    }

    /**
     * @return bool|\DateTime|int|Decoder|string the inner value of a Decoder, converted to idiomatic PHP type
     */
    public function getValue()
    {
        switch ($this->getType()) {
            case Type::Structure:
                // if entire structure, returns inner value
                if (strlen($this->input) < self::HEADER_LENGTH + $this->getLength()) {
                    // return t[lenHeader:]
                    return new Decoder(substr($this->input, self::HEADER_LENGTH));
                }

                // return t[lenHeader : lenHeader+l]
                return new Decoder(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            case Type::Integer:

                return $this->readInteger(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            case Type::Big_Integer:
                return $this->readLongInteger(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            case Type::Enumeration:
                return $this->readEnumeration(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            case Type::Boolean:
                return $this->readBoolean(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            case Type::Text_String:
                return $this->readTextString(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            case Type::Byte_String:
                return $this->readByteString(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            case Type::Date_Time:
                return $this->readDateTime(substr($this->input, self::HEADER_LENGTH, $this->getLength()));

            default:
                throw new \Exception("Unsupported KMIP type: ".$this->type->canonicalName());
        }
    }
    /**
     * Checks whether a TTLV value is valid by verifying the value segment length
     * and recursively checking enclosed TTLV values for Structure types.
     *
     * @return bool Returns if valid
     */
    public function valid(): bool
    {
        // Check header validity first
        $this->validateHeader();

        // If type is Structure, recursively check all enclosed TTLV values
        if ($this->getType() === Type::Structure) {
            /** @var Decoder $inner */
            $inner = $this->getValue();
            while ($inner && $inner->getLength() > 0) {
                if (!$inner->valid()) {
                    return false;
                }
                $inner = $inner->next();
            }
        }

        return true;
    }

    public function toString()
    {
        return $this->input;
    }

    private function validTag(string $data): bool
    {
        return ord($data[0]) == 0x42 || ord($data[0]) == 0x54; // tag always start by 0x0042
    }

    /**
     * @return  array<array-key, array{
     *     tag: Tag,
     *     type: Type,
     *     length: int,
     *     value: mixed
     * }>
     */
    private function readStructure(Decoder $buffer): array
    {
        $items = [];

        $inner = $buffer->getValue(); // child of a structure => structure or basic type

        do {
            $nestedType = $inner->getType();
            $nestedLength = $inner->getLength();

            // Read tag and value for the nested structure
            $tag = $inner->getTag();
            $value = $inner->getValue();

            $items[] = [
                'tag' => $tag,
                'type' => $nestedType,
                'length' => $nestedLength,
                'value' => $value,
            ];
            $inner = $inner->next();
        } while ($inner); // while next exists

        return $items;
    }

    private function readInteger(string $buffer): int
    {
        $data = substr($buffer, 0, 4); // Integer is always 4 bytes
        return unpack('N', $data)[1];
    }

    private function readLongInteger(string $buffer): int
    {
        $data = substr($buffer, 0, 8); // Long Integer is always 8 bytes

        return unpack('J', $data)[1];
    }

    private function readEnumeration(string $buffer): int
    {
        return $this->readInteger($buffer);
    }

    private function readBoolean(string $buffer): bool
    {
        $data = substr($buffer, 0, 8); // Boolean is always 8 bytes in KMIP

        return unpack('J', $data)[1] === 1;
    }

    private function readTextString(string $buffer): string
    {
        return trim($buffer);
    }

    private function readByteString(string $buffer): string
    {
        return bin2hex($buffer);
    }

    private function readDateTime(string $buffer): \DateTime
    {
        $data = substr($buffer, 0, 8); // DateTime is always 8 bytes
        $timestamp = unpack('J', $data)[1];

        return new \DateTime('@'.$timestamp);
    }

    /**
     * Returns the expected length of the entire TTLV block (header + value),
     * based on the type and length encoded in the header.
     *
     * @return int
     * @throws \RuntimeException if type encoded in header is invalid or unrecognized
     */
    private function getFullLen(): int
    {
        switch ($this->getType()) {
            case Type::Interval:
            case Type::Date_Time:
            case Type::Boolean:
            case Type::Enumeration:
            case Type::Long_Integer:
            case Type::Integer:
                return self::HEADER_LENGTH + 8;

            case Type::Byte_String:
            case Type::Text_String:
                $l = $this->getLength() + self::HEADER_LENGTH;
                $m = $l % 8;
                if ($m > 0) {
                    return $l + (8 - $m);
                }

                return $l;

            case Type::Big_Integer:
            case Type::Structure:
                return $this->getLength() + self::HEADER_LENGTH;
        }

        throw new \RuntimeException(sprintf("Invalid type: %x", $this->getType()));
    }

    /**
     * Get the next TTLV block after the current one.
     *
     * @return ?self Returns null if there is no next block or if current block is invalid
     */
    private function next(): ?Decoder
    {
        if (!$this->valid()) {
            return null;
        }
        $fullLen = $this->getFullLen();
        $remaining = substr($this->input, $fullLen);

        if (strlen($remaining) === 0) {
            return null;
        }

        return new self($remaining);
    }
}
