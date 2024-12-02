<?php

namespace Stoakes\Kmip\Protocol;

class ProtocolVersion implements ReceivedStructureInterface
{
    use SetTrait;

    public int $protocolVersionMajor;
    public int $protocolVersionMinor;

    public static function new(int $protocolVersionMajor, int $protocolVersionMinor)
    {
        $res = new ProtocolVersion();
        $res->protocolVersionMajor = $protocolVersionMajor;
        $res->protocolVersionMinor = $protocolVersionMinor;

        return $res;
    }
}
