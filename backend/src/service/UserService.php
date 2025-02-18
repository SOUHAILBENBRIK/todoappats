<?php

namespace App\service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private SerializerInterface $serializer,
        private EntityManagerInterface $manager,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function getAllUser(): string
    {
        $users = $this->userRepository->findAll();

        return $this->serializer->serialize($users, 'json', ['groups' => 'user']);
    }

    public function uploadProfileImage(User $user, mixed $file, string $uploadsDir): string
    {
        $fileName = uniqid().'.'.$file->guessExtension();

        $file->move($uploadsDir, $fileName);

        $user->setProfileImage('/uploads/images/'.$fileName);
        $this->manager->persist($user);
        $this->manager->flush();

        return '/uploads/images/'.$fileName;
    }

    public function updateUser(User $user, string $jsonContent): array
    {
        $data = json_decode($jsonContent, true);

        if (null === $data) {
            return ['error' => ['Invalid JSON format']];
        }

        $this->serializer->deserialize($jsonContent, User::class, 'json', [
            'object_to_populate' => $user,
        ]);

        if (!empty($data['password'])) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        }

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return ['error' => array_map(fn ($e) => $e->getMessage(), iterator_to_array($errors))];
        }

        // Ensure user is managed before flush
        if (!$this->manager->contains($user)) {
            $this->manager->persist($user);
        }

        $this->manager->flush();

        return ['success' => 'User updated successfully'];
    }

    public function deleteUser(User $user): array
    {
        $this->manager->remove($user);
        $this->manager->flush();

        return ['success' => 'user deleted successfully'];
    }
}
