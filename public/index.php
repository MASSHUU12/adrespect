<?php

################################
# Entry point of the application
################################

require '../vendor/autoload.php';

use Dotenv\Dotenv;

Dotenv::createImmutable("../")->load();

require_once "./views/index.php";
