<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\AttestationType;

class ResponseHeader implements ReceivedStructureInterface
{
    use SetTrait;

    public ProtocolVersion $protocolVersion;
    public \DateTime $timeStamp;
    public ?Nonce $nonce = null;

    /** @var AttestationType[] */
    public array $attestationType = [];
    public ?string $clientCorrelationValue = null;
    public ?string $serverCorrelationValue = null;
    public int $batchCount;


    /**
     * new must be used to initialize a ResponseHeader from code, when attributes values are known in advance
     *  (ie not when decoding a message)
     * @param ProtocolVersion $protocolVersion
     * @param \DateTime       $timestamp
     * @param Nonce|null      $nonce
     * @param array           $attestationType
     * @param string|null     $clientCorrelationValue
     * @param string|null     $serverCorrelationValue
     * @param int             $batchCount
     *
     * @return ResponseHeader
     */
    public static function new(
        ProtocolVersion $protocolVersion,
        \DateTime $timestamp,
        ?Nonce $nonce,
        array           $attestationType,
        ?string $clientCorrelationValue,
        ?string         $serverCorrelationValue,
        int $batchCount
    ) {
        $res = new ResponseHeader();
        $res->protocolVersion = $protocolVersion;
        $res->timeStamp = $timestamp;
        $res->nonce = $nonce;
        $res->attestationType = $attestationType;
        $res->clientCorrelationValue = $clientCorrelationValue;
        $res->serverCorrelationValue = $serverCorrelationValue;
        $res->batchCount = $batchCount;

        return $res;
    }
}
