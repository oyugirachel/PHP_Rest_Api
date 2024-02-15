<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

include 'api/database/connection.php';


$dotenv = new DotEnv(__DIR__);
$dotenv->load();


