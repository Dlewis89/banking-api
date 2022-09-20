<?php

namespace App\Macros;

use Illuminate\Support\Facades\Response;

class ResponseMacro
{

    public function success()
    {
        return function (array $data = [], int $status = 200) {
            $response_format = (object) [
                "status" => $status,
                "data" => (object) $data
            ];
            return Response::json($response_format, $status);
        };
    }

    public function errorResponse()
    {
        return function (string $message, int $status = 500) {
            $response_format = (object) [
                "status" => $status,
                "error" => $message
            ];
            return Response::json($response_format, $status);
        };
    }
}
