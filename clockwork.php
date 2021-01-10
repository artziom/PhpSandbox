<?php

require "./vendor/autoload.php";

$clockwork = Clockwork\Support\Vanilla\Clockwork::init([ 'api' => '/clockwork.php?request=' ]);
$clockwork->returnMetadata();