<?php

namespace App\Http\Controllers\Api;

use App\Brokers\SmsGlobalListMessagesBroker;
use App\Brokers\SmsGlobalSendSmsBroker;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function response;

class SmsGlobalController extends Controller
{


    /**
     * It sends an SMS for the user.
     */
    public function post_message(Request $request): JsonResponse
    {
        $this->validate($request, [
            'destination_number' => [
                'required',
                'string',
            ],
            'message'            => [
                'required',
                'string',
            ],
        ]);

        if (!$request->expectsJson()) {
            $body = [
                'message' => 'Json is needed',
            ];
            return response()->json($body)->setStatusCode(400);
        }

        $username = $request->getUser();
        $password = $request->getPassword();

        $broker = new SmsGlobalSendSmsBroker();
        $broker
            ->setApiKeyPublic($username)
            ->setApiKeySecret($password)
            ->addDestinationNumber($request->destination_number)
            ->setMessage($request->message)
            ->send();

        if ($broker->wasException()) {
            $body     = [
                'message' => $broker->getException()->getMessage(),
            ];
            $response = response()->json($body);

            if ($broker->wasAuthenticationException()) {
                $response->setStatusCode(403);
            } else {
                $response->setStatusCode(400);
            }

            return $response;
        }

        return response()->json([])->setStatusCode(200);
    }


    /**
     * It lists all the messages sent by the user.
     */
    public function get_message(Request $request): JsonResponse
    {
        $this->validate($request, [
            'destination_number' => [
                'required',
                'string',
            ],
        ]);

        if (!$request->expectsJson()) {

            $body = [
                'message' => 'Json is needed',
            ];
            return response()->json($body)->setStatusCode(400);
        }

        $password = $request->getPassword();
        $username = $request->getUser();

        $broker = new SmsGlobalListMessagesBroker();
        $broker
            ->setApiKeyPublic($username)
            ->setApiKeySecret($password)
            ->requestMessages();

        if ($broker->wasException()) {
            $body     = [
                'message' => $broker->getException()->getMessage(),
            ];
            $response = response()->json($body);

            if ($broker->wasAuthenticationException()) {
                $response->setStatusCode(403);
            } else {
                $response->setStatusCode(400);
            }

            return $response;
        }

        return response()->json($broker->getResponse())->setStatusCode(200);
    }


    /**
     * It displays a Swagger OpenAPI documentation of the `/api` endpoints. 
     */
    public function get_docs(Request $request): string
    {
        return ' under construction ';
    }


}
