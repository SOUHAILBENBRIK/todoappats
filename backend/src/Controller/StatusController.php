<?php

namespace App\Controller;

use App\service\PriorityService;
use App\service\ResponseService;
use App\service\StatusService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StatusController extends AbstractController
{
    private StatusService $statusService;
    private ResponseService $responseService;

    public function __construct(
        StatusService $statusService,
        ResponseService $responseService,
    ) {
        $this->statusService = $statusService;
        $this->responseService = $responseService;
    }

    #[Route('/user/{user_id<\d+>}', name : 'get_all_status', methods: ['GET'])]
    public function getAllStatus(int $userId): JsonResponse
    {
        try {
            $statusList = $this->statusService->getStatusList($userId);

            return $this->responseService->successResponse(message: 'successfully get All status', data: $statusList);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }

    #[Route('/{status_id<\d+>}', name : 'get_status', methods: ['GET'])]
    public function getStatus(int $statusId): JsonResponse
    {
        try {
            $status = $this->statusService->getStatus($statusId);

            return $this->responseService->successResponse(message: 'successfully get  status', data: $status);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }

    #[Route('/', name : 'create_status', methods: ['POST'])]
    public function createStatus(Request $request): JsonResponse
    {
        try {
            $response = $this->statusService->createCustomStatus($request);
            if (isset($result['error'])) {
                return $this->responseService->errorResponse(
                    message: $result['error'],
                );
            }

            return $this->responseService->successResponse(message: 'Status created successfully', data: $response['success']);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }

    #[Route('/{status_id<\d+>}', name : 'update_status', methods: ['PUT'])]
    public function updateStatus(int $statusId, Request $request): JsonResponse
    {
        try {
            $currentStatus = $this->statusService->getStatus($statusId);
            if (!$currentStatus) {
                return $this->responseService->notfoundResponse(
                    message: 'Status not found',
                );
            }
            $result = $this->statusService->updateCustomStatus($statusId, $request->getContent());

            if (isset($result['error'])) {
                return $this->responseService->errorResponse(
                    message: $result['error'],
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->responseService->successResponse(
                message: 'status updated successfully',
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/{status_id<\d+>}', name : 'delete_status', methods: ['DELETE'])]
    public function deleteStatus(int $statusId): JsonResponse
    {
        try {
            $status = $this->statusService->getStatus($statusId);

            return $this->responseService->successResponse(message: 'successfully get  status', data: $status);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }
}
