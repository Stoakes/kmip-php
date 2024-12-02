<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Decoder;
use Stoakes\Kmip\Tag\Tag;

class ResponseMessage implements ReceivedStructureInterface
{
    public ResponseHeader $responseHeader;

    /** @var ResponseBatchItem[]
     * In practice, the cardinality of this array will always be 1
     */
    public array $batchItem;

    public function set(Tag $tag, $value)
    {
        // no specific assignation in a ResponseMessage, so it's a basic name match
        switch ($tag) {
            case Tag::ResponseHeader:
                $this->responseHeader = $value->unmarshallInner(ResponseHeader::class);
                break;
            case Tag::BatchItem:
                $this->batchItem[] = $value->unmarshallInner(ResponseBatchItem::class);
                break;
            default:
                throw new \LogicException("Cannot assign $tag->name in a ResponseMessage");
        }
    }
}
