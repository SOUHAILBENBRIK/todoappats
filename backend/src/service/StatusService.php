<?php

namespace App\service;

use App\Entity\Status;
use App\Entity\User;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StatusService
{
    public function __construct(
        private StatusRepository $statusRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) {
    }

    public function getStatusList(int $userId): string
    {
        $statusList = $this->statusRepository->findBy(['user' => $userId]);

        return $this->serializer->serialize($statusList, 'json', ['groups' => ['status:read'], 'ignored_attributes' => ['user']]);
    }

    public function getStatus(int $statusId): string
    {
        $status = $this->statusRepository->find($statusId);

        return $this->serializer->serialize($status, 'json', ['groups' => ['status:read']]);
    }

    public function createCustomStatus(Request $request): array
    {
        $jsonContent = $request->getContent();
        $data = json_decode($jsonContent, true);
        $user = $this->entityManager->getRepository(User::class)->find($data['user']);
        if (!$user) {
            return ['error' => 'User not found'];
        }
        $existingStatus = $this->entityManager->getRepository(Status::class)->findOneBy(['name' => $data['name']]);
        if ($existingStatus) {
            return ['error' => 'Status already exists'];
        }
        $status = $this->serializer->deserialize($jsonContent, Status::class, 'json', ['groups' => ['status:read']]);
        $status->setUser($user);
        $errors = $this->validator->validate($status);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }
        $this->entityManager->persist($status);
        $this->entityManager->flush();

        return ['success' => 'Status created'];
    }

    public function updateCustomStatus(int $statusId, string $jsonContent): array
    {
        $status = $this->entityManager->getRepository(Status::class)->find($statusId);
        if (!$status) {
            return ['error' => 'Status not found'];
        }
        if (!$status->getUser()) {
            return ['error' => 'you can\'t update default status'];
        }

        $data = json_decode($jsonContent, true);

        // Validate JSON structure
        if (!$data || !isset($data['name'])) {
            return ['error' => 'Invalid or missing data'];
        }

        $existingStatus = $this->entityManager->getRepository(Status::class)->findOneBy(['name' => $data['name']]);
        if ($existingStatus && $existingStatus !== $status) {
            return ['error' => 'Status with this name already exists'];
        }

        $status->setName($data['name']);

        // Validate entity
        $errors = $this->validator->validate($status);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }

        // Save changes
        $this->entityManager->flush();

        return ['success' => 'Status updated successfully'];
    }

    public function deleteCustomStatus(int $statusId): array
    {
        $status = $this->entityManager->getRepository(Status::class)->find($statusId);

        if (!$status) {
            return ['error' => 'Status not found'];
        }

        if (!$status->getUser()) {
            $this->entityManager->remove($status);
            $this->entityManager->flush();

            return ['success' => 'Status deleted successfully'];
        }

        return ['error' => 'Default Status can\'t be deleted'];
    }
}
