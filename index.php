<?php

include 'Autoloader.php';

date_default_timezone_set("Europe/Kiev");
ini_set("display_errors", 1);
error_reporting(E_ALL);
session_start();
define("ROOT", dirname(__FILE__));

Autoloader::setFileExt('.class.php');

$router = new Router();
$router->run();
