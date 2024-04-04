<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class SuccessResponse extends JsonResponse
{
     /* 
     * Constructor
     *
     * @param mixed  $data    Data
     * @param string $message Message
     * @param int    $status  Http status
     * @param array  $headers Headers
     * @param int    $options Json options
     * @param bool   $json    Is already json string
     */
    public function __construct(
        mixed $data     = [],
        string $message = '',
        int $status     = 200,
        array $headers  = [],
        int $options    = 0,
        bool $json      = false
    ) {
        if (empty($message)) {
            $message = __('Successfull operation.');
        }

        $data = [
            'success' => true,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        parent::__construct($data, $status, $headers, $options, $json);
    }
}