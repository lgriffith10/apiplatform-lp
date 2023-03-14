<?php

namespace App\Service;

use App\Entity\Hero;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
class HeroesFetcherService {
    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function fetchHeroes($io = null): void {
        $response = $this->httpClient->request(
            'GET',
            'https://valorant-api.com/v1/agents?isPlayableCharacter=true'
        );

        $heroes = json_decode($response->getContent(), true)['data'];

        foreach($heroes as $hero) {
            $heroInDatabase = new Hero();

            $heroInDatabase->setDisplayName($hero['displayName']);
            $heroInDatabase->setUuid($hero['uuid']);
            $heroInDatabase->setRoleName($hero['role']['displayName']);
            $heroInDatabase->setDescription($hero['description']);
            $heroInDatabase->setRoleImg($hero['role']['displayIcon']);
            $heroInDatabase->setImage($hero['displayIcon']);

            $this->entityManager->persist($heroInDatabase);

            if ($io) {
                $io->writeln('Hero ' . $hero['displayName'] . ' added to database');
            }
        }

        $this->entityManager->flush();

        if ($io) {
            $io->success('Heroes added to database');
        }
    }
}