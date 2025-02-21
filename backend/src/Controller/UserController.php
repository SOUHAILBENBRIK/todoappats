<?php

namespace App\Controller;

use App\Entity\User;
use App\service\ResponseService;
use App\service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/', name : 'update_user', methods: ['Put'])]
    public function updateUser(
        Request $request): JsonResponse
    {
        try {
            $currentUser = $this->getUser();
            if (!$currentUser instanceof User) {
                return $this->responseService->notfoundResponse(
                    message: 'user not found',
                );
            }
            $result = $this->userService->updateUser($currentUser, $request->getContent());

            if (isset($result['error'])) {
                return $this->responseService->errorResponse(
                    message: $result['error'],
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }

            return $this->responseService->successResponse(
                message: 'user updated successfully',
            );
        } catch (\Exception $e) {
            return $this->responseService->errorResponse(message: $e->getMessage());
        }
    }

    #[Route('/upload-profile-image', name: 'upload_profile_image', methods: ['POST'])]
    public function uploadProfileImage(
        Request $request,
    ): JsonResponse {
        try {
            $user = $this->getUser();

            if (!$user instanceof User) {
                return $this->responseService->errorResponse(
                    message: 'User not unauthorized',
                    statusCode: Response::HTTP_UNAUTHORIZED
                );
            }
            $file = $request->files->get('image');

            if (!$file) {
                return $this->responseService->errorResponse(
                    message: 'Image not uploaded',
                    statusCode: Response::HTTP_BAD_REQUEST
                );
            }
            $uploadsDir = $this->getParameter('kernel.project_dir').'/public/uploads/user';
            $imagePath = $this->userService->uploadProfileImage($user, $file, $uploadsDir);

            return $this->responseService->successResponse(
                message: 'Profile image uploaded successfully',
                data: $imagePath
            );
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
