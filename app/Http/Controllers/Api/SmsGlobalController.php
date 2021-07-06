<?php

namespace App\Http\Controllers\Api;

use App\Brokers\SmsGlobalListMessagesBroker;
use App\Brokers\SmsGlobalSendSmsBroker;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function app;
use function response;

/**
 * @OA\Info(
 *      version="0.1",
 *      title="SmsGlobal API", 
 *      description="Swagger OpenApi description",
 * )
 * 
 * @OA\Server(
 *      url="http://sms.test/api",
 *      description="Test API Server"
 * )
 */
class SmsGlobalController extends Controller
{


    /**
     * @OA\Post(
     *      path="/message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SendMessageRequest")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="send an SMS to a user with success"
     *      ),
     *      @OA\Response(
     *          response="400", 
     *          description="handled error"
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="authentication error"
     *      ),
     *      @OA\Response(
     *          response="403", 
     *          description="authorization error"
     *      ),
     *      @OA\Response(
     *          response="422", 
     *          description="validation error"
     *      ), 
     * 
     * )
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
        if (is_null($username) || is_null($password)) {
            $body = [
                'message' => 'Basic auth is needed',
            ];
            return response()->json($body)->setStatusCode(401);
        }

        /* @var $broker SmsGlobalSendSmsBroker */
        $broker = app(SmsGlobalSendSmsBroker::class);
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
     * @OA\Get(
     *      path="/message",
     *      @OA\Parameter(
     *          name="destination_number",
     *          in="query",
     *          required=true,
     *          description="destination number",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="list all the messages sent by a user with success"
     *      ),
     *      @OA\Response(
     *          response="400", 
     *          description="handled error"
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="authentication error"
     *      ),
     *      @OA\Response(
     *          response="403", 
     *          description="authorization error"
     *      ),
     *      @OA\Response(
     *          response="422", 
     *          description="validation error"
     *      ),
     * )
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
        if (is_null($username) || is_null($password)) {
            $body = [
                'message' => 'Basic auth is needed',
            ];
            return response()->json($body)->setStatusCode(401);
        }

        $broker = new SmsGlobalListMessagesBroker();
        $broker
            ->setApiKeyPublic($username)
            ->setApiKeySecret($password)
            ->setDestinationNumber($request->destination_number)
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


}
