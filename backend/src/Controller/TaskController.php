<?php

namespace App\Controller;

use App\service\ResponseService;
use App\service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/tasks')]
final class TaskController extends AbstractController
{
    private TaskService $taskService;
    private ResponseService $responseService;

    public function __construct(TaskService $taskService, ResponseService $responseService)
    {
        $this->taskService = $taskService;
        $this->responseService = $responseService;
    }

    #[Route('/user/{user_id<\d+>}', name: 'get_all-tasks', methods: ['GET'])]
    public function getAllTasks(
        int $user_id,
    ): JsonResponse {
        try {
            $tasks = $this->taskService->getAllTasks($user_id);

            return $this->responseService->response(status: 'success', message: 'successfully get All tasks', statusCode: Response::HTTP_OK, data: $tasks);
        } catch (\Exception $e) {
            return $this->responseService->response(
                status: 'error',
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/', name: 'create_task', methods: ['Post'])]
    public function addTask(Request $request): JsonResponse
    {
        try {
            $result = $this->taskService->createTask($request->getContent());
            if (isset($result['error'])) {
                return $this->responseService->response(
                    status: 'error',
                    message: $result['error'],
                    statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            return $this->responseService->response(
                status: 'success',
                message: 'task created successfully',
                statusCode: Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->responseService->response(
                status: 'error',
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/{task_id<\d+>}', name: 'get_task', methods: ['GET'])]
    public function getTask(
        int $task_id,
        SerializerInterface $serializer,
    ): JsonResponse {
        try {
            $task = $this->taskService->getTask($task_id);
            $taskJson = $serializer->serialize($task, 'json', ['groups' => 'task:read', 'ignored_attributes' => ['user']]);

            if (!$task) {
                return $this->responseService->response(
                    status: 'error',
                    message: 'task not found',
                    statusCode: Response::HTTP_NOT_FOUND
                );
            }

            return $this->responseService->response(
                status: 'success',
                message: 'task retrieved successfully',
                statusCode: Response::HTTP_OK,
                data: $taskJson
            );
        } catch (\Exception $e) {
            return $this->responseService->response(
                status: 'error',
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{task_id<\d+>}', name : 'update_task', methods: ['Put'])]
    public function updateTask(
        Request $request,
        int $task_id): JsonResponse
    {
        try {
            $currentTask = $this->taskService->getTask($task_id);
            if (!$currentTask) {
                return $this->responseService->response(
                    status: 'error',
                    message: 'task not found',
                    statusCode: Response::HTTP_NOT_FOUND
                );
            }
            $result = $this->taskService->updateTask($currentTask, $request->getContent());

            if (isset($result['error'])) {
                return $this->responseService->response(
                    status: 'error',
                    message: $result['error'],
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->responseService->response(
                status: 'success',
                message: 'task updated successfully',
                statusCode: Response::HTTP_OK,
            );
        } catch (\Exception $e) {
            return $this->responseService->response(
                status: 'error',
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/{task_id<\d+>}', name : 'update_part_of_task', methods: ['PATCH'])]
    public function updatePartOfTask(
        Request $request,
        int $task_id,
    ): JsonResponse {
        try {
            $currentTask = $this->taskService->getTask($task_id);
            if (!$currentTask) {
                return $this->responseService->response(
                    status: 'error',
                    message: 'task not found',
                    statusCode: Response::HTTP_NOT_FOUND
                );
            }
            $result = $this->taskService->patchTask($currentTask, json_decode($request->getContent(), true));

            if (isset($result['error'])) {
                return $this->responseService->response(
                    status: 'error',
                    message: $result['error'],
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->responseService->response(
                status: 'success',
                message: $result['success'],
                statusCode: Response::HTTP_OK,
            );
        } catch (\Exception $e) {
            return $this->responseService->response(
                status: 'error',
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/{task_id<\d+>}', name: 'delete_task', methods: ['Delete'])]
    public function deleteTask(
        int $task_id,
    ): JsonResponse {
        try {
            $task = $this->taskService->getTask($task_id);
            if (!$task) {
                return $this->responseService->response(
                    status: 'error',
                    message: 'task not found',
                    statusCode: Response::HTTP_NOT_FOUND
                );
            }

            $result = $this->taskService->deleteTask($task);

            return $this->responseService->response(
                status: 'success',
                message: $result['success'],
                statusCode: Response::HTTP_OK,
            );
        } catch (\Exception $e) {
            return $this->responseService->response(
                status: 'error',
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/user/{user_id<\d+>}', name : 'delete_all_tasks', methods : ['Delete'])]
    public function deleteAllTask(
        int $user_id,
    ): JsonResponse {
        try {
            $tasks = $this->taskService->getAllTasks($user_id);
            $result = $this->taskService->deleteAllTasks($tasks);

            return $this->responseService->response(
                status: 'success',
                message: $result['success'],
                statusCode: Response::HTTP_OK,
            );
        } catch (\Exception $e) {
            return $this->responseService->response(
                status: 'error',
                message: $e->getMessage(),
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
