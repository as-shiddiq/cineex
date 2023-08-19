<?php 
namespace Cineex\Commands\Generators;
use Cineex\BaseCommand;
use Cineex\GeneratorTrait;
use \CodeIgniter\CLI\CLI;
use Config\Services;
use Throwable;

class ControllerGenerator extends BaseCommand
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
    protected $name = 'make:controller';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Generates a new controller file in modules.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'make:controller <name> [option]';

    /**
     * The Command's arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [
        'name'=>'Controllers name',
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
        $module = $this->getOption('module');
        $runner  = Services::commands();
        $for = $this->getOption('for')??'dashboard';
        $this->component = 'Controller';
        $this->directory = 'Controllers\\'.ucfirst($for);
        $this->template  = 'controller.tpl.php';

        $this->classNameLang = 'CLI.generator.className.controller';
        $this->execute($params);

        $checkBaseController = 'Modules\\'.$module.'\\Controllers\\'.ucfirst($for).'\\BaseController';
        if(!class_exists($checkBaseController))
        {
            $this->component = 'BaseController';
            $this->template  = 'basecontroller.tpl.php';
            $params['fileName'] = ucfirst('BaseController');
            $this->classNameLang = 'CLI.generator.className.controller';
            $this->execute($params);
        }
	}

    /**
     * Prepare options and do the necessary replacements.
     */
    protected function prepare(string $class): string
    {
        $module = $this->getOption('module');
        $for = strtolower($this->getOption('for')??'dashboard');
        $controller = $this->params[0];
        if($module=='')
        {
            CLI::write("Controller can't create, --module is required", 'red');
            exit();
        }

        // $useStatement = trim(APP_NAMESPACE, '\\') . '\Controllers\BaseController';
        $useStatement = '';
        $extends      = 'BaseController';

        // Gets the appropriate parent class to extend.
        if ($for=='api') {
            $useStatement = ResourcePresenter::class;
            $extends      = 'ResourceController';
        }
        // elseif ($rest) {
        //     $rest = is_string($rest) ? $rest : 'controller';

        //     if (! in_array($rest, ['controller', 'presenter'], true)) {
        //         // @codeCoverageIgnoreStart
        //         $rest = CLI::prompt(lang('CLI.generator.parentClass'), ['controller', 'presenter'], 'required');
        //         CLI::newLine();
        //         // @codeCoverageIgnoreEnd
        //     }

        //     if ($rest === 'controller') {
        //         $useStatement = ResourceController::class;
        //         $extends      = 'ResourceController';
        //     } elseif ($rest === 'presenter') {
        //         $useStatement = ResourcePresenter::class;
        //         $extends      = 'ResourcePresenter';
        //     }
        // }

        return $this->parseTemplate(
            $class,
            ['{useStatement}', '{extends}','{module}','{controller}'],
            [$useStatement, $extends, ucfirst($module),strtolower($controller)],
            ['for' => $for]
        );
    }
}
