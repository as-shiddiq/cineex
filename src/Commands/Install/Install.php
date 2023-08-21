<?php 
namespace Cineex\Commands\Install;
use Cineex\BaseCommand;
use \CodeIgniter\CLI\CLI;
use Config\Services;
use Throwable;

class Install extends BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Install';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'install';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Installing fresh application from configuration.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'install';

    /**
     * The Command's arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [];

    /**
     * The Command's options
     *
     * @var array<string, string>
     */
    protected $options = [];

    /**
     * Creates a new database.
     */
    public function run(array $params)
    {
        $runner  = Services::commands();
        $dbExists = false;
        $dbName = getenv('database.default.database');
        $forge = \Config\Database::forge('init');
        if($forge->createDatabase($dbName, true))
        {
            CLI::write('✅ Databases '.$dbName.' created!');
        }
        else
        {
            CLI::write('✅ Databases '.$dbName.' has exists');
        }
        CLI::write('✅ Generating default migrations.....');
        $runner->run('migrate',[]);
        CLI::write('✅ Generating default seeder.....');


        $files = array_diff(scandir(ROOTPATH.'app/Database/Seeds'), array('..', '.','.gitkeep'));
        foreach ($files as $file) {
            $f = explode('.',$file)[0];
            $runner->run('db:seed',[$f]);
        }
        CLI::write('✅ Import modules names to database.....');
        $ModuleModel = new \App\Models\ModuleModel();
        foreach (explode(',',getenv('PROJECT_MODULES')) as $file) {
            $check = $ModuleModel->where('module_nama',ucfirst($file))->first();
            
            if($check==NULL)
            {
                CLI::write(ucfirst($file).' success imported','yellow');
                $ModuleModel->skipValidation(true);
                $ModuleModel->insert([
                    'id'=>uuid(),
                    'module_nama'=>ucfirst($file),
                    'module_deskripsi'=>$file,
                    'module_status'=>'A'
                ]);
            }
        }
        CLI::write('Module import completed','green');

        CLI::write('✅ Generating migration from modules.....');
        foreach (explode(',',env('PROJECT_MODULES')) as $file) {
            $nameSpace = 'Modules\\'.ucfirst($file);
            // var_dump($nameSpace);
            $runner->run('migrate',['n'=>$nameSpace]);
        }
        CLI::write('✅ Generating module seeder.....');

        foreach (explode(',',env('PROJECT_MODULES')) as $file) {
            $class = 'Modules\\'.ucfirst($file).'\\Database\\Seeds\\RunSeeder';
            
            if(class_exists($class))
            {
                $runner->run('db:seed',[$class]);
            }
        }
        CLI::write('All proccess completed!','light_blue');
    }
}
