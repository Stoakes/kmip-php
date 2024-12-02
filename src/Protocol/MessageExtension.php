<?php

namespace Stoakes\Kmip\Protocol;

class MessageExtension implements ReceivedStructureInterface
{
    use SetTrait;

    public string $vendorIdentification;
    public bool $criticalityIndicator;
    public $vendorExtension;

    public function __construct(
        string $vendorIdentification,
        bool $criticalityIndicator,
        $vendorExtension = null
    ) {
        $this->vendorIdentification = $vendorIdentification;
        $this->criticalityIndicator = $criticalityIndicator;
        $this->vendorExtension = $vendorExtension;
    }
}
