<?php

namespace App\Brokers;

use Exception;
use SMSGlobal\Credentials;
use SMSGlobal\Exceptions\AuthenticationException;
use SMSGlobal\Exceptions\PaymentRequiredException;
use SMSGlobal\Exceptions\ResourceNotFoundException;
use SMSGlobal\Resource\Sms;

/**
 * @property string     $username
 * @property string     $password
 * @property string     $message
 * @property array      $destinationNumbers
 * @property array      $response
 * @property Exception  $exception
 */
class SmsGlobalSendSmsBroker
{

    private $message;
    private $username;
    private $password;
    private $destinationNumbers = [];
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


    public function addDestinationNumber(string $destinationNumber): self
    {
        $this->destinationNumbers[] = $destinationNumber;

        return $this;
    }


    public function setDestinationNumbers(array $destinationNumbers): self
    {
        $this->destinationNumbers = $destinationNumbers;

        return $this;
    }


    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }


    public function send(): self
    {
        Credentials::set($this->username, $this->password);
        $sms = new Sms();

        try {
            $this->response = $sms->sendToMultiple($this->destinationNumbers, $this->message);
            //logger($this->response);
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


    public function getResponseStatus(): string
    {
        return $this->response['messages'][0]['status'];
    }


}
