<?php
namespace App;

require_once 'vendor/autoload.php';
//require_once('asana.php');
use Asana\Asana;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class AsanaProjectsCommand extends Command
{

protected $workspaceId = [];


    protected function configure()
    {

        $this
            ->setName('project')

            ->setDescription('List workspace.')

            ->setHelp('This command allows you to see Asana workspace')
            ->addArgument('asana', InputArgument::OPTIONAL, 'Enter asana')
            ->addArgument('workspaceId', InputArgument::OPTIONAL, 'Enter workspace Id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = new SymfonyStyle($input, $output);

        $workspaceId = $input->getArgument('workspaceId');
        $this->asana = $input->getArgument('asana');


        // Get all workspaces
        $this->asana->getWorkspaces();

        if ($this->asana->hasError())
        {
           $this->printError();
           return;
        }

        foreach ($this->asana->getData() as $workspace)
         {
            $text->section('Worspace name: ' . $workspace->name . ' (id ' . $workspace->id . ')');

            $this->workspaceId[] = $workspace->id;

            // Get all projects in the current workspace (all non-archived projects)
            $this->asana->getProjectsInWorkspace($workspace->id, $archived = false);

            // As Asana API documentation says, when response is successful, we receive a 200 in response so...
            if ($this->asana->hasError())
            {
               $this->printError();
               continue;
            }

            if($this->isWorkspace($workspaceId)){

                $projectName = array();

                foreach ($this->asana->getData() as $project)
                {
                    $projectName[] = ('Project name: [ ' . $project->name . ' (id ' . $project->id . ')' . ' ]');

                    // Get all tasks in the current project
                    $this->asana->getProjectTasks($project->id);

                    // As Asana API documentation says, when response is successful, we receive a 200 in response so...
                    if ($this->asana->hasError())
                    {
                       $this->printError();
                       continue;
                    }

                }
                $text->listing($projectName);
            }
        }

        if(!$this->isWorkspace($workspaceId)) $text->caution('Enter workspace Id!');

        if($this->isWorkspace($workspaceId)) $text->success('You workspace Id : ' . $workspaceId);


    }

    function isWorkspace($workspaceId)
    {
        return in_array($workspaceId, $this->workspaceId);
    }

    protected function printError()
    {
      $this->text->error(array('Error while trying to connect to Asana, response code: ' . $this->asana->responseCode));
    }


}
