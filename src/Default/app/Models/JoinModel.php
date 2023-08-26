<?php

namespace App\Models;

use CodeIgniter\Model;

class JoinModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'join';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'join_from_id',
        'join_to_id',
        'join_from',
        'join_to',
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
        $db = db_connect();
        foreach ($data as $key => $value) {
            $data[$key]['text']=$data[$key]['join_from'];

            $fromTable = $data[$key]['join_from'];
            $getFrom = $db->table($fromTable)
                                ->where('id',$data[$key]['join_from_id'])->get()->getRowArray();
            $data[$key]['join_from_nama'] = $getFrom!=null?$getFrom[$fromTable.'_nama']:'-';

            $toTable = $data[$key]['join_to'];
            $getTo = $db->table($toTable)
                                ->where('id',$data[$key]['join_to_id'])->get()->getRowArray();
            $data[$key]['join_to_nama'] = $getTo!=null?$getTo[$toTable.'_nama']:'-';


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
            if($data['join_to']=='')
            {
                return $this->deleteData($id);
            }
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
            $this->where($this->primaryKey,$id)
                    ->delete();
            return ['id'=>$id];
        }
        else{
            return false;
        }
    }

}
