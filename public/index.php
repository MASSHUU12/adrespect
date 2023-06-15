<?php

require '../vendor/autoload.php';

use Dotenv\Dotenv;

Dotenv::createImmutable("../")->load();

require_once "./views/index.php";
