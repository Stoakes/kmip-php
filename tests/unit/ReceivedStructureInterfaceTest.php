<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Stoakes\Kmip\Enum\KeyFormatType;
use Stoakes\Kmip\Protocol\KeyBlock;
use Stoakes\Kmip\Protocol\ProtocolVersion;
use Stoakes\Kmip\Tag\Tag;

final class ReceivedStructureInterfaceTest extends TestCase
{
    /**
     * Test set method from MessageTrait for basic types
     */
    public function testSetForBasicTypes(): void
    {
        $pp = new ProtocolVersion();
        $pp->set(Tag::ProtocolVersionMajor, 2);
        $pp->set(Tag::ProtocolVersionMinor, 0);

        $this->assertEquals(2, $pp->protocolVersionMajor);
        $this->assertEquals(0, $pp->protocolVersionMinor);
    }

    /**
     * This tests demonstrates that when allocating int to an enum, these are correctly handled by the SetTrait
     * @return void
     */
    public function testSetWithEnum(): void
    {
        $kb = new KeyBlock();
        $kb->set(Tag::KeyFormatType, 1); // this tests no exception is raised

        $this->assertEquals(KeyFormatType::Raw, $kb->keyFormatType);
    }
}
