<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\Operation;
use Stoakes\Kmip\Enum\ResultReason;
use Stoakes\Kmip\Enum\ResultStatus;
use Stoakes\Kmip\Payload\ActivateResponse;
use Stoakes\Kmip\Payload\CreateKeyPairResponse;
use Stoakes\Kmip\Payload\CreateResponse;
use Stoakes\Kmip\Payload\DecryptResponse;
use Stoakes\Kmip\Payload\DestroyResponse;
use Stoakes\Kmip\Payload\DiscoverVersionsResponse;
use Stoakes\Kmip\Payload\EncryptResponse;
use Stoakes\Kmip\Payload\GetAttributeListResponse;
use Stoakes\Kmip\Payload\GetAttributesResponse;
use Stoakes\Kmip\Payload\GetResponse;
use Stoakes\Kmip\Payload\RevokeResponse;
use Stoakes\Kmip\Payload\SignResponse;
use Stoakes\Kmip\Tag\Tag;

class ResponseBatchItem implements ReceivedStructureInterface
{
    public ?Operation $operation = null;
    public ?string $uniqueBatchItemID = null;
    public ResultStatus $resultStatus;
    public ?ResultReason $resultReason = null;
    public ?string $resultMessage = null;
    public ?string $asynchronousCorrelationValue = null;
    public mixed $responsePayload = null;
    public ?MessageExtension $messageExtension = null;

    public static function new(
        ?Operation $operation,
        ?string $uniqueBatchItemID,
        ResultStatus $resultStatus,
        ?ResultReason $resultReason,
        ?string $resultMessage,
        ?string $asynchronousCorrelationValue,
        $responsePayload,
        ?MessageExtension $messageExtension
    ): self {
        $res = new ResponseBatchItem();
        $res->operation = $operation;
        $res->uniqueBatchItemID = $uniqueBatchItemID;
        $res->resultStatus = $resultStatus;
        $res->resultReason = $resultReason;
        $res->resultMessage = $resultMessage;
        $res->asynchronousCorrelationValue = $asynchronousCorrelationValue;
        $res->responsePayload = $responsePayload;
        $res->messageExtension = $messageExtension;

        return $res;
    }

    public function set(Tag $tag, $value)
    {
        $propertyName = lcfirst($tag->name);
        if (!property_exists($this, $propertyName)) {
            throw new \LogicException("Cannot assign $tag->name in a ResponseBatchItem");
        }

        switch ($tag) {
            case Tag::Operation:
                $this->operation = Operation::from($value);
                return;
            case Tag::ResultStatus:
                $this->resultStatus = ResultStatus::from($value);
                return;
            case Tag::ResultReason:
                $this->resultReason = ResultReason::from($value);
                return;
            case Tag::MessageExtension:
                $this->messageExtension = $value->unmarshallInner(MessageExtension::class);
                return;
            default:
                break;
        }

        if ($tag != Tag::ResponsePayload) {
            $this->$propertyName = $value;
            return;
        }

        // dealing with responsePayload polymorphism
        $this->responsePayload = $value->unmarshallInner($this->getResponsePayloadType());
    }

    /**
     * @return string based on operation type, determine payload
     */
    private function getResponsePayloadType(): string
    {
        if (!$this->operation) {
            // that's a known limitation, we'll see in a future release how to deal with that at unmarshall time
            throw new \LogicException("Cannot determine response payload type prior to setting operation property");
        }

        switch ($this->operation) {
            case Operation::Create:
                return CreateResponse::class;
            case Operation::CreateKeyPair:
                return CreateKeyPairResponse::class;
            case Operation::Get:
                return GetResponse::class;
            case Operation::GetAttributes:
                return GetAttributesResponse::class;
            case Operation::GetAttributeList:
                return GetAttributeListResponse::class;
            case Operation::Activate:
                return ActivateResponse::class;
            case Operation::Revoke:
                return RevokeResponse::class;
            case Operation::Destroy:
                return DestroyResponse::class;
            case Operation::DiscoverVersions:
                return DiscoverVersionsResponse::class;
            case Operation::Encrypt:
                return EncryptResponse::class;
            case Operation::Decrypt:
                return DecryptResponse::class;
            case Operation::Sign:
                return SignResponse::class;
            case Operation::Register:
            case Operation::Locate:
            case Operation::Rekey:
            default:
                throw new \LogicException('Unsupported operation '.$this->operation->name);
        }

    }

}
