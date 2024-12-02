<?php

namespace Stoakes\Kmip\Protocol;

class EncryptionKeyInformation implements ReceivedStructureInterface
{
    use SetTrait;

    /**
     * @var string
     */
    public $uniqueIdentifier;

    /**
     * @var CryptographicParameters|null
     */
    public ?CryptographicParameters $cryptographicParameters;

    public function __construct($uniqueIdentifier, ?CryptographicParameters $cryptographicParameters = null)
    {
        $this->uniqueIdentifier = $uniqueIdentifier;
        $this->cryptographicParameters = $cryptographicParameters;
    }
}
