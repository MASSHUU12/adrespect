<?php

namespace App\Commands;

use App\Helpers\DB;
use App\Models\ExchangeRatesModel;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'migrate:fresh',
    description: 'Resets tha database to its initial state.'
)]
class MigrateCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        DB::connect();

        $truncate = ExchangeRatesModel::truncate();

        if ($truncate !== false) {
            $output->writeln('Truncating exchange_rates table.');
        } else {
            $create = ExchangeRatesModel::create();

            if ($create === false) {
                $output->writeln(
                    'There was a problem while creating the table. Make sure the database is running and the connection to it is configured correctly'
                );

                DB::disconnect();

                return Command::FAILURE;
            }

            $output->writeln('Created exchange_rates table.');
        }

        DB::disconnect();

        $output->writeln('Migration completed.');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to reset the database to its original state.');
    }
}
