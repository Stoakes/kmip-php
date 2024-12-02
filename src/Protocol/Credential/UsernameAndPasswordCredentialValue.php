<?php

namespace Stoakes\Kmip\Protocol\Credential;

// UsernameAndPasswordCredentialValue 2.1.2 Table 4
//
// If the Credential Type in the Credential is Username and Password, then Credential Value is a
// structure as shown in Table 4. The Username field identifies the client, and the Password field
// is a secret that authenticates the client.
class UsernameAndPasswordCredentialValue
{
    public string $username;
    public string $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }


}
