<?php

require '../vendor/autoload.php';

use App\Helpers\NBP;
use Dotenv\Dotenv;

Dotenv::createImmutable("../")->load();

//DB::connect();

//$query = DB::query("SELECT value FROM test");

//DB::disconnect();

//print_r($query->fetch_all());

//Log::error("Hi");

NBP::get_exchange_rates();
