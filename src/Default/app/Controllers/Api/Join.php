<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Join extends ResourceController
{
    protected $format = 'json';
    private $url;
    private $table;
    private $primaryKey;
    private $fillable;
    protected $helpers = ['app', 'form', 'ntanggal', 'responsedata','auth'];

    public function __construct()
    {
    }
    
    public function module(){
        $auth = auth();
        if($auth!=false){
            $ModuleModel = new \App\Models\ModuleModel();
            $resul = [];
            foreach ($ModuleModel->findAll() as $row) {
                $data = [];
                if($row->module_status=='D')
                {

                }
                else
                {
                    $getModules = getAllMigrations($row->module_nama);
                    if($getModules!=null)
                    {
                        foreach($getModules as $r)
                        {
                            $field = $r['table'].'_nama';
                            if(array_key_exists($field,$r['fields']))
                            {
                                $data['id'] = $r['table'];
                                $data['text'] = $r['table'] ;
                                $result[] = $data;
                            }
                        }
                    }
                }
            }    
            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data ditemukan",
                'data' => $result,
            ];
            
        }
        else{

            $response = [
                'status' => 401,
                'error' => false,
                'message' => "Sorry, Unauthorize!!😢",
            ];
        }
        return $this->respond($response, $response['status']);
    }

    public function value(){
        $auth = auth();
        $table = $this->request->getGet('table');
        $text = $table.'_nama';
        if($auth!=false){
            $db = db_connect();
            $builder = $db->table($table)->get();
            $result = [];
            foreach ($builder->getResult() as $row) {
                $data = [];
                $data['id'] = $row->id;
                $data['text'] = $row->$text;
                $result[] = $data;
            }    
            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data ditemukan",
                'data' => $result,
            ];
            
        }
        else{

            $response = [
                'status' => 401,
                'error' => false,
                'message' => "Sorry, Unauthorize!!😢",
            ];
        }
        return $this->respond($response, $response['status']);
    }
}
