<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Tag\Tag;

interface ReceivedStructureInterface
{
    public function set(Tag $tag, $value);
}
