<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Service\UserService;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user',
    hidden: false,
    aliases: ['user:create'],
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private UserService $userService,
    ) {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->userService->createUser(
            $input->getArgument('email'),
            $input->getArgument('password'),
        );

        $output->writeln('User created!');

        return Command::SUCCESS;
    }
}