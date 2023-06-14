<?php

require '../vendor/autoload.php';

use App\Helpers\DB;

DB::connect();

$query = DB::query("SELECT value FROM test");

DB::disconnect();

var_dump($query->fetch_all());

