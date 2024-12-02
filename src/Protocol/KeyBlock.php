<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\CryptographicAlgorithm;
use Stoakes\Kmip\Enum\KeyCompressionType;
use Stoakes\Kmip\Enum\KeyFormatType;

// KeyBlock 2.1.3 Table 7
//
// A Key Block object is a structure (see Table 7) used to encapsulate all of the information that is
// closely associated with a cryptographic key. It contains a Key Value of one of the following Key Format Types:
//
// · Raw – This is a key that contains only cryptographic key material, encoded as a string of bytes.
// · Opaque – This is an encoded key for which the encoding is unknown to the key management system.
//   It is encoded as a string of bytes.
// · PKCS1 – This is an encoded private key, expressed as a DER-encoded ASN.1 PKCS#1 object.
// · PKCS8 – This is an encoded private key, expressed as a DER-encoded ASN.1 PKCS#8 object, supporting both
//   the RSAPrivateKey syntax and EncryptedPrivateKey.
// · X.509 – This is an encoded object, expressed as a DER-encoded ASN.1 X.509 object.
// · ECPrivateKey – This is an ASN.1 encoded elliptic curve private key.
// · Several Transparent Key types – These are algorithm-specific structures containing defined values
//   for the various key types, as defined in Section 2.1.7.
// · Extensions – These are vendor-specific extensions to allow for proprietary or legacy key formats.
//
// The Key Block MAY contain the Key Compression Type, which indicates the format of the elliptic curve public
// key. By default, the public key is uncompressed.
//
// The Key Block also has the Cryptographic Algorithm and the Cryptographic Length of the key contained
// in the Key Value field. Some example values are:
//
// · RSA keys are typically 1024, 2048 or 3072 bits in length.
// · 3DES keys are typically from 112 to 192 bits (depending upon key length and the presence of parity bits).
// · AES keys are 128, 192 or 256 bits in length.
//
// The Key Block SHALL contain a Key Wrapping Data structure if the key in the Key Value field is
// wrapped (i.e., encrypted, or MACed/signed, or both).
class KeyBlock implements ReceivedStructureInterface
{
    use SetTrait;

    public KeyFormatType $keyFormatType;

    public ?KeyCompressionType $keyCompressionType;

    /**
     * @var KeyValue|string
     */
    public $keyValue;

    public ?CryptographicAlgorithm $cryptographicAlgorithm;

    /**
     * @var int|null
     */
    public ?int $cryptographicLength;

    /**
     * @var KeyWrappingData|null
     */
    public ?KeyWrappingData $keyWrappingData;

    public static function new(
        KeyFormatType $keyFormatType,
        CryptographicAlgorithm $cryptographicAlgorithm = null,
        $cryptographicLength = 0,
        ?KeyCompressionType $keyCompressionType = null,
        KeyValue|string|null $keyValue = null,
        $keyWrappingData = null
    ) {
        $res = new self();
        $res->keyFormatType = $keyFormatType;
        $res->keyCompressionType = $keyCompressionType;
        $res->keyValue = $keyValue;
        $res->cryptographicAlgorithm = $cryptographicAlgorithm;
        $res->cryptographicLength = $cryptographicLength;
        $res->keyWrappingData = $keyWrappingData;

        return $res;
    }

}
