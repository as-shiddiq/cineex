<?php 
namespace Cineex\Commands\Generators;
use Cineex\BaseCommand;
use Cineex\GeneratorTrait;
use \CodeIgniter\CLI\CLI;
use Config\Services;
use Throwable;

class ViewGenerator extends BaseCommand
{
    use GeneratorTrait;
	/**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Generators';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'make:view';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Generates a new view file in modules.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'create:view <name> [option]';

    /**
     * The Command's arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [
        'name'=>'Name of controller to auto generate',
    ];

    /**
     * The Command's options
     *
     * @var array<string, string>
     */
    protected $options = [
        '--module' => 'Name of module',
        '--for' => 'Create controller what for? [dashboard, main, api]',
    ];

    /**
     * Creates a new database.
     */
  	public function run(array $params)
    {
        $runner  = Services::commands();
        $for = $this->getOption('for')??'dashboard';
        if($for=='api')
        {
            CLI::error("Error : Views can't generate for API");
            die();
        }
        $module = $this->getOption('module');
        $this->component = 'View';
        $this->directory = '\\Views\\'.ucfirst($for).'\\'.ucfirst($params[0]);
        $execute = true;
        //cek the controller
        $controller = 'Modules\\'.$module.'\\Controllers\\'.ucfirst($for).'\\'.ucfirst($params[0]);
        if(!class_exists($controller))
        {
            $execute = false;
            CLI::error("Error : Controller not found : {$controller}");
            CLI::write("- Please create Controller before create Views",'yellow');
        }
        if($execute)
        {
            //collect the controller method
            $methodExists = [];
            if(method_exists($controller, 'index'))
            {
                $methodExists[] = 'index';
            }
            if(method_exists($controller, 'form'))
            {
                $methodExists[] = 'form';
            }
            if(method_exists($controller, 'sort'))
            {
                $methodExists[] = 'sort';
            }
            foreach ($methodExists as $key => $value) {
                $this->template  = strtolower($value).'.tpl.php';
                $params['fileName'] = ucfirst($value);
                $this->classNameLang = 'CLI.generator.className.view';
                $this->execute($params);
            }
        }
	}

    /**
     * Prepare options and do the necessary replacements.
     */
    protected function prepare(string $class): string
    {
        $module = $this->getOption('module');
        $selected = $this->getOption('selected');
        $modal = $this->getOption('modal');
        helper('app');
        $for = strtolower($this->getOption('for')??'dashboard');
        $controller = $this->params[0];
        $fields = [];
        $thead = '';
        $dtColumns = '';
        $dtColumnsDef = '';
        // $useStatement = trim(APP_NAMESPACE, '\\') . '\Controllers\BaseController';
        $useStatement = '';
        $extends      = 'BaseController';
        $config = [];

        // Gets the appropriate parent class to extend.
        if ($for!='api') {
            $extends      = 'Controller';
        } 
        else
        {
            $useStatement = ResourcePresenter::class;
            $extends      = 'ResourceController';
        }

        //cek the migration
        $getMigration = $this->getMigration($this->params);
        if($getMigration!=null)
        {
            $fields = $getMigration['fields'];
            $table = $getMigration['table'];
        }
        else
        {
            $migrate = 'Modules\\'.$module.'\\Database\\'.ucfirst($params[0]);
            $execute = false;
            CLI::error("Error : Migration not found : {$migrate}");
            CLI::write("- Please create Migration before create Views",'yellow');
            die();
        }

        $controller = 'Modules\\'.$module.'\\Controllers\\'.ucfirst($for).'\\'.ucfirst($this->params[0]);

        if(class_exists($controller))
        {
            if(method_exists($controller, 'sort'))
            {
                $config['sort'] = true;
            }
        }
        return $this->parseTemplate(
            $class,
            ['{useStatement}', '{extends}','{module}','{controller}'],
            [$useStatement, $extends, ucfirst($module),strtolower($controller)],
            ['for' => $for,'fields'=>$fields,'config'=>$config]
        );
    }
}
