<?php

namespace App\Commands;

use App\Helpers\DB;
use Exception;
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

        try {
            DB::query('DROP TABLE exchange_rates');
            $output->writeln('Deleting exchange_rates table.');
        } catch (Exception) {
            $output->writeln('There is no exchange_rates table. Creating it now.');
        }

        try {
            DB::query('
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
        } catch (Exception) {
            $output->writeln('There was a problem while creating the table.
            Make sure the database is running and the connection to it is configured correctly');
            return Command::FAILURE;
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
