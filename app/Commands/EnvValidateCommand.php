<?php

namespace App\Commands;

use App\Helpers\EnvValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'env:validate', description: 'Validates environment configuration')]
class EnvValidateCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $errors = EnvValidator::validate();

        foreach ($errors as $err) {
            $output->writeln($err);
        }

        if (count($errors) < 1) {
            $output->writeln("Everything looks good.");
        }

        return Command::SUCCESS;
    }
}
