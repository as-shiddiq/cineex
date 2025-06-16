<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'module';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'module_deskripsi',
        'module_nama',
        'module_urutan',
        'module_status',
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
    // Validation
    // Validation
    protected $validationRules      = [
        'id'    => 'alpha_numeric_punct',
        'module_nama' => "required|is_unique[module.module_nama,id,{id}]"
    ];
    protected $validationMessages   = [
     'module_nama' => [
            'is_unique' => 'Maaf, class sudah ada.',
        ]];
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



    function withAddons($setConfig = array()){
        $request = \Config\Services::request();
        $get = $this->select($this->table.'.*');
        return $get;
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
            $data[$key]['text']=$data[$key]['module_nama'];
        }
        return ['data'=>$data,'meta'=>$result['meta']];
    }

    function insertData($data=null)
    {
        $auth = auth();
        $request = \Config\Services::request();
        if($auth!=false)
        {
            if($data==null)
            {
                $data = requestAll($this->allowedFields,'POST');
            }
            $data = defaultValue('create',$data);
            $data['module_status'] = 'A';
            $this->insert($data);
            return ['id'=>$data['id']];
        }
        else{
            return false;
        }
    }

    function updateData($id=null,$data=null)
    {
        $auth = auth();
        $request = \Config\Services::request();

        if($auth!=false)
        {
            if($data==null)
            {
                $data = requestAll($this->allowedFields,'getRawInput');
            }
            
            $data = defaultValue('update',$data);
            $data['module_status'] = 'A';
            $this->where($this->primaryKey,$id)
                    ->set($data)
                    ->update();
            return ['id'=>$id];
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
            $check = $this->where('id',$id)->first();
            if($check==null)
            {
                throw new \Exception("Module tidak ditemukan", 1);
            }
            if($check->module_status=='D')
            {
                throw new \Exception("Tidak bisa hapus module", 1);
            }
            $this->where($this->primaryKey,$id)
                    ->delete();
            return ['id'=>$id];
        }
        else{
            return false;
        }
    }

    function nestedData($id='')
    {
        $getData=$this->withAddons()->orderBy('module_urutan','ASC');
        $result=[];
        foreach ($getData->findAll() as $row) {
          $result[]=['id'=>$row->id,'parent_id'=>null,'text'=>$row->module_nama,'others'=>[
            'module_status' => $row->module_status,
            'module_deskripsi' => $row->module_deskripsi
          ]];
        }
        $result=buildNested($result);
        return $result;
    }

    function updateNested($data=[],$id='')
    {
        $data=json_decode($data,TRUE);
        $newData=flattenNested($data);
        $i = 0;
        foreach ($newData as $key => $value) {
            //update data
            $ins = $this->set(['module_urutan'=>$i++])
                    ->where('id',$value['id'])
                    ->update();
        }
    }
}
