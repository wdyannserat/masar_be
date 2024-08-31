<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ApiResponser
{

    protected function successResponse($data = null,  $message = null, $object = null, $code = 200, $token = null)
    {
        if (request()->header('system') == 'web') {
            return response()->json([
                'status' => 'Success',
                'message' => isset($message) ? __('messages.' . $message, ['object' => __('objects.' . $object)]) : null,
                'data' => $data,
                'token' => $token,
                'returnedCode' => $code
            ], $code);
        }

        return response()->json([
            'status' => 'Success',
            'message' => isset($message) ? __('messages.' . $message, ['object' => __('objects.' . $object)]) : null,
            'data' => $data,
            'returnedCode' => $code
        ], $code, $token ? [
            'Authorization' => $token
        ] : []);
    }

    protected function errorResponse($message = null, $object = null, $code = 500, $data = null)
    {
        return response()->json([
            'status' => 'Error',
            'message' => isset($message) ? __('messages.' . $message, ['object' => __('objects.' . $object)]) : null,
            'data' => $data,
            'returnedCode' => $code
        ], $code);
    }
}
