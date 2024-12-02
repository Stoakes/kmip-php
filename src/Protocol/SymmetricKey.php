<?php

namespace Stoakes\Kmip\Protocol;

class SymmetricKey implements ReceivedStructureInterface
{
    use SetTrait;
    public ?KeyBlock $keyBlock;
}
