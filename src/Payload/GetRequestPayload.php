<?php

namespace Stoakes\Kmip\Payload;

class GetRequestPayload extends RequestPayload
{
    public function __construct(
        public string $uniqueIdentifier
    ) {
    }
}
