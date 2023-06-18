#!/user/bin/env php
<?php

require './vendor/autoload.php';

use App\Commands\EnvValidateCommand;
use App\Commands\MigrateCommand;
use Dotenv\Dotenv;
use Symfony\Component\Console\Application;

Dotenv::createImmutable(".")->load();

$application = new Application();

$application->add(new MigrateCommand());
$application->add(new EnvValidateCommand());

try {
    $application->run();
} catch (Exception $e) {
    echo $e;
}
