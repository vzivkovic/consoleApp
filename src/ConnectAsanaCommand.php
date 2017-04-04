<?php 
namespace App;

require_once 'vendor/autoload.php';
require_once('asana.php');

use Asana\Asana;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ConnectAsanaCommand extends Command
{

    protected $asana;
    public static $token;

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('connect')

            // the short description shown while running "php bin/console list"
            ->setDescription('Enter your Asana token.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('token', InputArgument::OPTIONAL, 'Token')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        self::$token = $input->getArgument('token');


        // See class comments and Asana API for full info
        $this->asana = new Asana(array('personalAccessToken' => '0/178f955ea6ef8967a61293390e07f496')); // Create a personal access token in Asana or use OAuth

        // Get all workspaces
        $this->asana->getWorkspaces();

        // As Asana API documentation says, when response is successful, we receive a 200 in response so...
        if ($this->asana->hasError()) {
        echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
        return;

        }

        $output->writeln("<info>" . self::$token . "</info>");
    }


}