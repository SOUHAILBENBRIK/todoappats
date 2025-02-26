<?php

namespace App\service;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JwtCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }
        $payload = $event->getData();
        $payload['userName'] = $user->getUsername();
        $payload['email'] = $user->getEmail();
        $event->setData($payload);
    }
}
