<?php

require '../vendor/autoload.php';

use App\Helpers\DB;
use App\Helpers\Log;
use Dotenv\Dotenv;

Dotenv::createImmutable("../")->load();

DB::connect();

$query = DB::query("SELECT value FROM test");

DB::disconnect();

print_r($query->fetch_all());

Log::error("Hi");

