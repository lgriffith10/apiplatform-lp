<?php

namespace App\Service;

use App\Entity\Hero;
use App\Entity\Weapon;
use App\Repository\HeroRepository;
use App\Repository\WeaponRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HeroesFetcherService {
    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager,
        private HeroRepository $heroRepository,
        private WeaponRepository $weaponRepository
    ) {
    }

    public function fetchHeroes($io = null): void {
        $response = $this->httpClient->request(
            'GET',
            'https://valorant-api.com/v1/agents?isPlayableCharacter=true'
        );

        $heroes = json_decode($response->getContent(), true)['data'];

        $this->entityManager->flush();

        $weapons = $this->weaponRepository->findAll();

        foreach($heroes as $hero) {
            $heroInDatabase = new Hero();

            $weapon = $weapons[rand(1, count($weapons) - 1)];

            $heroInDatabase->setDisplayName($hero['displayName']);
            $heroInDatabase->setUuid($hero['uuid']);
            $heroInDatabase->setRoleName($hero['role']['displayName']);
            $heroInDatabase->setDescription($hero['description']);
            $heroInDatabase->setRoleImg($hero['role']['displayIcon']);
            $heroInDatabase->setImage($hero['displayIcon']);
            $heroInDatabase->setWeapon($weapon);

            if (!$this->heroRepository->findOneBy(['uuid' => $hero['uuid']])) {
                $this->entityManager->persist($heroInDatabase);

                if ($io) {
                    $io->writeln('Hero ' . $hero['displayName'] . ' added to database');
                }
            }
        }

        $this->entityManager->flush();

        if ($io) {
            $io->success('Heroes added to database');
        }
    }
}