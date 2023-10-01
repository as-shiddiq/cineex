<?php 
namespace Cineex\Commands\Converters;
use Cineex\BaseCommand;
use Cineex\GeneratorTrait;
use \CodeIgniter\CLI\CLI;
use \CodeIgniter\Autoloader\FileLocator;
use Config\Services;
use Throwable;

class ModuleConverter extends BaseCommand
{
    use GeneratorTrait;
	/**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Converter';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'convert:module';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Convert the module project to others module';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'convert:module';

    /**
     * The Command's arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [
        // 'module'=>'Module name',
    ];

    /**
     * The Command's options
     *
     * @var array<string, string>
     */
    protected $options = [
        // '--module' => 'Name of module'
    ];

    /**
     * Creates a new database.
     */

  	public function run(array $params)
    {
        $runner  = Services::commands();
        $from = $params[0];
        $to = $this->getOption('module');
        $overwrite = CLI::prompt('Convert module '.CLI::color($from,"green").', to '.CLI::color($to,"green").'?', ['y', 'n']);
        if($overwrite=='y')
        {
            $sourceDirectory =  ROOTPATH.'modules/'.$from;
            $destinationDirectory = ROOTPATH.'modules/'.$to;
            if(!is_dir($sourceDirectory))
            {
                CLI::write('Operation canceled, source not found!','red');
                die();
            }
            if(!is_dir($destinationDirectory))
            {
                CLI::write('Operation canceled, destination not found!','red');
                die();
            }

            $convert = $this->converter($sourceDirectory, $destinationDirectory,['from'=>$from,'to'=>$to]);
            if($convert)
            {
                $overwrite = CLI::write('Succesfully changed!','green');
            }
        }
        else
        {
            $overwrite = CLI::write('Operation canceled!');
        }

	}

}
