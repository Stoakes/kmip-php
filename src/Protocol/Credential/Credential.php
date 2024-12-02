<?php

namespace Stoakes\Kmip\Protocol\Credential;

use Stoakes\Kmip\Enum\CredentialType;

// Credential 2.1.2 Table 3
//
// A Credential is a structure (see Table 3) used for client identification purposes and is not managed by the
// key management system (e.g., user id/password pairs, Kerberos tokens, etc.). It MAY be used for authentication
// purposes as indicated in [KMIP-Prof].

class Credential
{
    public CredentialType $credentialType;

    public $credentialValue;

    public function __construct(CredentialType $credentialType, $credentialValue)
    {
        $this->credentialType = $credentialType;
        $this->credentialValue = $credentialValue;
    }
}
