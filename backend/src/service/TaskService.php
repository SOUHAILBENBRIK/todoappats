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

    public function createTask(Request $request, User $user): array
    {
        // Extract data directly from form fields
        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $statusId = $request->request->get('status');
        $priorityId = $request->request->get('priority');

        $deadline = $request->request->get('deadline');

        // 🔹 Find Status & Priority Entities
        $status = $this->manager->getRepository(Status::class)->find($statusId);
        if (!$status) {
            return ['error' => 'Invalid status'];
        }

        $priority = $this->manager->getRepository(Priority::class)->find($priorityId);
        if (!$priority) {
            return ['error' => 'Invalid priority'];
        }

        // Convert Date Strings to `DateTimeImmutable`
        try {

            $deadlineDate = new \DateTimeImmutable($deadline);
        } catch (\Exception $e) {
            return ['error' => 'Invalid date format'];
        }

        // Handle Image Upload
        $imageFile = $request->files->get('picture');
        $imagePath = null;

        if ($imageFile) {
            $uploadDir = __DIR__.'/../../public/uploads/tasks/';
            $fileName = uniqid().'.'.$imageFile->guessExtension();

            $imageFile->move($uploadDir, $fileName);
            $imagePath = '/uploads/tasks/'.$fileName;
        }

        // Create Task Object
        $task = new Task();
        $task->setTitle($title);
        $task->setDescription($description);
        $task->setStatus($status);
        $task->setPriority($priority);
        $task->setCreatedAt(new \DateTimeImmutable());
        $task->setDeadline($deadlineDate);
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

    public function updateTask(Task $task, string $jsonContent): array
    {
        $this->serializer->deserialize($jsonContent, Task::class, 'json', ['object_to_populate' => $task]);
        $errors = $this->validator->validate($task);

        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }

        $this->manager->flush();

        return ['success' => 'Task updated successfully'];
    }

    public function patchTask(Task $task, array $data): array
    {
        if (isset($data['status'])) {
            $task->setStatus($data['status']);
        }
        if (isset($data['priority'])) {
            $task->setStatus($data['priority']);
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
}
