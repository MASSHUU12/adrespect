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

        $error_truncating = ExchangeRatesModel::truncate();

        if ($error_truncating !== false) {
            $output->writeln('Truncating exchange_rates table.');
        } else {
            $statement = DB::query('
                    CREATE TABLE exchange_rates (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        table_name VARCHAR(50),
                        number VARCHAR(50),
                        effective_date DATE,
                        currency VARCHAR(100),
                        code VARCHAR(10),
                        mid DECIMAL(10, 4)
                    )
                ');

            if ($statement === false) {
                $output->writeln(
                    'There was a problem while creating the table. Make sure the database is running and the connection to it is configured correctly'
                );

                DB::disconnect();

                return Command::FAILURE;
            }
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
