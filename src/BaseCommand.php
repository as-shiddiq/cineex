<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Cineex;

use Psr\Log\LoggerInterface;
use ReflectionException;
use \CodeIgniter\CLI\CLI;
use Throwable;

/**
 * BaseCommand is the base class used in creating CLI commands.
 *
 * @property array           $arguments
 * @property Console        $commands
 * @property string          $description
 * @property string          $group
 * @property LoggerInterface $logger
 * @property string          $name
 * @property array           $options
 * @property string          $usage
 */
abstract class BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group;

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name;

    /**
     * the Command's usage description
     *
     * @var string
     */
    protected $usage;

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description;

    /**
     * the Command's options description
     *
     * @var array
     */
    protected $options = [];

    /**
     * the Command's Arguments description
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Logger to use for a command
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Instance of Console so
     * commands can call other commands.
     *
     * @var Console
     */
    protected $commands;

    public function __construct(LoggerInterface $logger, Console $commands)
    {
        $this->logger   = $logger;
        $this->commands = $commands;
    }

    /**
     * Actually execute a command.
     *
     * @param array<int|string, string|null> $params
     *
     * @return int|void
     */
    abstract public function run(array $params);

    /**
     * Can be used by a command to run other commands.
     *
     * @return int|void
     *
     * @throws ReflectionException
     */
    protected function call(string $command, array $params = [])
    {
        return $this->commands->run($command, $params);
    }

    /**
     * A simple method to display an error with line/file, in child commands.
     */
    protected function showError(Throwable $e)
    {
        $exception = $e;
        $message   = $e->getMessage();
        $config    = config('Exceptions');

        require $config->errorViewPath . '/cli/error_exception.php';
    }

    /**
     * Show Help includes (Usage, Arguments, Description, Options).
     */
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

    /**
     * Pads our string out so that all titles are the same length to nicely line up descriptions.
     *
     * @param int $extra How many extra spaces to add at the end
     */
    public function setPad(string $item, int $max, int $extra = 2, int $indent = 0): string
    {
        $max += $extra + $indent;

        return str_pad(str_repeat(' ', $indent) . $item, $max);
    }

    /**
     * Get pad for $key => $value array output
     *
     * @deprecated Use setPad() instead.
     *
     * @codeCoverageIgnore
     */
    public function getPad(array $array, int $pad): int
    {
        $max = 0;

        foreach (array_keys($array) as $key) {
            $max = max($max, strlen($key));
        }

        return $max + $pad;
    }

    /**
     * Makes it simple to access our protected properties.
     *
     * @return array|Console|LoggerInterface|string|null
     */
    public function __get(string $key)
    {
        return $this->{$key} ?? null;
    }

    /**
     * Makes it simple to check our protected properties.
     */
    public function __isset(string $key): bool
    {
        return isset($this->{$key});
    }


    function converter($source, $destination,$config,$check = true) {
        // dd($source);
        $dir = opendir($source);
        if(!is_dir($destination))
        {
            mkdir($destination, 0755, true);
        }
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..' && $file !='Config') {
                $sourcePath = $source . '/' . $file;
                $destinationPath = $destination . '/' . $file;

                if (is_dir($sourcePath)) {
                    $this->converter($sourcePath, $destinationPath,$config);
                } else {
                    $fileContent = file_get_contents($sourcePath);
                    $fileContent = str_replace('Modules\\'.$config['from'], 'Modules\\'.$config['to'], $fileContent);
                    //check file is the config
                    $clearText = preg_replace('/[\/\\\ ]/', '', $destinationPath);
                    if (strpos($clearText,'appConfig') !== false) {
                        rename($destinationPath,$destinationPath.'.bak');
                        // CLI::write('Create backup file : '.CLI::color($destinationPath.'!','green'));
                    }
                    if(!file_exists($destinationPath))
                    {
                        CLI::write('Succesfully convert : '.CLI::color($destinationPath.'!','green'));
                        file_put_contents($destinationPath, $fileContent);
                    }
                    else
                    {
                        CLI::write('Cancelled convert : '.CLI::color($destinationPath.'!','yellow').' file is exists');
                    }
                }
            }
        }

        closedir($dir);
    }

    function replacer($source, $destination) {

        if(is_dir($source))
        {
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $dir = opendir($source);

            while (($file = readdir($dir)) !== false) {
                if ($file != '.' && $file != '..') {
                    $sourcePath = $source . '/' . $file;
                    $destinationPath = $destination . '/' . $file;

                    if (is_dir($sourcePath)) {
                        $this->replacer($sourcePath, $destinationPath);
                    } else {
                        if(file_exists($destinationPath))
                        {
                            //check file is the config
                            $clearText = preg_replace('/[\/\\\ ]/', '', $destinationPath);
                            if (strpos($clearText,'appConfig') !== false) {
                                rename($destinationPath,$destinationPath.'.bak');
                                // CLI::write('Create backup file : '.CLI::color($destinationPath.'!','green'));
                            }
                        }
                        CLI::write('Succesfully replace : '.CLI::color($destinationPath.'!','green'));
                        copy($sourcePath, $destinationPath);
                    }
                }
            }

            closedir($dir);
        }
        else
        {
            copy($source,$destination);
        }
    }

    public function replacerTemplate($render,$reset=false)
    {
        $templateWritable =  ROOTPATH.'/writable/cineex/templates';
        $templateName = env('cineex.template.'.$render);
        $destinationTemplate = $templateWritable.'/'.$templateName;
        //check theme in writable
        if(!file_exists($templateWritable.'/'.$templateName))
        {
            //if not found check on vendor
            $sourceTemplate = __DIR__.'/Templates/'.$templateName;
            if(!file_exists($sourceTemplate))
            {
                $serverUrl = 'http://localhost:9090/'.$templateName.'.zip';
                CLI::write('Trying download '.$templateName.' from server...','blue');
                try {
                    if(!is_dir($destinationTemplate))
                    {
                        mkdir($destinationTemplate, 0777, true);
                    }
                    $file_contents = file_get_contents($serverUrl);
                    file_put_contents($destinationTemplate.'.zip', $file_contents);
                    CLI::write('Extracting '.$templateName.'...','blue');
                    // extracting zip file
                    $zip = zip_open($destinationTemplate.'.zip');
                    if ($zip) {
                        while ($zip_entry = zip_read($zip)) {
                            $entry_name = zip_entry_name($zip_entry);
                            $entry_size = zip_entry_filesize($zip_entry);

                            if (zip_entry_open($zip, $zip_entry, "r")) {
                                $content = zip_entry_read($zip_entry, $entry_size);
                                $fileSave = $destinationTemplate.'/'. $entry_name;
                                // Menyimpan konten ekstrak (misalnya, dalam direktori $extracted_folder)
                                if(count(explode('.',$entry_name))==1)
                                {
                                    if(!is_dir($fileSave))
                                    {
                                        mkdir($fileSave, 0777, true);
                                    }
                                }
                                else
                                {
                                    file_put_contents($fileSave, $content);
                                }
                                zip_entry_close($zip_entry);
                            }
                        }
                        zip_close($zip);
                        unlink($destinationTemplate.'.zip');
                        $this->replacerTemplate($render,false);
                        return;
                    }

                } catch (\Exception $e) {
                    CLI::write($e->getMessage(),'red');
                    return ;
                }
            }
            else
            {
                //copying from vendor file
                $this->replacer($sourceTemplate, $destinationTemplate);
                $this->replacerTemplate($render,false);
                return;
            }
        }




        $sourceTemplate = $destinationTemplate;
        $sourceDirectoryTemplate =  $sourceTemplate.'/Template';
        $sourceDirectoryView =  $sourceTemplate.'/Views/'.ucfirst($render);
        $destinationDirectoryTemplate = ROOTPATH.'/public/templates/'.$templateName;
        $destinationDirectoryView = ROOTPATH.'/app/Views/'.ucfirst($render);

        if(is_dir($sourceDirectoryTemplate))
        {
            $this->replacer($sourceDirectoryTemplate, $destinationDirectoryTemplate);
        }

        if(is_dir($sourceDirectoryView))
        {
            $this->replacer($sourceDirectoryView, $destinationDirectoryView);
        }
    }
}
