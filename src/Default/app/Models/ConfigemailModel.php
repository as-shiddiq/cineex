<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigemailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'config_email';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'config_email_nama',
        'config_email_host',
        'config_email_smptsecure',
        'config_email_smtpauth',
        'config_email_username',
        'config_email_password',
        'config_email_port',
        'config_email_footnote',
        'config_email_footer',
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
    protected $validationRules      = [];
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
        foreach ($data as $key => $value) {
            $data[$key]['text']=$data[$key]['config_email_nama'];

        }
        return ['data'=>$data,'meta'=>$result['meta']];
    }

    function insertData($data=null)
    {
        $auth = Auth();
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
        $auth = Auth();
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
        $auth = Auth();
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
}
