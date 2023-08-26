<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'pengguna_level_id',
        'pengguna_foto',
        'pengguna_nama',
        'pengguna_username',
        'pengguna_password',
        'pengguna_email',
        'pengguna_status',
        'pengguna_hp',
        'expired_at',
        'signed_at',
        'token',
        'otp',
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
    protected $validationRules      = [
        'id'    => 'alpha_numeric_punct',
        'pengguna_username' => "required|is_unique[pengguna.pengguna_username,id,{id}]"
    ];
    protected $validationMessages   = [
     'pengguna_username' => [
            'is_unique' => 'Maaf, username yang dimasukkan telah digunakan.',
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

    private $auth;

    function withAddons($set='',$config=[]){
        if($this->auth==null)
        {
            $this->auth = auth();
        }
        $request = \Config\Services::request();
        $get = $this->select($this->table.'.*')
                    ->select('pengguna_level_nama')
                    ->join('pengguna_level','pengguna.pengguna_level_id=pengguna_level.id');
        if(isset($config['skiplevel']))
        {
            foreach ($config['skiplevel'] as $r) {
                $this->where('pengguna_level_nama !=',$r);
            }
        }
        return $get;
    }

    public function getResult($id='')
    {
        $request = \Config\Services::request();

        //ambil data 
        $PenggunalevelModel = new \App\Models\PenggunalevelModel();
        $skipLevel = [];
        foreach ($PenggunalevelModel->findAll() as $row) {
            $modules = ucfirst($row->pengguna_level_nama);
            $getModel = '\\Modules\\'.$modules.'\\Models\\'.$modules.'penggunaModel';
            if(class_exists($getModel))
            {
                $skipLevel[] = $modules;
            }
        }

        $getData = $this->asArray();
        $config['skipColumn'] = [];
        $config['whereColumn'] = [];
        $config['column'] = $this->allowedFields;
        $config['id'] = $id;
        $config['table'] = $this->table;
        $config['debug'] = false;
        $config['skiplevel'] = $skipLevel;
        $result = responseData($getData,$config);
        // echo $getData->getCompiledSelect();
        //set default
        $data = $result['data'];
        foreach ($data as $key => $value) {
            $data[$key]['text']=$data[$key]['pengguna_nama'];
            $data[$key]['pengguna_foto_url']=uploads('pengguna',$data[$key]['pengguna_foto'],'user.png');
            $data[$key]['created_at_mask_full']=dateTimeToStandarTanggal($data[$key]['created_at'],TRUE);
            $data[$key]['created_at_mask']=dateTimeToStandarTanggal($data[$key]['created_at']);
            $data[$key]['updated_at_mask_full']=dateTimeToStandarTanggal($data[$key]['updated_at'],TRUE);
            $data[$key]['updated_at_mask']=dateTimeToStandarTanggal($data[$key]['updated_at']);
            $data[$key]['pengguna_level_nama_html']=penggunaLevel($data[$key]['pengguna_level_nama']);
            unset($data[$key]['pengguna_password']);
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
            if(isset($data['pengguna_password']))
            {
                $data['pengguna_password'] = password_hash($data['pengguna_password'],PASSWORD_DEFAULT);
            }
            else
            {
                unset($data['pengguna_password']);
            }

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
            if($data==null)
            {
                $data = requestAll($this->allowedFields,'getRawInput');
            }
            $data = defaultValue('update',$data);
            if(isset($data['pengguna_password']))
            {
                $data['pengguna_password'] = password_hash($data['pengguna_password'],PASSWORD_DEFAULT);
            }
            else
            {
                unset($data['pengguna_password']);
            }

            if($auth->pengguna_level_nama=='Administrator')
            {
                unset($data['pengguna_hp']);
                unset($data['pengguna_email']);
            }
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
        else{
            return false;
        }
   
    }

    function deleteData($id=null,$data=null)
    {
        $auth = auth();
        if($auth!=false)
        {
            $this->where($this->primaryKey,$id)
                    ->delete();
            return ['id'=>$id];
        }
        else{
            return false;
        }
   
    }
}
