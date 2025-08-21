<?php

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

define('WWW_DIR', __DIR__ . "/..");
error_reporting($_ENV['APP_DEBUG'] === 'true' ? E_ALL ^ E_NOTICE ^ E_WARNING : 0);

if ($_ENV['API_KEY'] && ($_SERVER['HTTP_AUTHORIZATION'] !== 'Bearer ' . $_ENV['API_KEY'] &&
  $_REQUEST['api_key'] !== $_ENV['API_KEY'])) {
  http_response_code(401);
  die;
}

require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/Database.php";
