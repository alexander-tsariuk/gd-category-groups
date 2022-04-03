<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Успешный ответ
     * @param array $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(array $response = array()): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $response
        ]);
    }

    /**
     * Ответ с ошибкой
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'code' => 500,
            'message' => $message
        ]);
    }

    /**
     * Ответ с ошибкой валидации
     * @param \Illuminate\Support\MessageBag $validationMessages
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationErrorResponse(\Illuminate\Support\MessageBag $validationMessages): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'code' => 422,
            'message' => "Validation Errors!",
            'errors' => $validationMessages
        ]);
    }
}
