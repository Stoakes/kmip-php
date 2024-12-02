<?php

namespace Stoakes\Kmip\Protocol;

class Nonce implements ReceivedStructureInterface
{
    use SetTrait;
    /**
     * @var string
     */
    public $nonceID;

    /**
     * @var string
     */
    public $nonceValue;

    public function __construct($nonceID, $nonceValue)
    {
        $this->nonceID = $nonceID;
        $this->nonceValue = $nonceValue;
    }
}
