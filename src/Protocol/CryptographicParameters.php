<?php

namespace Stoakes\Kmip\Protocol;

use Stoakes\Kmip\Enum\BlockCipherMode;
use Stoakes\Kmip\Enum\CryptographicAlgorithm;
use Stoakes\Kmip\Enum\DigitalSignatureAlgorithm;
use Stoakes\Kmip\Enum\HashingAlgorithm;
use Stoakes\Kmip\Enum\KeyRoleType;
use Stoakes\Kmip\Enum\MaskGenerator;
use Stoakes\Kmip\Enum\PaddingMethod;

class CryptographicParameters implements ReceivedStructureInterface
{
    use SetTrait;

    public ?BlockCipherMode $blockCipherMode = null;
    public ?PaddingMethod $paddingMethod = null;
    public ?HashingAlgorithm $hashingAlgorithm = null;
    public ?KeyRoleType $keyRoleType = null;
    public ?DigitalSignatureAlgorithm $digitalSignatureAlgorithm = null;
    public ?CryptographicAlgorithm $cryptographicAlgorithm = null;
    public ?bool $randomIV = null;
    public ?int $ivLength = null;
    public ?int $tagLength = null;
    public ?int $fixedFieldLength = null;
    public ?int $invocationFieldLength = null;
    public ?int $counterLength = null;
    public ?int $initialCounterValue = null;
    public ?int $saltLength = null;
    public ?MaskGenerator $maskGenerator = MaskGenerator::MGF1; // defaults to MGF1
    public ?HashingAlgorithm $maskGeneratorHashingAlgorithm = HashingAlgorithm::SHA1; // defaults to SHA-1
    public ?string $pSource = null;
    public ?int $trailerField = null;

    public function __construct()
    {
        // Set default values
        $this->maskGenerator = MaskGenerator::MGF1;
        $this->maskGeneratorHashingAlgorithm = HashingAlgorithm::SHA1;
    }
}
