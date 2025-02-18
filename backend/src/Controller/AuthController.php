<?php

namespace App\Controller;

use App\Entity\User;
use App\service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AuthController extends AbstractController
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        AuthService $authService,
    ): JsonResponse {
        try {
            $data = $serializer->deserialize($request->getContent(), User::class, 'json');
            $errors = $validator->validate($data);
            if (count($errors) > 0) {
                $errorsMessage = [];
                foreach ($errors as $error) {
                    $errorsMessage[] = $error->getPropertyPath().':'.$error->getMessage();
                }

                return $this->json(['errors' => $errorsMessage,
                    'status' => 'error'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = $this->authService->registerUser($data);

            return $this->json(['status' => 'success', 'token' => $authService->generateToken($user)], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->json(
                [
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                ], Response::HTTP_BAD_REQUEST
            );
        }
    }

    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(): void
    {
        throw new \Exception('Check security.yaml for login configuration.');
    }

    #[Route('/me', name : 'api_me', methods: ['GET'])]
    public function me(
        SerializerInterface $serializer,
    ): JsonResponse {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'status' => 'error',
                'message' => 'User not found',
            ], Response::HTTP_NOT_FOUND);
        }
        $userJson = $serializer->serialize($user, 'json');

        return $this->json([
            'status' => 'success',
            'message' => 'user Info',
            'data' => $userJson],
            Response::HTTP_OK);
    }
}
