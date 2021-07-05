<?php

/**
 * @OA\Schema(
 *      title="Send Message request",
 *      description="Send Message request body data",
 *      type="object",
 *      required={"destination_number", "message"}
 * )
 */
class SendMessageRequest
{

    /**
     * @OA\Property(
     *      title="destination_number",
     *      description="destination number",
     *      example="+61000000000"
     * )
     *
     * @var string
     */
    public $destination_number;

    /**
     * @OA\Property(
     *      title="message",
     *      description="message",
     *      example="This is an example message."
     * )
     *
     * @var string
     */
    public $message;

}
