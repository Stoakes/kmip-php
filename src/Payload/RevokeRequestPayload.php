<?php

namespace Stoakes\Kmip\Payload;

class RevokeRequestPayload extends RequestPayload
{
    public function __construct(
        public string $uniqueIdentifier,
        public RevocationReason $revocationReason
    ) {
    }
}
