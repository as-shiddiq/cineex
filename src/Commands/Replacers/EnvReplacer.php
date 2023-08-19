<?php 
namespace Cineex\Commands\Replacers;
use Cineex\BaseCommand;
use Cineex\GeneratorTrait;
use \CodeIgniter\CLI\CLI;
use \CodeIgniter\Autoloader\FileLocator;
use Config\Services;
use Throwable;

class EnvReplacer extends BaseCommand
{
    use GeneratorTrait;
	/**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Replacer';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'replace:env';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Replace default env CodeIgniter.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'replace:env';

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
        $overwrite = CLI::prompt('Overwrite, default .env CodeIgniter?', ['y', 'n']);
        if($overwrite=='y')
        {
            $sourceDirectory =  __DIR__.'/../../Default/.env';
            $destinationDirectory = ROOTPATH.'/.env';
            
            $this->replacer($sourceDirectory, $destinationDirectory);
            $overwrite = CLI::write('Succesfully changed!','green');
        }
        else
        {
            $overwrite = CLI::write('Operation canceled!');
        }

	}

}
