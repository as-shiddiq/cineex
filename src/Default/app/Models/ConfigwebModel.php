<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigwebModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'config_web';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'config_web_nama',
        'config_web_deskripsi',
        'config_web_hp',
        'config_web_alamat',
        'config_web_email',
        'config_web_meta_description',
        'config_web_meta_keyword',
        'config_web_script_top',
        'config_web_script_bottom',
        'config_web_script_setting',
        'config_web_icon_light',
        'config_web_icon_dark',
        'config_web_logo_light',
        'config_web_logo_dark',
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
        foreach ($data as $key => $value) {
            $data[$key]['text']=$data[$key]['config_web_nama'];
            $data[$key]['config_web_icon_light_url']=uploads('configweb',$data[$key]['config_web_icon_light']);
            $data[$key]['config_web_icon_dark_url']=uploads('configweb',$data[$key]['config_web_icon_dark']);
            $data[$key]['config_web_logo_light_url']=uploads('configweb',$data[$key]['config_web_logo_light']);
            $data[$key]['config_web_logo_dark_url']=uploads('configweb',$data[$key]['config_web_logo_dark']);

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
}