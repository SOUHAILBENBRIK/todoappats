<?php

namespace App\service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseService
{
    public function response(
        string $status,
        string $message,
        int $statusCode,
        $data = null,
    ): JsonResponse {
        if (null === $data) {
            $data = new JsonResponse(
                [
                    'status' => $status,
                    'message' => $message,
                ],
                $statusCode, );
        }

        return new JsonResponse(
            [
                'status' => $status,
                'message' => $message,
                'data' => $data],
            $statusCode,
        );
    }
}
