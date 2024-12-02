<?php

namespace Stoakes\Kmip;

use Stoakes\Kmip\Enum\CryptographicAlgorithm;
use Stoakes\Kmip\Enum\ObjectType;
use Stoakes\Kmip\Enum\Operation;
use Stoakes\Kmip\Enum\RevocationReasonCode;
use Stoakes\Kmip\Mask\CryptographicUsageMask;
use Stoakes\Kmip\Payload\GetRequestPayload;
use Stoakes\Kmip\Payload\RequestPayload;
use Stoakes\Kmip\Payload\RevocationReason;
use Stoakes\Kmip\Payload\RevokeRequestPayload;
use Stoakes\Kmip\Protocol\Attribute;
use Stoakes\Kmip\Protocol\Attributes;
use Stoakes\Kmip\Protocol\ProtocolVersion;
use Stoakes\Kmip\Protocol\BatchItem;
use Stoakes\Kmip\Protocol\RequestHeader;
use Stoakes\Kmip\Protocol\RequestMessage;
use Stoakes\Kmip\Protocol\ResponseMessage;
use Stoakes\Kmip\Protocol\TemplateAttribute;
use Stoakes\Kmip\Tag\Tag;

/**
 * Base class to interact with a KMIP server.
 * Feel free to extend it to add any missing method.
 */
class BaseClient
{
    private $socket;
    private $host;
    private $port;
    private $clientCert;
    private $clientKey;
    private $caCert;

    private ?RequestHeader $requestHeader;
    private ProtocolVersion $protocolVersion;

    public function __construct($host, $port, $clientCert, $clientKey, $caCert, string $version)
    {
        $this->host = $host;
        $this->port = $port;
        $this->clientCert = $clientCert;
        $this->clientKey = $clientKey;
        $this->caCert = $caCert;

        $this->protocolVersion = $this->protocolVersionFromString($version);

        $this->requestHeader = new RequestHeader(
            $this->protocolVersion,
            batchCount: 1
        );
    }

    public function connect()
    {
        // custom handler to transform ssl loading warning into exceptions
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }

            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
        $context = stream_context_create([
            'ssl' => [
                'local_cert' => $this->clientCert,
                'local_pk' => $this->clientKey,
                'cafile' => $this->caCert,
                'verify_peer' => true,
                //                'verify_peer_name' => true,
            ],
        ]);

        $this->socket = stream_socket_client(
            "tlsv1.2://{$this->host}:{$this->port}",
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$this->socket) {
            throw new \Exception("Failed to connect: $errstr ($errno)");
        }
        restore_error_handler();

    }

    public function disconnect()
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }

    public function sendRequest($requestPayload, Operation $operation): ResponseMessage
    {
        $request = new RequestMessage(
            $this->requestHeader,
            [
                BatchItem::new($operation, $requestPayload),
            ]
        );
        $ttlv = $this->encodeTTLV($request);
        fwrite($this->socket, $ttlv);
        $response = fread($this->socket, 4096);

        $decoder = new Decoder($response);

        return $decoder->decode(ResponseMessage::class);
    }


    private function encodeTTLV($data): string
    {
        $encoder = new Encoder();

        return $encoder->encode($data);
    }

    private function protocolVersionFromString(string $version): ProtocolVersion
    {
        return match ($version) {
            "2.0" => ProtocolVersion::new(2, 0),
            "1.0" => ProtocolVersion::new(1, 0),
            "1.1" => ProtocolVersion::new(1, 0),
            "1.2" => ProtocolVersion::new(1, 2),
            "1.4" => ProtocolVersion::new(1, 4),
            default => ProtocolVersion::new(2, 0),
        };
    }

    // should be moved to high level client later on.
    public function createSymmetricKey(CryptographicAlgorithm $algorithm, $length)
    {

        if ($this->protocolVersion->protocolVersionMajor >= 2) {
            $payload = new RequestPayload(
                ObjectType::SymmetricKey,
                null,
                new Attributes(
                    [
                        Tag::CryptographicAlgorithm->canonicalName() => $algorithm,
                        Tag::CryptographicLength->canonicalName() => $length,
                        Tag::CryptographicUsageMask->canonicalName() =>
                            (CryptographicUsageMask::Encrypt->value | CryptographicUsageMask::Decrypt->value),
                    ]
                )
            );
        } else {
            $payload = new RequestPayload(
                ObjectType::SymmetricKey,
                new TemplateAttribute(
                    [],
                    [
                    new Attribute(Tag::CryptographicAlgorithm->canonicalName(), $algorithm),
                    new Attribute(Tag::CryptographicLength->canonicalName(), $length),
                    new Attribute(
                        Tag::CryptographicUsageMask->canonicalName(),
                        (CryptographicUsageMask::Encrypt->value | CryptographicUsageMask::Decrypt->value)
                    ),
                ]
                )
            );
        }

        return $this->sendRequest($payload, Operation::Create);
    }

    public function activate($uniqueIdentifier)
    {
        $request = new GetRequestPayload(
            $uniqueIdentifier
        );

        return $this->sendRequest($request, Operation::Activate);
    }

    public function get(string $uniqueIdentifier)
    {
        $request = new GetRequestPayload(
            $uniqueIdentifier
        );

        return $this->sendRequest($request, Operation::Get);
    }

    public function encrypt($uniqueIdentifier, $data, $ivCounterNonce = null)
    {
        $request = [
            'uniqueIdentifier' => $uniqueIdentifier,
            'data' => base64_encode($data),
            'iv_counter_nonce' => $ivCounterNonce ? base64_encode($ivCounterNonce) : null,
        ];

        return $this->sendRequest($request, Operation::Encrypt);
    }

    public function decrypt($uniqueIdentifier, $data, $ivCounterNonce = null)
    {
        $request = [
            'uniqueIdentifier' => $uniqueIdentifier,
            'data' => base64_encode($data),
            'iv_counter_nonce' => $ivCounterNonce ? base64_encode($ivCounterNonce) : null,
        ];

        return $this->sendRequest($request, Operation::Decrypt);
    }

    public function revoke(string $keyId, RevocationReasonCode $code, ?string $reasonMessage = null, ?\DateTime $compromiseDate = null)
    {
        $request = new RevokeRequestPayload(
            $keyId,
            new RevocationReason($code, $reasonMessage)
        );

        return $this->sendRequest($request, Operation::Revoke);
    }

    public function destroy(string $keyId)
    {
        $request = new GetRequestPayload($keyId);

        return $this->sendRequest($request, Operation::Destroy);
    }
}
