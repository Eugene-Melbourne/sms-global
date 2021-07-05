<?php

/**
 * @OA\Schema(
 *      title="Get Messages request",
 *      description="Get Messages request body data",
 *      type="object",
 *      required={"destination_number"}
 * )
 */
class GetMessagesRequest
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

}
