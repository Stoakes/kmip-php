<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Stoakes\Kmip\Decoder;
use Stoakes\Kmip\Enum\CryptographicAlgorithm;
use Stoakes\Kmip\Enum\KeyFormatType;
use Stoakes\Kmip\Enum\ObjectType;
use Stoakes\Kmip\Enum\Operation;
use Stoakes\Kmip\Payload\CreateResponse;
use Stoakes\Kmip\Payload\GetResponse;
use Stoakes\Kmip\Protocol\ProtocolVersion;
use Stoakes\Kmip\Protocol\ResponseMessage;
use Stoakes\Kmip\Type\Type;
use Stoakes\Kmip\Tag\Tag;

final class DecoderTest extends TestCase
{
    /**
     * Test decoding of a response message into a struct.
     * And that each field is correctly set as it should be
     */
    public function testDecode0(): void
    {
        /**
         *  ResponseMessage (Structure/160):
         *      ResponseHeader (Structure/72):
         *          ProtocolVersion (Structure/32):
         *              ProtocolVersionMajor (Integer/4): 2
         *              ProtocolVersionMinor (Integer/4): 0
         *          TimeStamp (DateTime/8): 2024-11-28 09:22:59 +0000 UTC
         *          BatchCount (Integer/4): 1
         *      BatchItem (Structure/72):
         *          Operation (Enumeration/4): Create
         *          ResultStatus (Enumeration/4): Success
         *          ResponsePayload (Structure/32):
         *              ObjectType (Enumeration/4): SymmetricKey
         *              UniqueIdentifier (TextString/3): 143
         */
        $hexString = "42007b01000000a042007a0100000048420069010000002042006a0200000004000000020000000042006b020000000400000000000000004200920900000008000000006748367342000d0200000004000000010000000042000f010000004842005c0500000004000000010000000042007f0500000004000000000000000042007c01000000204200570500000004000000020000000042009407000000033134330000000000";

        $ttlv = new Decoder(hex2bin($hexString));

        $decoded = $ttlv->decode(ResponseMessage::class);
        $this->assertInstanceOf(ResponseMessage::class, $decoded);
        // header
        $this->assertEquals(2, $decoded->responseHeader->protocolVersion->protocolVersionMajor);
        $this->assertEquals(0, $decoded->responseHeader->protocolVersion->protocolVersionMinor);
        $this->assertEquals(1732785779, $decoded->responseHeader->timeStamp->getTimestamp());
        $this->assertEquals(1, $decoded->responseHeader->batchCount);
        // response payload
        $this->assertCount(1, $decoded->batchItem);
        $this->assertEquals(Operation::Create, $decoded->batchItem[0]->operation);
        $this->assertInstanceOf(CreateResponse::class, $decoded->batchItem[0]->responsePayload);
        $this->assertEquals(ObjectType::SymmetricKey, $decoded->batchItem[0]->responsePayload->objectType);
        $this->assertEquals(143, $decoded->batchItem[0]->responsePayload->uniqueIdentifier);
    }

    /**
     * A test of decoding on a smaller payload, which is not directly a response payload.
     * We also use this test as an opportunity to test other Decoder methods
     */
    public function testDecode1(): void
    {
        /**
         * ProtocolVersion (Structure/32):
         *      ProtocolVersionMajor (Integer/4): 2
         *      ProtocolVersionMinor (Integer/4): 0
         */
        $hexString = "420069010000002042006a0200000004000000020000000042006b02000000040000000000000000";

        $decoder = new Decoder(hex2bin($hexString));
        /** @var ProtocolVersion $res */
        $res = $decoder->decode(ProtocolVersion::class);

        $this->assertInstanceOf(ProtocolVersion::class, $res);
        $this->assertEquals(2, $res->protocolVersionMajor);
        $this->assertEquals(0, $res->protocolVersionMinor);
        $this->assertEquals(32, $decoder->getLength());
        $this->assertEquals(Type::Structure, $decoder->getType());
        $this->assertEquals(Tag::ProtocolVersion, $decoder->getTag());
    }

    /**
     * Test decode when applying on a simple TTLV.
     * We expect to get the TTLV's value.
     */
    public function testDecodeBaseType(): void
    {
        $hexString = "42006a02000000040000000200000000";

        $decoder = new Decoder(hex2bin($hexString));
        $res = $decoder->decode('');
        $this->assertEquals(2, $res);
    }

    /**
     * Test the behaviour of unmarshallInto() for the elements of a structure in a class
     */
    public function testUnmarshallInner(): void
    {
        /**
         * ProtocolVersionMajor (Integer/4): 2
         * ProtocolVersionMinor (Integer/4): 4
         */
        $hexString = "42006a0200000004000000020000000042006b02000000040000000400000000";
        $ttlv = new Decoder(hex2bin($hexString));

        /** @var ProtocolVersion $res */
        $res = $ttlv->unmarshallInner(ProtocolVersion::class);
        $this->assertEquals(2, $res->protocolVersionMajor);
        $this->assertEquals(4, $res->protocolVersionMinor);
    }

    public function testFailDecodeOnMultipleTTLV(): void
    {
        $hexString = "42006a0200000004000000020000000042006b02000000040000000400000000";
        $ttlv = new Decoder(hex2bin($hexString));

        /* Expect decode to fail because this is not a simple TTLV */
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage("unmarshall doesn't support buffer with multiple structures (ie where next() is not null). Have a look at unmarshallInner instead.");
        $ttlv->decode('');
    }

    /**
     * Get Key Response is one of the most complex KMIP response payload,
     * with a large variety of types.
     * This test checks that it is correctly decoded.
     * It also demonstrates how ByteString are handled by kmip-php.
     */
    public function testReadGetKeyResponse(): void
    {
        /**
         * ResponsePayload (Structure/144):
         *  ObjectType (Enumeration/4): SymmetricKey
         *  UniqueIdentifier (TextString/3): 150
         *  SymmetricKey (Structure/104):
         *      KeyBlock (Structure/96):
         *          KeyFormatType (Enumeration/4): Raw
         *          KeyValue (Structure/40):
         *              KeyMaterial (ByteString/32): 0x60a5908002c0e36afe77ec9329d121aabfb640975fd6be668ad75a88f9b32d0f
         *          CryptographicAlgorithm (Enumeration/4): AES
         *          CryptographicLength (Integer/4): 256
         */
        $hexString = '42007c0100000090420057050000000400000002000000004200940700000003313530000000000042008f01000000684200400100000060420042050000000400000001000000004200450100000028420043080000002060a5908002c0e36afe77ec9329d121aabfb640975fd6be668ad75a88f9b32d0f4200280500000004000000030000000042002a02000000040000010000000000';
        $ttlv = new Decoder(hex2bin($hexString));

        /** @var GetResponse $res */
        $res = $ttlv->decode(GetResponse::class);
        $this->assertEquals(CryptographicAlgorithm::AES, $res->symmetricKey->keyBlock->cryptographicAlgorithm);
        $this->assertEquals(
            '60a5908002c0e36afe77ec9329d121aabfb640975fd6be668ad75a88f9b32d0f',
            $res->symmetricKey->keyBlock->keyValue->keyMaterial
        );
        $this->assertEquals(256, $res->symmetricKey->keyBlock->cryptographicLength);
        $this->assertEquals(KeyFormatType::Raw, $res->symmetricKey->keyBlock->keyFormatType);
        $this->assertEquals(150, $res->uniqueIdentifier);
        $this->assertEquals(ObjectType::SymmetricKey, $res->objectType);
        $this->assertNull($res->privateKey);
        $this->assertNull($res->publicKey);
    }
}
