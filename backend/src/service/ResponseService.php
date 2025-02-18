<?php

namespace App\service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    public function successResponse(
        string $message,
        int $statusCode = Response::HTTP_OK,
        $data = null,
    ): JsonResponse {
        if (null === $data) {
            return new JsonResponse(
                [
                    'status' => 'success',
                    'message' => $message,
                ], $statusCode, );
        }

        return new JsonResponse(
            [
                'status' => 'success',
                'message' => $message,
                'data' => $data],
            $statusCode,
        );
    }

    public function notfoundResponse(string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'message' => $message,
            ],
            Response::HTTP_NOT_FOUND, );
    }

    public function accessDeniedResponse(string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'message' => $message,
            ],
            Response::HTTP_FORBIDDEN);
    }

    public function errorResponse($message, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'message' => $message,
            ],
            $statusCode);
    }
}
