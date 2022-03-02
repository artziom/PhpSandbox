<?php
require "./vendor/autoload.php";

$exampleName = "App\\Example\\";
$exampleName .= ucfirst((string)($_GET['example'] ?? 'home'));
$exampleName .= "Example";

/** @var App\Example\SandboxExample $example */
$example = new $exampleName();
$example->run();