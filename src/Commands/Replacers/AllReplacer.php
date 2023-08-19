<?php 
namespace Cineex\Commands\Replacers;
use Cineex\BaseCommand;
use Cineex\GeneratorTrait;
use \CodeIgniter\CLI\CLI;
use \CodeIgniter\Autoloader\FileLocator;
use Config\Services;
use Throwable;

class AllReplacer extends BaseCommand
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
    protected $name = 'replace:all';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Replace all default CodeIgniter.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'replace:all';

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
        $overwrite = CLI::prompt('Overwrite, default all default CodeIgniter?', ['y', 'n']);
        if($overwrite=='y')
        {
            $sourceDirectory =  __DIR__.'/../../Default';
            $destinationDirectory = ROOTPATH;
            
            $this->replacer($sourceDirectory, $destinationDirectory);

            $overwrite = CLI::write('Succesfully changed!','green');
        }
        else
        {
            $overwrite = CLI::write('Operation canceled!');
        }

	}

}
