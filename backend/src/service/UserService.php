<?php

namespace App\service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private SerializerInterface $serializer,
        private EntityManagerInterface $manager,
    ) {
    }

    public function getAllUser(): string
    {
        $users = $this->userRepository->findAll();

        return $this->serializer->serialize($users, 'json', ['groups' => 'user']);
    }
    public function deleteUser(User $user): array
    {
        $this->manager->remove($user);
        $this->manager->flush();

        return ['success' => 'user deleted successfully'];
    }

}
