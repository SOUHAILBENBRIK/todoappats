<?php

namespace App\Controller;

use App\service\PriorityService;
use App\service\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/priority')]
final class PriorityController extends AbstractController
{
    private PriorityService $priorityService;
    private ResponseService $responseService;

    public function __construct(
        PriorityService $priorityService,
        ResponseService $responseService,
    ) {
        $this->priorityService = $priorityService;
        $this->responseService = $responseService;
    }

    #[Route('/user/{user_id<\d+>}', name : 'get_all_priority', methods: ['GET'])]
    public function getAllPriority(int $userId): JsonResponse
    {
        try {
            $priorities = $this->priorityService->getPriorities($userId);

            return $this->responseService->successResponse(message: 'successfully get All Priorities', data: $priorities);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }

    #[Route('/{priority_id<\d+>}', name : 'get_priority', methods: ['GET'])]
    public function getPriority(int $priorityId): JsonResponse
    {
        try {
            $priority = $this->priorityService->getPriority($priorityId);

            return $this->responseService->successResponse(message: 'successfully get  priority', data: $priority);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }

    #[Route('/', name : 'create_priority', methods: ['POST'])]
    public function createPriority(Request $request): JsonResponse
    {
        try {
            $response = $this->priorityService->createCustomPriority($request);
            if (isset($result['error'])) {
                return $this->responseService->errorResponse(
                    message: $result['error'],
                );
            }

            return $this->responseService->successResponse(message: 'Priority created successfully', data: $response['success']);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }

    #[Route('/{priority_id<\d+>}', name : 'update_priority', methods: ['PUT'])]
    public function updatePriority(int $priorityId, Request $request): JsonResponse
    {
        try {
            $currentPriority = $this->priorityService->getPriority($priorityId);
            if (!$currentPriority) {
                return $this->responseService->notfoundResponse(
                    message: 'Priority not found',
                );
            }
            $result = $this->priorityService->updateCustomPriority($priorityId, $request->getContent());

            if (isset($result['error'])) {
                return $this->responseService->errorResponse(
                    message: $result['error'],
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->responseService->successResponse(
                message: 'priority updated successfully',
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/{priority_id<\d+>}', name : 'delete_priority', methods: ['DELETE'])]
    public function deletePriority(int $priorityId): JsonResponse
    {
        try {
            $priority = $this->priorityService->getPriority($priorityId);

            return $this->responseService->successResponse(message: 'successfully get  priority', data: $priority);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message : $e->getMessage(),
            );
        }
    }
}
