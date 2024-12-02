<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\AttestationType;
use Stoakes\Kmip\Enum\BatchErrorContinuationOption;

class RequestHeader
{
    public ProtocolVersion $protocolVersion;
    public ?int $maximumResponseSize = null;
    public ?string $clientCorrelationValue = null;
    public ?string $serverCorrelationValue = null;
    public ?bool $asynchronousIndicator = null;
    public ?bool $attestationCapableIndicator = null;
    /** @var AttestationType[] */
    public array $attestationType = [];
    public ?Authentication $authentication = null;
    public ?BatchErrorContinuationOption $batchErrorContinuationOption = null;
    public ?bool $batchOrderOption = null;
    public ?\DateTime $timeStamp = null;
    public int $batchCount;

    public function __construct(
        ProtocolVersion               $protocolVersion,
        ?int                          $maximumResponseSize = null,
        ?string                       $clientCorrelationValue = null,
        ?string                       $serverCorrelationValue = null,
        ?bool                         $asynchronousIndicator = null,
        ?bool                         $attestationCapableIndicator = null,
        array                         $attestationType = [],
        ?Authentication               $authentication = null,
        ?BatchErrorContinuationOption $batchErrorContinuationOption = null,
        ?bool                         $batchOrderOption = null,
        ?\DateTime                    $timeStamp = null,
        int                           $batchCount = 1
    ) {
        $this->protocolVersion = $protocolVersion;
        $this->maximumResponseSize = $maximumResponseSize;
        $this->clientCorrelationValue = $clientCorrelationValue;
        $this->serverCorrelationValue = $serverCorrelationValue;
        $this->asynchronousIndicator = $asynchronousIndicator;
        $this->attestationCapableIndicator = $attestationCapableIndicator;
        $this->attestationType = $attestationType;
        $this->authentication = $authentication;
        $this->batchErrorContinuationOption = $batchErrorContinuationOption;
        $this->batchOrderOption = $batchOrderOption;
        $this->timeStamp = $timeStamp;
        $this->batchCount = $batchCount;
    }


}
