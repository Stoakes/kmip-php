<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Protocol\Credential\Credential;

class Authentication
{
    /**
     * @var Credential[]
     */
    public $credential;

    public function __construct(array $credential)
    {
        $this->credential = $credential;
    }
}
