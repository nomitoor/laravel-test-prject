<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function successResponse($data, $status = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], $status);
    }

    public function errorResponse($message, $status)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }

    public function notFound()
    {
        return response()->json([
            'status' => 'not_found',
            'message' => 'Reqested data not found!'
        ], 404);
    }
}
