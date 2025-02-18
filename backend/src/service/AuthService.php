<?php

namespace App\service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    private JWTTokenManagerInterface $jwtManager;
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(JWTTokenManagerInterface $jwtManager, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->jwtManager = $jwtManager;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function registerUser(User $data)
    {
        $user = new User();
        $user->setUsername($data->getUsername());
        $user->setEmail($data->getEmail());
        $user->setPassword($this->passwordHasher->hashPassword($user, $data->getPassword()));
        $user->setname($data->getName());
        $user->setAge($data->getAge());
        $user->setLastname($data->getLastname());
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function generateToken(User $user): string
    {
        return $this->jwtManager->create($user);
    }
}
