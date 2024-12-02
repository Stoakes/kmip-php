<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\Operation;

class BatchItem
{
    public Operation $operation;
    public $requestPayload;
    public ?string $uniqueBatchItemID = null;
    public ?MessageExtension $messageExtension = null;

    public static function new(
        Operation         $operation,
        $requestPayload,
        ?string           $uniqueBatchItemID = null,
        ?MessageExtension $messageExtension = null
    ) {
        $res  = new self();
        $res->messageExtension = $messageExtension;
        $res->requestPayload = $requestPayload;
        $res->uniqueBatchItemID = $uniqueBatchItemID;
        $res->operation = $operation;

        return $res;
    }


}
