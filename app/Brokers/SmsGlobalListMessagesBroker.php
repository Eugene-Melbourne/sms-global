<?php

namespace App\Brokers;

use App\Services\SmsService;
use Exception;
use SMSGlobal\Credentials;
use SMSGlobal\Exceptions\AuthenticationException;
use SMSGlobal\Exceptions\PaymentRequiredException;
use SMSGlobal\Exceptions\ResourceNotFoundException;

/**
 * @property string     $username
 * @property string     $password
 * @property array      $destinationNumbers
 * @property array      $response
 * @property Exception  $exception
 */
class SmsGlobalListMessagesBroker
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
        Credentials::set($this->username, $this->password);
        $sms = new SmsService();

        try {
            $this->response = $sms->getMessages($this->destinationNumber);
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


    public function getResponse(): array
    {
        return $this->response;
    }


}
