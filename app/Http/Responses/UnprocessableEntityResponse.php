<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class UnprocessableEntityResponse extends JsonResponse
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
        int $status     = 422,
        array $headers  = [],
        int $options    = 0,
        bool $json      = false
    ) {
        if (empty($message)) {
            $message = __('Unprocessable Entity.');
        }

        $data = [
            'success' => false,
            'status' => $status,
            'message' => $message,
            'errors' => $data,
        ];

        parent::__construct($data, $status, $headers, $options, $json);
    }
}