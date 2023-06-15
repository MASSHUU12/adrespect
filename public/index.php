<?php

require '../vendor/autoload.php';

use Dotenv\Dotenv;

Dotenv::createImmutable("../")->load();

require_once "./views/index.php";

//DB::connect();

//$query = DB::query("SELECT value FROM test");

//DB::disconnect();

//print_r($query->fetch_all());

//Log::error("Hi");

//NBP::get_exchange_rates();
