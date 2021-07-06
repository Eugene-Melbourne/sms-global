<?php

namespace App\Brokers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use function json_encode;

/**
 * @property string     $username
 * @property string     $password
 * @property string     $destinationNumber
 * @property array      $response
 * @property Exception  $exception
 */
class SmsGlobalListMessagesRawBroker
{

    private $username;
    private $password;
    private $destinationNumber;
    private $response;
    private $exception;


    public function setApiKeyPublic(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function setApiKeySecret(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function setDestinationNumber(string $destinationNumber): self
    {
        $this->destinationNumber = $destinationNumber;

        return $this;
    }


    public function requestMessages(): self
    {
        $uri                 = '/v2/sms';
        $domain              = 'api.smsglobal.com';
        $method              = 'GET';
        $timestamp           = time();
        $nonce               = md5(microtime() . mt_rand());
        $port                = 443;
        $string              = array($timestamp, $nonce, $method, $uri, $domain, $port, '');
        $string              = sprintf("%s\n", implode("\n", $string));
        $apiSecretKey        = $this->password;
        $hashAlgorithm       = 'sha256';
        $hash                = hash_hmac($hashAlgorithm, $string, $apiSecretKey, true);
        $hash                = base64_encode($hash);
        $header              = 'MAC id="%s", ts="%s", nonce="%s", mac="%s"';
        $apiKey              = $this->username;
        $authorizationHeader = sprintf($header, $apiKey, $timestamp, $nonce, $hash);

        $client = new Client();

        $payload       = [
            "destination" => $this->destinationNumber,
            "origin"      => ''
        ];
        $jsonPayload   = json_encode($payload, JSON_FORCE_OBJECT);
        $url           = 'https://' . $domain . $uri;
        $clientVersion = '1.0.4';
        $userAgent     = "SMSGlobal-SDK/v2 Version/" . $clientVersion . " PHP/" . PHP_VERSION . " (" . PHP_OS . "; " . OPENSSL_VERSION_TEXT . ")";
        $options       = [
            'body'    => $jsonPayload,
            'headers' => [
                'Authorization' => $authorizationHeader,
                'user-agent'    => $userAgent,
                'content-type'  => 'application/json',
            ]
        ];

        try {
            $this->response = $client->request($method, $url, $options);
            //logger($this->response->getBody());
            //logger($this->response->getHeaders());
        } catch (GuzzleException $e) {
            $this->exception = $e;
            //logger($e->getMessage());
        }

        return $this;
    }


    public function wasException(): bool
    {
        return !is_null($this->exception);
    }


    public function wasAuthenticationException(): bool
    {
        return $this->exception->getCode() == 403;
    }


    public function wasPaymentRequiredException(): bool
    {
        return $this->exception->getCode() == 402;
    }


    public function wasResourceNotFoundException(): bool
    {
        return $this->exception->getCode() == 404;
    }


    public function getException(): Exception
    {
        return $this->exception;
    }


    public function getResponse(): Response
    {
        return $this->response;
    }


}
