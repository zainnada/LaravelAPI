<?php

namespace App\Traits;
trait ApiResponses
{
    /*
    protected function successResponse($data, $code = 200){
        return response()->json($data, $code);
    }
    protected function errorResponse($message, $code){
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
    */
    protected function ok($message, $data=[])
    {
        return $this->success($message, $data, 200);
    }

    protected function success($message, $data, $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => $statusCode
        ], $statusCode);
    }

    protected function error($message, $statusCode)
    {
        return response()->json([
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);
    }
}
