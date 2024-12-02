<?php

namespace Stoakes\Kmip\Protocol;

class RequestMessage
{
    public RequestHeader $requestHeader;

    /** @var BatchItem[] */
    public array $batchItem;

    /**
     * @param RequestHeader $requestHeader
     * @param BatchItem[]   $batchItem
     */
    public function __construct(RequestHeader $requestHeader, array $batchItem)
    {
        $this->requestHeader = $requestHeader;
        $this->batchItem = $batchItem;
    }


}
