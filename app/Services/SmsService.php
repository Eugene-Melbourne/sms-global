<?php

namespace App\Services;

use SMSGlobal\Resource\Base;

class SmsService extends Base
{

    private $resourceUri = '/sms';


    public function getMessages(string $destinationNumber): array
    {
        $uri = $this->prepareApiUri($this->resourceUri);

        $payload = [
            "destination" => $destinationNumber,
            "origin"      => ''
        ];

        $jsonPayload = json_encode($payload, JSON_FORCE_OBJECT);

        $this->lastResponse = $this->doCall('GET', $this->host . $uri, [
            'body'    => (string) $jsonPayload,
            'headers' => [
                'Authorization' => $this->credentials->getAuthorizationHeader('GET', $uri, $this->domain),
                'user-agent'    => $this->userAgent,
                'content-type'  => 'application/json'
            ]
        ]);

        return $this->getJsonDecode($this->lastResponse->getBody()->getContents());
    }


}
