<?php

namespace Stoakes\Kmip\Payload;

use Stoakes\Kmip\Enum\RevocationReasonCode;

class RevocationReason
{
    public function __construct(
        public RevocationReasonCode $revocationReasonCode,
        public ?string $revocationReason = null
    ) {
    }
}
