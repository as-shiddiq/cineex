<?php
###########################################################
##      Created by Nasrullah Siddik                      ##
##      email : nasrullahsiddik@gmail.com                ##
##      linkedin : https://id.linkedin.com/in/as-shiddiq ##
##      github : https://github.com/as-shiddiq           ##
##      gitlab : https://gitlab.com/as-shiddiq           ##
###########################################################
namespace Cineex;

class Cineex {

    function pathModule()
    {
        return ROOTPATH.'modules/';
    }

    function scanDirModule() 
    {
        $path = $this->pathModule();
        $files = [];
        $db = db_connect();
        if ($db->tableExists('module')) {
            $ModuleModel = new \App\Models\ModuleModel;
            $getModule = $ModuleModel->where('module_status','A')
                                    ->orderBy('module_urutan','ASC')->findAll();
            foreach ($getModule as $r) {
                if(file_exists($path.$r->module_nama))
                {
                    $files[]=$r->module_nama;
                }
            }
        }
        return $files;
    }

    function getAllMigrations($module)
    {
        $mDir = pathModule().ucfirst($module)."/Database/Migrations";
        $data = [];
        $table = '';
        $fields = [];
        if(is_dir($mDir))
        {
            
            $files = array_diff(scandir($mDir), array('..', '.','.gitkeep'));
            foreach ($files as $r) {
                $clean = explode('_',$r)[1];
                $clean = explode('.',$clean)[0];
                // load the migration
                if(file_exists($mDir.'/'.$r))
                {
                    include_once $mDir.'/'.$r;
                    $class = "\\Modules\\".ucfirst($module)."\\Database\\Migrations\\".$clean;
                    $m = new $class;
                    $f = $m->fields;
                    unset($f['created_at']);
                    unset($f['updated_at']);
                    unset($f['deleted_at']);
                    //parsing
                    $meta = null;
                    $meta['fields'] = $m->fields;
                    $meta['table'] = $m->table;
                    $meta['file'] = $clean;
                    $data[] = $meta;
                }
            }
        }
        return $data;
    }

    function renderView($module='',$data = [])
    {
        extract($data);
        return view('Modules\\'.ucfirst($module).'\\Views\\'.ucfirst($render).'\\'.ucfirst($view),$data);
    }

    function includeView($render='main',$file='')
    {
        dd($render);
        $include = FCPATH.'templates/'.env('cineex.template.'.$render).'/app/Layout/'.$file;
        return $include;
    }
}
