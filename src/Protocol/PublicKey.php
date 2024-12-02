<?php

namespace Stoakes\Kmip\Protocol;

class PublicKey implements ReceivedStructureInterface
{
    use SetTrait;

    public ?KeyBlock $keyBlock;
}
