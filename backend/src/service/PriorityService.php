<?php

namespace App\service;

use App\Entity\Priority;
use App\Entity\User;
use App\Repository\PriorityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriorityService
{
    public function __construct(
        private PriorityRepository $priorityRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) {
    }

    public function getPriorities(int $userId): string
    {
        $priorities = $this->priorityRepository->findBy(['user' => [$userId, null]]);

        return $this->serializer->serialize($priorities, 'json', ['groups' => ['priority:read']]);
    }

    public function getPriority(int $priorityId): ?Priority
    {
        return $this->priorityRepository->find($priorityId);
    }

    public function createCustomPriority(Request $request, User $user): array
    {
        $jsonContent = $request->getContent();
        $data = json_decode($jsonContent, true);

        $existingPriority = $this->entityManager->getRepository(Priority::class)->findOneBy(['name' => $data['name']]);
        if ($existingPriority) {
            return ['error' => 'Priority already exists'];
        }
        $priority = $this->serializer->deserialize($jsonContent, Priority::class, 'json', ['groups' => ['priority:read']]);
        $priority->setUser($user);
        $errors = $this->validator->validate($priority);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }
        $this->entityManager->persist($priority);
        $this->entityManager->flush();

        return ['success' => 'Priority created'];
    }

    public function updateCustomPriority(Priority $priority, string $jsonContent): array
    {
        $data = json_decode($jsonContent, true);

        if (!$priority->getUser()) {
            return ['error' => 'You can\'t update default priority'];
        }

        if (!$data || !isset($data['name'])) {
            return ['error' => 'Invalid or missing data'];
        }

        $existingPriority = $this->entityManager->getRepository(Priority::class)->findOneBy(['name' => $data['name']]);
        if ($existingPriority && $existingPriority !== $priority) {
            return ['error' => 'Priority with this name already exists'];
        }

        $priority->setName($data['name']);
        $priority->setLevel($data['level']);

        $errors = $this->validator->validate($priority);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }

        // Save changes
        $this->entityManager->flush();

        return ['success' => 'Priority updated successfully'];
    }

    public function deleteCustomPriority(?Priority $priority): array
    {
        if (!$priority) {
            return ['error' => 'Priority not found'];
        }
        if (!$priority->getUser()) {
            return ['error' => 'You can\'t delete default priority'];
        }

        // Remove priority
        $this->entityManager->remove($priority);
        $this->entityManager->flush();

        return ['success' => 'Priority deleted successfully'];
    }
}
