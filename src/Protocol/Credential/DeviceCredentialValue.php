<?php

namespace Stoakes\Kmip\Protocol\Credential;

// DeviceCredentialValue 2.1.2 Table 5
//
// If the Credential Type in the Credential is Device, then Credential Value is a structure as shown in
// Table 5. One or a combination of the Device Serial Number, Network Identifier, Machine Identifier,
// and Media Identifier SHALL be unique. Server implementations MAY enforce policies on uniqueness for
// individual fields.  A shared secret or password MAY also be used to authenticate the client.
// The client SHALL provide at least one field.

class DeviceCredentialValue
{
    public ?string $deviceSerialNumber = null;
    public ?string $password = null;
    public ?string $deviceIdentifier = null;
    public ?string $networkIdentifier = null;
    public ?string $machineIdentifier = null;
    public ?string $mediaIdentifier = null;

    public function __construct(
        ?string $deviceSerialNumber = null,
        ?string $password = null,
        ?string $deviceIdentifier = null,
        ?string $networkIdentifier = null,
        ?string $machineIdentifier = null,
        ?string $mediaIdentifier = null
    ) {
        $this->deviceSerialNumber = $deviceSerialNumber;
        $this->password = $password;
        $this->deviceIdentifier = $deviceIdentifier;
        $this->networkIdentifier = $networkIdentifier;
        $this->machineIdentifier = $machineIdentifier;
        $this->mediaIdentifier = $mediaIdentifier;
    }
}
