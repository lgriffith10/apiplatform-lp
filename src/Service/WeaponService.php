<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;

class WeaponService
{
    public function __construct(
        private WeaponRepository $weaponRepository,
        private EntityManagerInterface $entityManager,
        private HttpClientInterface $httpClient
    ) {}


    public function fetch($io = null): void
    {
        $response = $this->httpClient->request(
            'GET',
            'https://valorant-api.com/v1/weapons'
        );

        $weapons = json_decode($response->getContent(), true)['data'];

        foreach($weapons as $weapon)
        {
            $weaponInDatabase = new Weapon();
            $weaponInDatabase->setName($weapon['displayName']);

            if (!$this->weaponRepository->findOneBy(['name' => $weapon['displayName']])) {
                $this->entityManager->persist($weaponInDatabase);
            }

            if ($io) {
                $io->writeln('Weapon ' . $weapon['displayName'] . ' added to database');
            }
        }

        $this->entityManager->flush();

        $weapons = $this->weaponRepository->findAll();
    }
}

?>