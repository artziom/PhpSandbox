<?php

require "./vendor/autoload.php";

$clockwork = Clockwork\Support\Vanilla\Clockwork::init([
    'api' => '/clockwork.php?request=',
    'register_helpers' => true,
    'storage_files_path' => __DIR__ . '/clockwork'
]);
$clockwork->returnMetadata();