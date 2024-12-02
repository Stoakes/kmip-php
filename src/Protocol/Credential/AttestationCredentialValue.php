<?php

namespace Stoakes\Kmip\Protocol\Credential;

use Stoakes\Kmip\Enum\AttestationType;
use Stoakes\Kmip\Protocol\Nonce;

// AttestationCredentialValue 2.1.2 Table 6
//
// If the Credential Type in the Credential is Attestation, then Credential Value is a structure
// as shown in Table 6. The Nonce Value is obtained from the key management server in a Nonce Object.
// The Attestation Credential Object can contain a measurement from the client or an assertion from a
// third party if the server is not capable or willing to verify the attestation data from the client.
// Neither type of attestation data (Attestation Measurement or Attestation Assertion) is necessary to
// allow the server to accept either. However, the client SHALL provide attestation data in either the
// Attestation Measurement or Attestation Assertion fields.
class AttestationCredentialValue
{
    /**
     * @var Nonce
     */
    public Nonce $nonce;

    /**
     * @var AttestationType
     */
    public AttestationType $attestationType;

    /**
     * @var string|null
     */
    public $attestationMeasurement;

    /**
     * @var string|null
     */
    public $attestationAssertion;

    public function __construct(Nonce $nonce, AttestationType $attestationType, $attestationMeasurement = null, $attestationAssertion = null)
    {
        $this->nonce = $nonce;
        $this->attestationType = $attestationType;
        $this->attestationMeasurement = $attestationMeasurement;
        $this->attestationAssertion = $attestationAssertion;
    }
}
