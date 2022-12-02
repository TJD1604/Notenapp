<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Services\StudentService;

#[AsCommand(
    name: 'api:test',
    description: 'Add a short description for your command',
)]
class ApiTestCommand extends Command
{
    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $gradesService = new StudentService();
        $gradesService->putAverageInTable(1);

        return Command::SUCCESS;
    }
}
