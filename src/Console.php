<?php 
namespace Cineex;
use CodeIgniter\Autoloader\FileLocator;
use CodeIgniter\Log\Logger;
use ReflectionClass;
use ReflectionException;
class Console
{
    protected $commands = [];
    protected $logger;
    public function __construct($logger = null)
    {
        $this->logger = $logger ?? service('logger');
        $this->discoverCommands();
    }
    public function header()
    {
        $cli = new \CodeIgniter\CLI\CLI();
        $cli->write('Cineex v1.0 Command Line Tool - Server Time  '.date('Y-m-d H:i:s').' UTC '.date('P'),'blue');
    }
    public function title(){
        $cli = new \CodeIgniter\CLI\CLI();
        $cli->write("
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀".$cli->color("⣤⣿⣿⣿⣿⣦⡀","blue")."⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀".$cli->color("⣠⣤","red")."⠀⠀⠀⠀⠀⠀".$cli->color("⢀⣴⣿⣿⣿⣿⣿⣿⣿⣿⠂⠀","blue")."⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
".$cli->color("⣤⣯⣇⣇⣯⣦","red")."⠀⠀⠀".$cli->color("⣶⣿⣯⣯⣯⣿⣿⣿⡿⠁","blue")."⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣤⣤⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
".$cli->color("⣯⣇⣇⣇⣇⣇⣯⣦⡐","red")."".$cli->color("⣯⣯⣯⣯⣯⣯⣯⣧","blue")."⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣤⣶⣿⣿⣿⣷⣦⣄⠀⠀⠙⢿⡿⠃⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
".$cli->color("⠈⠫⣇⣇⣇⣇⣇⣇⣯⣏","red")."".$cli->color("⣯⣯⣯⣯⣯⣯⣯⣿⣦⡀","blue")."⠀⠀⠀⠀⠀⢠⣿⣿⡿⠋⠉⠉⠛⣿⣿⣷⠀⢸⣿⣿⠀⠀⣿⣿⣿⣴⣾⣿⣷⣦⠀⠀⠀⣤⣶⣿⣿⣿⣶⣤⠀⠀⢀⣴⣶⣿⣿⣷⣦⡀⠀⠻⣿⣿⣦⠀⣴⣿⣿⠋
⠀⠀⠀".$cli->color("⠋⣯⣇⣇⣇⣇⣇⣇⣏","red")."".$cli->color("⣯⣯⣯⣯⣯⣯⣯⣯⣶⣀","blue")."⠀⠀⠀⣿⣿⣿⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⠀⠀⣿⣿⣿⠉⠉⠉⣿⣿⣿⠀⣾⣿⣿⣁⣀⣉⣿⣿⣧⢀⣿⣿⣟⣁⣀⣹⣿⣿⡄⠀⠈⣿⣿⣷⣿⡿⠁⠀
⠀⠀⠀⠀⠀".$cli->color("⠋⣯⣇⣇⣇⣇⣇⣇⣏","red")."".$cli->color("⣟⣿⣯⣯⣯⣯⣯⣯⣷⡀","blue")."⠀⠹⣿⣿⣦⠀⠀⠀⢀⣦⣦⣦⠀⢸⣿⣿⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⣿⠀⣿⣿⣿⠛⠛⠛⢛⢛⢛⠘⣿⣿⡟⠛⠛⢛⢛⢛⠃⠀⠀⣶⣿⣿⣿⣦⠀⠀
⠀⠀⠀⠀⠀⠀".$cli->color("⢀⣿⣇⣇⣇⣇⣇⣇⣇","red")."⠀".$cli->color("⠛⣿⣯⣯⣯⣯⣯⡇","blue")."⠀⠀⠉⢿⣿⣿⣿⣿⣿⣿⠟⠀⠀⢸⣿⣿⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⣿⠀⠈⢿⣿⣿⣿⣿⣿⡿⠁⠀⠙⣿⣿⣿⣿⣿⣿⠛⠀⢠⣿⣿⡟⠈⣿⣿⣷⡀
⠀⠀⠀⠀".$cli->color("⣠⣾⣿⣯⣯⣧⣇⣇⣇⠏","red")."⠀⠀⠀⠀".$cli->color("⠙⢿⣯⣯⠋","blue")."⠀⠀⠀⠀⠀⠀⠀⠉⠉⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠁⠉⠀⠀⠀⠀⠀⠀⠀⠉⠉⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀".$cli->color("⠛⣯⣯⣯⣯⣯⣯⣇⠋","red")."⠀⠀⠀⠀⠀⠀⠀⠀".$cli->color("⠉","blue")."⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀".$cli->color("⠙⠿⠿⠟⠋","red")."⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
            ");
    }

    private function parseParamsForHelpOption(array $params): array
    {
        if (array_key_exists('help', $params)) {
            unset($params['help']);

            $params = $params === [] ? ['list'] : $params;
            array_unshift($params, 'help');
        }

        return $params;
    }

    public function getCommands()
    {
        return $this->commands;
    }
    
    public function showHelp()
    {
        CLI::write(lang('CLI.helpUsage'), 'yellow');

        if (! empty($this->usage)) {
            $usage = $this->usage;
        } else {
            $usage = $this->name;

            if (! empty($this->arguments)) {
                $usage .= ' [arguments]';
            }
        }

        CLI::write($this->setPad($usage, 0, 0, 2));

        if (! empty($this->description)) {
            CLI::newLine();
            CLI::write(lang('CLI.helpDescription'), 'yellow');
            CLI::write($this->setPad($this->description, 0, 0, 2));
        }

        if (! empty($this->arguments)) {
            CLI::newLine();
            CLI::write(lang('CLI.helpArguments'), 'yellow');
            $length = max(array_map('strlen', array_keys($this->arguments)));

            foreach ($this->arguments as $argument => $description) {
                CLI::write(CLI::color($this->setPad($argument, $length, 2, 2), 'green') . $description);
            }
        }

        if (! empty($this->options)) {
            CLI::newLine();
            CLI::write(lang('CLI.helpOptions'), 'yellow');
            $length = max(array_map('strlen', array_keys($this->options)));

            foreach ($this->options as $option => $description) {
                CLI::write(CLI::color($this->setPad($option, $length, 2, 2), 'green') . $description);
            }
        }
    }

    public function verifyCommand(string $command, array $commands): bool
    {
      $cli = new \CodeIgniter\CLI\CLI();
      if (isset($commands[$command])) {
          return true;
      }
      $message = lang('CLI.commandNotFound', [$command]);

      if ($alternatives = $this->getCommandAlternatives($command, $commands)) {
          if (count($alternatives) === 1) {
              $message .= "\n\n" . lang('CLI.altCommandSingular') . "\n    ";
          } else {
              $message .= "\n\n" . lang('CLI.altCommandPlural') . "\n    ";
          }

          $message .= implode("\n    ", $alternatives);
      }

      $cli->error($message);
      $cli->newLine();
      return false;
    }

    protected function getCommandAlternatives(string $name, array $collection): array
    {
      $alternatives = [];
      foreach (array_keys($collection) as $commandName) {
          $lev = levenshtein($name, $commandName);

          if ($lev <= strlen($commandName) / 3 || strpos($commandName, $name) !== false) {
              $alternatives[$commandName] = $lev;
          }
      }

      ksort($alternatives, SORT_NATURAL | SORT_FLAG_CASE);

      return array_keys($alternatives);
    }

    public function run()
    {
        $cli = new \CodeIgniter\CLI\CLI();
        $params  = array_merge($cli->getSegments(), $cli->getOptions());
        $params  = $this->parseParamsForHelpOption($params);
        $command = array_shift($params) ?? 'list';
        if($command=='install' || $command=='list')
        {
            $this->title();
        }
        $this->header();
        if (! $this->verifyCommand($command, $this->commands)) {
          return;
        }
        // The file would have already been loaded during the
        // createCommandList function...
        $className = $this->commands[$command]['class'];
        $class     = new $className($this->logger, $this);
        return $class->run($params);
    }

    public function discoverCommands()
    {
        if ($this->commands !== []) {
            return;
        }

        /** @var FileLocator $locator */
        $locator = service('locator');
        $files   = $locator->listFiles('Commands/');
        // If no matching command files were found, bail
        // This should never happen in unit testing.
        if ($files === []) {
            return; // @codeCoverageIgnore
        }

        // Loop over each file checking to see if a command with that
        // alias exists in the class.
        foreach ($files as $file) {
            $className = $locator->getClassname($file);

            if ($className === '' || ! class_exists($className)) {
                continue;
            }

            try {
                $class = new ReflectionClass($className);
                if (! $class->isInstantiable() || ! $class->isSubclassOf(BaseCommand::class)) {
                    continue;
                }

                /** @var BaseCommand $class */

                $class = new $className($this->logger, $this);

                if (isset($class->group)) {
                    $this->commands[$class->name] = [
                        'class'       => $className,
                        'file'        => $file,
                        'group'       => $class->group,
                        'description' => $class->description,
                    ];
                }

                unset($class);
            } catch (ReflectionException $e) {
                $this->logger->error($e->getMessage());
            }
        }
        asort($this->commands);
    }
}

