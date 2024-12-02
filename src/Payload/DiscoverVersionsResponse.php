<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Protocol\ProtocolVersion;

class DiscoverVersionsResponse
{
    /** @var ProtocolVersion[] */
    public array $protocolVersions = [];
}
