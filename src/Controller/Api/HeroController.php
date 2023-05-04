<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Repository\HeroRepository;
use App\Entity\Hero;

#[AsController]
class HeroController extends AbstractController
{
    public function __construct(
        private HeroRepository $heroRepository,
    )
    {}

    #[ParamConverter(
        'hero',
        class: Hero::class,
        options: ['mapping' => ['uuid' => 'uuid']])
    ]
    public function __invoke(Hero $hero): JsonResponse
    {
        return $this->json(['uuid' => 'test']);
        /*$uuid = 'test';
        return $this->json(['uuid' => $uuid]);
        $hero = $this->heroRepository->findOneBy(['uuid' => $uuid]);
        if (!$hero) {
            throw new NotFoundHttpException('Hero not found');
        }
        return $this->json($hero);*/
    }
}