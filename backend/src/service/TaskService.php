<?php

namespace App\service;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $tasks = $this->taskRepository->findBy(['user' => $userId, 'completed' => true]);

        return $this->serializer->serialize($tasks, 'json', ['groups' => ['task:read'], 'ignored_attributes' => ['user']]);
    }

    public function getAllMissedTasks(int $userId): string
    {
        $tasks = $this->taskRepository->findBy([
            'user' => $userId,
            'completed' => false,
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

    public function createTask(string $jsonContent): array
    {
        $data = json_decode($jsonContent, true);
        $user = $this->manager->getRepository(User::class)->find($data['user']);
        if (!$user) {
            return ['error' => 'User not found'];
        }

        $task = $this->serializer->deserialize($jsonContent, Task::class, 'json', ['ignored_attributes' => ['user']]);
        $task->setUser($user);

        $errors = $this->validator->validate($task);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }

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
        if (isset($data['completed'])) {
            $task->setCompleted($data['completed']);
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
