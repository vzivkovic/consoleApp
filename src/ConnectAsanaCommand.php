<?php
namespace App;

require_once 'vendor/autoload.php';

use Asana\Asana;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConnectAsanaCommand extends Command
{

  protected $defaultToken;
  protected $asana;
  protected $getIds = [];
  protected static $text;

  public function __construct(Asana $defaultToken)
  {
      $this->defaultToken = $defaultToken;

      parent::__construct();
  }

    protected function configure()
    {
      //$defaultToken = $this->defaultToken;

        $this
            ->setName('connect')
            ->setDescription('Enter your Asana token.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('token', InputArgument::OPTIONAL, 'Enter token')
            // ->addOption(
            //   'token',
            //   '-t',
            //   InputOption::VALUE_OPTIONAL,
            //   'Who do you want to greet?',
            //   $defaultToken
            // )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

      self::$text = new SymfonyStyle($input,$output);
      //$this->text = new SymfonyStyle($input, $output);
      $token = $input->getArgument('token');

      $this->asana = $this->setToken($token);
      //$this->asana = $this->defaultToken;
      //$input->getOption('token');

      // Get all workspaces
      $this->asana->getWorkspaces();

      // As Asana API documentation says, when response is successful, we receive a 200 in response so...
      $this->printError();

      self::$text->newLine(1);
      self::$text->progressStart(100);
      self::$text->newLine(1);

      //$this->callWorkspaceCommand($output);
      $workspaceCommand = $this->getApplication()->find('workspace');
      $arguments = array(
          'command' => 'workspace',
          'token'    => $this->asana,
          //'--yell'  => true,
      );

      $greetInput = new ArrayInput($arguments);
      $workspaceCommand->run($greetInput, $output);

      self::$text->progressFinish();
      self::$text->newLine(1);
      self::$text->text("The End!");
      self::$text->newLine(1);

    }

    protected function printError()
    {
      if ($this->asana->hasError())
      {
         self::$text->error(array('Error while trying to connect to Asana, response code: ' . $this->asana->responseCode));
         return;
      }

    }

    protected function printErrorContinue()
    {
      if ($this->asana->hasError())
      {
         self::$text->error(array('Error while trying to connect to Asana, response code: ' . $this->asana->responseCode));
         continue;
      }

    }

    protected function setToken($token)
    {
      if(is_object($token)) return $token;

      return empty($token) ? $this->defaultToken : new Asana(array('personalAccessToken' => $token));
    }

    protected function message($message = '')
    {
        if(count($this->getIds))
        {
          self::$text->success('Success ' . $message);
        }else{
          self::$text->caution('Not find any items!');
        }
    }

    protected function callWorkspaceCommand($output)
    {
      $workspaceCommand = $this->getApplication()->find('workspace');
      $arguments = array(
          'command' => 'workspace',
          'token'    => $this->asana,
          //'--yell'  => true,
      );

      $greetInput = new ArrayInput($arguments);
      $workspaceCommand->run($greetInput, $output);
    }

















}
