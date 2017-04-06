<?php
namespace App;

require_once 'vendor/autoload.php';

use Asana\Asana;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProjectListCommand extends Command
{


    protected function configure()
    {

        $this
            ->setName('project:list')

            ->setDescription('List all projects')

            ->setHelp('This command allows you to see Asana workspace')
            ->addArgument('test', InputArgument::OPTIONAL, 'Enter test')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = new SymfonyStyle($input, $output);


        $test = $input->getArgument('test');

        // See class comments and Asana API for full info
        $asana = new Asana(array('personalAccessToken' => '0/178f955ea6ef8967a61293390e07f496')); // Create a personal access token in Asana or use OAuth

        $asana->getProjects();

        // As Asana API documentation says, when response is successful, we receive a 200 in response so...
        if ($asana->hasError()) {
            echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
            return;
        }

        // $asana->getData() contains an object in json with all projects
        foreach ($asana->getData() as $project) {
            echo 'Project ID: ' . $project->id . ' is ' . $project->name . '<br>' . PHP_EOL;
        }


            }


}
