<?php

namespace App\Brokers;

use Exception;
use SMSGlobal\Credentials;
use SMSGlobal\Exceptions\AuthenticationException;
use SMSGlobal\Exceptions\PaymentRequiredException;
use SMSGlobal\Resource\Sms;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @property string     $username
 * @property string     $password
 * @property string     $destinationNumber
 * @property array      $response
 * @property Exception  $exception
 */
class SmsGlobalListMessagesBroker
{

    private $username;
    private $password;
    private $response;
    private $exception;
    private $destinationNumber;


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
        Credentials::set($this->username, $this->password);

        $sms = new Sms();

        $payload = [
            "destinations" => $this->destinationNumber,
        ];

        try {
            $this->response = $sms->rawPayload($payload);
            //logger($this->response);
            //logger($this->response['messages']);
            //logger(get_class($this->response['messages']));
        } catch (Exception $e) {
            $this->exception = $e;
            //logger($e->getMessage());
            //logger(get_class($e));
        }

        return $this;
    }


    public function wasException(): bool
    {
        return !is_null($this->exception);
    }


    public function wasAuthenticationException(): bool
    {
        return get_class($this->exception) === AuthenticationException::class;
    }


    public function wasPaymentRequiredException(): bool
    {
        return get_class($this->exception) === PaymentRequiredException::class;
    }


    public function wasResourceNotFoundException(): bool
    {
        return get_class($this->exception) === ResourceNotFoundException::class;
    }


    public function getException(): Exception
    {
        return $this->exception;
    }


    public function getResponse(): array
    {
        return $this->response;
    }


}
