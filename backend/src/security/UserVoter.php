<?php

namespace App\security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    public const DELETE_TASKS = 'delete_tasks';

    protected function supports(string $attribute, $subject): bool
    {
        // The subject should be a User entity, and the attribute must be 'delete_tasks'
        return self::DELETE_TASKS === $attribute && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $user, TokenInterface $token): bool
    {
        // Get the currently logged-in user
        $loggedInUser = $token->getUser();

        // Ensure the user is authenticated
        if (!$loggedInUser instanceof User) {
            return false;
        }

        // Allow access only if the logged-in user is the same as the requested user
        return $loggedInUser->getId() === $user->getId();
    }
}
