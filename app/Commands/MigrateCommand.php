<?php

namespace App\Commands;

use App\Helpers\DB;
use App\Models\CurrencyConversionsModel;
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

        // Exchange rates migration
        if (ExchangeRatesModel::drop()) {
            $output->writeln('Dropped exchange_rates table.');

            if (ExchangeRatesModel::create()) {
                $output->writeln('Created exchange_rates table.');
            }
        }

        // Currency conversions migration
        if (CurrencyConversionsModel::drop()) {
            $output->writeln('Dropped currency_conversions table.');

            if (CurrencyConversionsModel::create()) {
                $output->writeln('Created currency_conversions table.');
            }
        }

        $output->writeln('Migration completed.');

        DB::disconnect();

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to reset the database to its original state.');
    }
}
