<?php

namespace App\Http\Utils;

class ApiResponse
{
    public static function format(array $data, $status, $headers)
    {
        return response()->json([
            'success' => $status == 200,
            'data' => $data
        ],  $status, $headers);
    }
}
