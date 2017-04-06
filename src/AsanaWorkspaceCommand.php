<?php
namespace App;

require_once 'vendor/autoload.php';

//use Asana\Asana;

//use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class AsanaWorkspaceCommand extends ConnectAsanaCommand
{

    protected function configure()
    {

        $this
            ->setName('workspace')
            ->setDescription('List workspace.')
            ->setHelp('This command allows you to see Asana workspace')
            ->addArgument('token', InputArgument::REQUIRED, 'Enter asana token')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$this->text = $this->symfonyStyle($input, $output);

        $token = $input->getArgument('token');

        $this->asana = $this->setToken($token);
        $this->asana = $token;
        // Get all workspaces
        $this->asana->getWorkspaces();

              self::$text->text("Test static!");

        $this->printError();

        $this->workspacesList();

        $this->message('Workspace');

    }

    protected function workspacesList()
    {
      foreach ($this->asana->getData() as $workspace)
       {
          self::$text->section('Worspace name: ' . $workspace->name . ' (id: ' . $workspace->id . ')');

          $this->getIds[] = $workspace->id;

          $this->printErrorContinue();
      }
    }

    public function store(){
      // if($this->isWorkspace($workspaceId)){
      //
      //     $projectName = array();
      //
      //     foreach ($this->asana->getData() as $project)
      //     {
      //         $projectName[] = ('Project name: [ ' . $project->name . ' (id ' . $project->id . ')' . ' ]');
      //
      //         // Get all tasks in the current project
      //         $this->asana->getProjectTasks($project->id);
      //
      //         // As Asana API documentation says, when response is successful, we receive a 200 in response so...
      //         if ($this->asana->hasError())
      //         {
      //            $this->printError();
      //            continue;
      //         }
      //
      //     }
      //     $text->listing($projectName);
      // }
    }


}
