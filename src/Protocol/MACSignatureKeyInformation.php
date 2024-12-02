<?php

namespace Stoakes\Kmip\Protocol;

/** MACSignatureKeyInformation 2.1.5 Table 11 */

class MACSignatureKeyInformation implements ReceivedStructureInterface
{
    use SetTrait;


    public string $uniqueIdentifier;

    public ?CryptographicParameters $cryptographicParameters;

    public function __construct(string $uniqueIdentifier, ?CryptographicParameters $cryptographicParameters = null)
    {
        $this->uniqueIdentifier = $uniqueIdentifier;
        $this->cryptographicParameters = $cryptographicParameters;
    }
}
