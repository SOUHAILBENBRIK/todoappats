<?php

namespace App\service;

use App\Entity\Priority;
use App\Entity\Status;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $manager,
        private StatusService $statusService,
        private PriorityService $priorityService,
    ) {
    }

    public function getAllTasks(int $userId): string
    {
        $tasks = $this->taskRepository->findBy(['user' => $userId]);

        return $this->serializer->serialize($tasks, 'json', ['groups' => ['task:read'], 'ignored_attributes' => ['user']]);
    }

    public function getAllCompletedTasks(int $userId): string
    {
        $qb = $this->taskRepository->createQueryBuilder('t')
            ->where('t.user = :userId')
            ->andWhere('t.completedAt IS NOT NULL')
            ->setParameter('userId', $userId);

        $tasks = $qb->getQuery()->getResult();

        return $this->serializer->serialize($tasks, 'json', [
            'groups' => ['task:read'],
            'ignored_attributes' => ['user'],
        ]);
    }

    public function getAllMissedTasks(int $userId): string
    {
        $tasks = $this->taskRepository->findBy([
            'user' => $userId,
            'completedAt' => null,
        ]); // return uncompleted tasks for user x

        $filteredTasks = array_filter($tasks, function ($task) {
            return null != $task->getDeadline() && $task->getDeadline() > new \DateTimeImmutable();
        }); // check deadline

        return $this->serializer->serialize($filteredTasks, 'json', ['groups' => ['task:read'], 'ignored_attributes' => ['user']]);
    }

    public function getTask(int $taskId): ?Task
    {
        return $this->taskRepository->find($taskId);
    }

    private function extractAndValidateTaskData(Request $request): array
    {
        // Extract data from request
        $data = $request->request->all();

        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $statusId = $data['status'] ?? null;
        $priorityId = $data['priority'] ?? null;
        $deadline = $data['deadline'] ?? null;

        // 🔹 Validate Status & Priority
        $status = $this->statusService->getStatus($statusId);
        if (!$status) {
            return ['error' => 'Invalid status'];
        }

        $priority = $this->priorityService->getPriority($priorityId);
        if (!$priority) {
            return ['error' => 'Invalid priority'];
        }
        try {
            $deadlineDate = new \DateTimeImmutable($deadline);
        } catch (\Exception $e) {
            return ['error' => 'Invalid date format'];
        }

        return [
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'priority' => $priority,
            'deadline' => $deadlineDate,
        ];
    }

    public function createTask(Request $request, User $user): array
    {
        $data = $this->extractAndValidateTaskData($request);

        if (isset($data['error'])) {
            return ['error' => $data['error']];
        }

        $imagePath = $this->handleImageUpload($request);

        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setStatus($data['status']);
        $task->setPriority($data['priority']);
        $task->setCreatedAt(new \DateTimeImmutable());
        $task->setDeadline($data['deadline']);
        $task->setUser($user);
        if ($imagePath) {
            $task->setPicture($imagePath);
        }

        // Validate Task
        $errors = $this->validator->validate($task);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }

        // Save Task
        $this->manager->persist($task);
        $this->manager->flush();

        return ['success' => 'Task added successfully'];
    }

    private function handleImageUpload(Request $request): ?string
    {
        $imageFile = $request->files->get('picture');
        if ($imageFile) {
            $uploadDir = __DIR__.'/../../public/uploads/tasks/';
            $fileName = uniqid().'.'.$imageFile->guessExtension();
            $imageFile->move($uploadDir, $fileName);

            return '/uploads/tasks/'.$fileName;
        }

        return null;
    }

    public function updateTask(Task $task, Request $request): array
    {
        $data = $this->extractAndValidateTaskData($request);

        if (isset($data['error'])) {
            return ['error' => $data['error']];
        }

        $imageFile = $request->files->get('picture');
        if ($imageFile) {
            $uploadDir = __DIR__.'/../../public/uploads/tasks/';
            $fileName = uniqid().'.'.$imageFile->guessExtension();

            $imageFile->move($uploadDir, $fileName);
            $task->setPicture('/uploads/tasks/'.$fileName);
        }

        // Update Task Properties (Only if Provided)
        if ($data['title']) {
            $task->setTitle($data['title']);
        }
        if ($data['description']) {
            $task->setDescription($data['description']);
        }
        $task->setStatus($data['status']);
        $task->setPriority($data['priority']);
        if ($data['deadline']) {
            $task->setDeadline($data['deadline']);
        }

        // Validate Task
        $errors = $this->validator->validate($task);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }

        // Save Changes
        $this->manager->flush();

        return ['success' => 'Task updated successfully'];
    }

    public function patchTask(Task $task, array $data): array
    {
        if (isset($data['status'])) {
            $status = $this->statusService->getStatus($data['status']);
            $task->setStatus($status);
        }
        if (isset($data['priority'])) {
            $priority = $this->priorityService->getPriority($data['priority']);
            $task->setPriority($priority);
        }

        $this->manager->flush();

        return ['success' => 'Task updated successfully'];
    }

    public function deleteTask(Task $task): array
    {
        $this->manager->remove($task);
        $this->manager->flush();

        return ['success' => 'Task deleted successfully'];
    }

    public function deleteAllTasks(int $userId): array
    {
        $tasks = $this->taskRepository->findBy(['user' => $userId]);
        foreach ($tasks as $task) {
            $this->manager->remove($task);
        }
        $this->manager->flush();

        return ['success' => 'All tasks deleted successfully'];
    }

    public function getStatistics(int $userId): array
    {
        $totalTasks = $this->taskRepository->countByUser($userId);
        if (0 === $totalTasks) {
            return [
                'completedTask' => 0,
                'pendingTask' => 0,
                'inProgressTask' => 0,
                'missedTask' => 0,
            ];
        }

        $completedTask = ($this->taskRepository->countByStatus('Completed', $userId) / $totalTasks) * 100;
        $pendingTask = ($this->taskRepository->countByStatus('Pending', $userId) / $totalTasks) * 100;
        $inProgressTask = ($this->taskRepository->countByStatus('In Progress', $userId) / $totalTasks) * 100;
        $missedTask = ($this->taskRepository->countByStatus('Missed', $userId) / $totalTasks) * 100;

        return [
            'completedTask' => round($completedTask, 2),
            'pendingTask' => round($pendingTask, 2),
            'inProgressTask' => round($inProgressTask, 2),
            'missedTask' => round($missedTask, 2),
        ];
    }
}
