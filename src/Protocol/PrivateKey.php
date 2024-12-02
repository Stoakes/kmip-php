<?php

namespace Stoakes\Kmip\Protocol;

class PrivateKey implements ReceivedStructureInterface
{
    use SetTrait;

    public ?KeyBlock $keyBlock;
}
