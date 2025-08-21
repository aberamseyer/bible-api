<?php

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

define('WWW_DIR', __DIR__ . "/..");
error_reporting($_ENV['APP_DEBUG'] === 'true' ? E_ALL ^ E_NOTICE ^ E_WARNING : 0);

require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/Database.php";
