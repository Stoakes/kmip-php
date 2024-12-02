<?php

namespace Stoakes\Kmip\Protocol;

/**
 * Basic alias to make a difference between request & response batch item.
 * And yet still have a class matching Tag::BatchItem 0x0042000F
 */
class RequestBatchItem extends BatchItem
{
}
