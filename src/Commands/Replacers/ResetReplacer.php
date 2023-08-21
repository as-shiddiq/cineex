<?php 
namespace Cineex\Commands\Replacers;
use Cineex\BaseCommand;
use Cineex\GeneratorTrait;
use \CodeIgniter\CLI\CLI;
use \CodeIgniter\Autoloader\FileLocator;
use Config\Services;
use Throwable;

class ResetReplacer extends BaseCommand
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
    protected $name = 'replace:reset';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Reset project to default CodeIgniter.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'replace:reset';

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
        $overwrite = CLI::prompt('Reset project to default CodeIgniter?', ['y', 'n']);
        if($overwrite=='y')
        {
            $sourceDirectory =  VENDORPATH.'codeigniter4/framework/app/Config/';
            $destinationDirectory = APPPATH.'Config';
            if(!file_exists($sourceDirectory))
            {
                $overwrite = CLI::write('Codeigniter project not found!','red');
                return;
            }
            $files = glob($destinationDirectory. "/*.bak");
            foreach ($files as $file) {
                $realName = str_replace('.bak', '', basename($file));
                // delete file bak and replace file copying
                unlink($file);
                copy($sourceDirectory.$realName,$destinationDirectory.'/'.$realName);
            }
            // $this->resetreplace($sourceDirectory, $destinationDirectory);
            $overwrite = CLI::write('Succesfully reset!','green');
        }
        else
        {
            $overwrite = CLI::write('Operation canceled!');
        }

	}

}
