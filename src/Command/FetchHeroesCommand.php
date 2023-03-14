<?php

namespace App\Command;


use App\Service\HeroesFetcherService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fetch-heroes',
    description: 'Fetches heroes from the Valorant API',
    hidden: false,
    aliases: ['heroes:fetch'],
)]
class FetchHeroesCommand extends Command
{
    public function __construct(
        private HeroesFetcherService $heroesFetcherService,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->heroesFetcherService->fetchHeroes($io);

        return Command::SUCCESS;
    }
}