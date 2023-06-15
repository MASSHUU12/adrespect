#!/user/bin/env php
<?php

require './vendor/autoload.php';

use App\Commands\MigrateCommand;
use Dotenv\Dotenv;
use Symfony\Component\Console\Application;

Dotenv::createImmutable(".")->load();

$application = new Application();

$application->add(new MigrateCommand());

$application->run();
