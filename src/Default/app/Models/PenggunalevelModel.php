<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunalevelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengguna_level';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'pengguna_level_nama',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'pengguna_level_nama' => "required|is_unique[pengguna_level.pengguna_level_nama,id,{id}]"
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function withAddons(){
        $request = \Config\Services::request();
        return $this->select($this->table.'.*');
    }

    public function getResult($id='')
    {
        $request = \Config\Services::request();
        $getData = $this->asArray();
        $config['skipColumn'] = [];
        $config['whereColumn'] = [];
        $config['column'] = $this->allowedFields;
        $config['id'] = $id;
        $config['table'] = $this->table;
        $config['debug'] = false;
        $result = responseData($getData,$config);

        // echo $getData->getCompiledSelect();
        //set default
        $data = $result['data'];
        foreach ($data as $key => $value) {
            $data[$key]['text']=$data[$key]['pengguna_level_nama'];
            $data[$key]['created_at_mask_full']=dateTimeToStandarTanggal($data[$key]['created_at'],TRUE);
            $data[$key]['created_at_mask']=dateTimeToStandarTanggal($data[$key]['created_at']);
            $data[$key]['updated_at_mask_full']=dateTimeToStandarTanggal($data[$key]['updated_at'],TRUE);
            $data[$key]['updated_at_mask']=dateTimeToStandarTanggal($data[$key]['updated_at']);
        }
        return ['data'=>$data,'meta'=>$result['meta']];
    }

    
    function insertData($data=null)
    {
        $auth = auth();
        if($auth!=false)
        {
            if($data==null)
            {
                $data = requestAll($this->allowedFields,'POST');
            }
            $data = defaultValue('create',$data);
            $exec = $this->insert($data);
            if($exec!==false)
            {
                return ['id'=>$data['id']];
            }
            else
            {
                return false;
            }
        }
        else{
            return false;
        }
    }

    function updateData($id=null,$data=null)
    {
        $auth = auth();
        if($auth!=false)
        {
             if($checkLevel->pengguna_level_nama=='Administrator')
            {
                throw new \Exception('Administrator is default level');
            }
            else
            {
                if($data==null)
                {
                    $data = requestAll($this->allowedFields,'getRawInput');
                }
                $data = defaultValue('update',$data);
                $exec = $this->where($this->primaryKey,$id)
                        ->set($data)
                        ->update();
                
                if($exec!==false)
                {
                    return ['id'=>$data['id']];
                }
                else
                {
                    return false;
                }
            }
        }
        else{
            return false;
        }
   
    }

    function deleteData($id=null,$data=null)
    {
        $auth = auth();
        if($auth!=false)
        {
            $checkLevel = $this->where('id',$id)->first();
            if($checkLevel->pengguna_level_nama=='Administrator')
            {
                throw new \Exception('Administrator is default level');
            }
            else
            {
                $this->where($this->primaryKey,$id)
                        ->delete();
            }
            return ['id'=>$id];
        }
        else{
            return false;
        }
   
    }
}
