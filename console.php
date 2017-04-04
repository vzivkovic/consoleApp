#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

$application = new Application('Console demo', '1.0');

// ... register commands
$application->register('sayHelloTo')
          ->setDescription('Offer a greeting to the given person!')
          ->addArgument('name', InputArgument::OPTIONAL, 'Your name')
          ->setCode(function(InputInterface $input, OutputInterface $output){

            $message = 'Hello ' . $input->getArgument('name');

              $output->writeln("<info>{$message}</info>");
              
          });


$application->run();
 