<@php

namespace {namespace};

use CodeIgniter\Model;

class {class} extends Model
{
    protected $DBGroup          = '{dbGroup}';
    protected $table            = '{table}';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = {return};
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [{fields}];

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
        $get = {select};
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
        $data = $result['data'];
        foreach ($data as $key => $value) {
            $data[$key]['text']=$data[$key]['{setText}']; 
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
            $exec = $this->insert($data);
            if(!$exec)
            {
                return false;
            }
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

            $exec = $this->where($this->primaryKey,$id)
                            ->set($data)
                            ->update();
            if(!$exec)
            {
                return false;
            }
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
            $this->where($this->primaryKey,$id)
                    ->delete();
            return ['id'=>$id];
        }
        else{
            throw new \Exception('Maaf anda tidak memiliki akses');
        }
    }

<?php if($nested){ ?>
    function nestedData($id='')
    {
        $getData=$this->withAddons()->orderBy('{nestedSort}','ASC');
        $result=[];
        foreach ($getData->findAll() as $row) {
          $result[]=['id'=>$row->id,'parent_id'=>$row->{nestedParent},'text'=>$row->{nestedText},'others'=>[
          ]];
        }
        $result=buildNested($result);
        return $result;
    }

    function updateNested($data=[],$id='')
    {
        $data=json_decode($data,TRUE);
        $newData=flattenNested($data);
        $i = 1;
        foreach ($newData as $key => $value) {
            //update data
            $this->set(['{nestedSort}'=>$i++,'{nestedParent}'=>$value['parent_id']])
                    ->where('id',$value['id'])
                    ->update();
        }
    }
<?php } ?>
}
