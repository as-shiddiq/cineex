<?php 
namespace Cineex\Commands\Generators;
use Cineex\BaseCommand;
use Cineex\GeneratorTrait;
use \CodeIgniter\CLI\CLI;
use Config\Services;
use Throwable;

class SitemapGenerator extends BaseCommand
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
    protected $name = 'make:sitemap';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Generates a new sitemap file in modules.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'make:sitemap <module>';

    /**
     * The Command's arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [
        'module'=>'Module name',
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
        $module = $this->getOption('module');
        $runner  = Services::commands();
        $for = $this->getOption('for')??'dashboard';
        $this->component = 'Controller';
        $this->directory = ucfirst($params[0]).'\\Config';
        $this->template  = 'sitemap.tpl.php';
        $params['fileName'] = 'Sitemaps';
        $this->classNameLang = 'CLI.generator.className.controller';
        $this->execute($params);
	}

    /**
     * Prepare options and do the necessary replacements.
     */
    protected function prepare(string $class): string
    {
        $for = strtolower($this->getOption('for')??'dashboard');
        $module = ucfirst($this->params[0]);

        // $useStatement = trim(APP_NAMESPACE, '\\') . '\Controllers\BaseController';
        $useStatement = '';
        $extends      = 'BaseController';
        $classList = $this->listControllerMethod($this->params);

        return $this->parseTemplate(
            $class,
            ['{useStatement}', '{extends}','{module}'],
            [$useStatement, $extends,$module],
            ['for' => $for,'classList'=>$classList]
        );
    }
}
