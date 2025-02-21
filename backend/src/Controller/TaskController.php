<?php

namespace App\Controller;

use App\Entity\User;
use App\service\ResponseService;
use App\service\TaskService;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/user/{id<\d+>}', name: 'get_all-tasks', methods: ['GET'])]
    public function getAllTasks(
        int $id,
        EntityManagerInterface $entityManager,
    ): JsonResponse {
        try {
            $user = $entityManager->getRepository(User::class)->find($id);
            if (!$user) {
                return $this->responseService->notfoundResponse('User not found');
            }
            if (!$this->isGranted('view_tasks', $user)) {
                return $this->responseService->accessDeniedResponse('You can see only our tasks');
            }
            $tasks = $this->taskService->getAllTasks($user->getId());

            return $this->responseService->successResponse(message: 'successfully get All tasks', data: $tasks);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/completed/user/{id<\d+>}', name: 'get_completed_tasks', methods: ['GET'])]
    public function getCompletedTasks(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $user = $entityManager->getRepository(User::class)->find($id);
            if (!$user) {
                return $this->responseService->notfoundResponse('User not found');
            }
            if (!$this->isGranted('view_tasks', $user)) {
                return $this->responseService->accessDeniedResponse('You can see only our tasks');
            }

            $tasks = $this->taskService->getAllCompletedTasks($user->getId());

            return $this->responseService->successResponse(message: 'successfully get All completed tasks', data: $tasks);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/missed/user/{user_id<\d+>}', name : 'get_missed_tasks', methods: ['GET'])]
    public function getMissedTasks(int $user_id, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $user = $entityManager->getRepository(User::class)->find($user_id);
            if (!$user) {
                return $this->responseService->notfoundResponse('User not found');
            }
            if (!$this->isGranted('view_tasks', $user)) {
                return $this->responseService->accessDeniedResponse('You can see only our tasks');
            }
            $tasks = $this->taskService->getAllMissedTasks($user_id);

            return $this->responseService->successResponse(message: 'successfully get All missed tasks', data: $tasks);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/', name: 'create_task', methods: ['Post'])]
    public function addTask(Request $request): JsonResponse
    {
        try {
            $result = $this->taskService->createTask($request);
            if (isset($result['error'])) {
                return $this->responseService->errorResponse(
                    message: $result['error'],
                );
            }

            return $this->responseService->successResponse(
                message: 'task created successfully',
                statusCode: Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
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
                return $this->responseService->notfoundResponse(
                    message: 'task not found',
                );
            }

            return $this->responseService->successResponse(
                message: 'task retrieved successfully',
                data: $taskJson
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
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
                return $this->responseService->notfoundResponse(

                    message: 'task not found',

                );
            }
            $result = $this->taskService->updateTask($currentTask, $request->getContent());

            if (isset($result['error'])) {
                return $this->responseService->errorResponse(

                    message: $result['error'],
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->responseService->successResponse(
                message: 'task updated successfully',
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
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
                return $this->responseService->notfoundResponse(
                    message: 'task not found',
                );
            }
            $result = $this->taskService->patchTask($currentTask, json_decode($request->getContent(), true));

            if (isset($result['error'])) {
                return $this->responseService->errorResponse(
                    message: $result['error'],
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->responseService->successResponse(
                message: $result['success'],
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/{task_id<\d+>}', name: 'delete_task', methods: ['Delete'])]
    public function deleteTask(
        int $task_id,
    ): JsonResponse {
        try {
            $task = $this->taskService->getTask($task_id);
            if (!$task) {
                return $this->responseService->notfoundResponse(
                    message: 'task not found',
                );
            }

            $result = $this->taskService->deleteTask($task);

            return $this->responseService->successResponse(
                message: $result['success'],
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/user/{user_id<\d+>}', name : 'delete_all_tasks', methods : ['Delete'])]
    public function deleteAllTask(
        int $user_id,
        EntityManagerInterface $entityManager,
    ): JsonResponse {
        try {
            $user = $entityManager->getRepository(User::class)->find($user_id);
            if (!$user) {
                return $this->responseService->notfoundResponse('User not found');
            }
            if (!$this->isGranted('view_tasks', $user)) {
                return $this->responseService->accessDeniedResponse('You can see only our tasks');
            }
            $result = $this->taskService->deleteAllTasks($user_id);

            return $this->responseService->successResponse(
                message: $result['success'],
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }
}
