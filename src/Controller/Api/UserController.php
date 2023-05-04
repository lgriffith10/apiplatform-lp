<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

#[AsController]
class UserController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        if ($this->getUser())
        {
            return $this->json($this->getUser());
        }

        throw new UserNotFoundException();
    }
}