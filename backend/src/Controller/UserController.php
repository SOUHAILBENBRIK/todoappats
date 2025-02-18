<?php

namespace App\Controller;

use App\service\ResponseService;
use App\service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
final class UserController extends AbstractController
{
    private UserService $userService;
    private ResponseService $responseService;

    public function __construct(ResponseService $responseService, UserService $userService)
    {
        $this->responseService = $responseService;
        $this->userService = $userService;
    }

    #[Route('/', name: 'get_all_user', methods: ['GET']),IsGranted('ROLE_ADMIN')]
    public function getAllUser(): JsonResponse
    {
        try {
            $users = $this->userService->getAllUser();

            return $this->responseService->successResponse(message: 'successfully get All users',
                data: $users);
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message: $e->getMessage(),
            );
        }
    }

    #[Route('/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser($id): JsonResponse
    {
        try {
            $result = $this->userService->deleteUser($id);

            return $this->responseService->successResponse(

                message: $result['success'],

            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(
                message: $e->getMessage(),
            );
        }
    }
}
