#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\SayHelloCommand;
use App\ConnectAsanaCommand;

$app = new Application('Console demo', '1.0');

$app->add(new SayHelloCommand);

$app->add(new ConnectAsanaCommand); 


$app->run();