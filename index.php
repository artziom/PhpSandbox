<?php
require "./vendor/autoload.php";

$clockwork = Clockwork\Support\Vanilla\Clockwork::init([
    'api' => '/clockwork.php?request=',
    'register_helpers' => true
]);

$example = new ClockworkExample();
$example->run();

$clockwork->requestProcessed();