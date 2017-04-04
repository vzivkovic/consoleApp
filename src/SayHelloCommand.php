<?php 

namespace App;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SayHelloCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('sayHelloTo')

            // the short description shown while running "php bin/console list"
            ->setDescription('Offer a greeting to the given person!')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('name', InputArgument::OPTIONAL, 'Your name')
            ->addOption(
                'option',
                null,
                InputOption::VALUE_OPTIONAL,
                'How many times should the message be printed?',
                ' Hello '
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $output->write('You are about to ');

        $message = $input->getOption('option') . ' ' . $input->getArgument('name');

        $output->writeln("<info>{$message}</info>");
    }

}