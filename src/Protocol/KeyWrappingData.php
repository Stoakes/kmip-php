<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\EncodingOption;
use Stoakes\Kmip\Enum\WrappingMethod;

class KeyWrappingData implements ReceivedStructureInterface
{
    use SetTrait;

    public WrappingMethod $wrappingMethod;

    public ?EncryptionKeyInformation $encryptionKeyInformation;

    public ?MACSignatureKeyInformation $macSignatureKeyInformation;

    /**
     * @var string|null byte[]
     */
    public ?string $macSignature;

    /**
     * @var string|null byte[]
     */
    public ?string $ivCounterNonce;

    public EncodingOption $encodingOption;

    public function __construct(
        WrappingMethod              $wrappingMethod,
        ?EncryptionKeyInformation   $encryptionKeyInformation = null,
        ?MACSignatureKeyInformation $macSignatureKeyInformation = null,
        $macSignature = null,
        $ivCounterNonce = null,
        $encodingOption = null
    ) {
        $this->wrappingMethod = $wrappingMethod;
        $this->encryptionKeyInformation = $encryptionKeyInformation;
        $this->macSignatureKeyInformation = $macSignatureKeyInformation;
        $this->macSignature = $macSignature;
        $this->ivCounterNonce = $ivCounterNonce;
        $this->encodingOption = $encodingOption;
    }
}
