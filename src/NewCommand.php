<?php 

namespace App;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class NewCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('new')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create a new Laravel application.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('name', InputArgument::OPTIONAL, 'Project Name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->assertAppDoesNotExist();
    }

    private function assertAppDoesNotExist($directory, OutputInterface $output){

        if (is_dir($directory))
        {
            $output->writeln("Application alredy exists!");
            exit(1);
        }
    }

}