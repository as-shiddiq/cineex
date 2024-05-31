<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use \App\Controllers;
use \Firebase\JWT\JWT;

class Restful extends ResourceController
{
    protected $format = 'json';
    private $url;
    private $table;
    private $primaryKey;
    private $fillable;
    protected $helpers = ['app', 'cineex', 'form', 'tanggal', 'responsedata','auth'];

    public function __construct()
    {
    }
    private function _setModel($url)
    {
        $className = '\\App\\Models\\' . ucfirst($url) . 'Model';
        if(!class_exists($className))
        {
            $founded = false;
            foreach (scanDirModule() as $key => $value) {
                if($founded==false)
                {
                    $className = '\\Modules\\'.$value.'\\Models\\' . ucfirst($url) . 'Model';
                    if(class_exists($className))
                    {
                        $founded = true;
                        continue;
                    }
                }
            }
        }
        $model = new $className;
        return $model;
    }

    
    public function data($url="",$id='',...$args){
        $auth = auth();
        if($auth!=false){
            $model=$this->_setModel($url);
            $result=$model->getResult($id,$args);
            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data ditemukan",
                'data' => $result['data'],
                'recordsTotal' => $result['meta']['total'],
                'recordsFiltered' => $result['meta']['total_filtered'],
                'meta' => $result['meta'],
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

    #######################################
    ##           GET NESTABLE           ##
    #######################################

    public function nested($url = NULL, $id = '')
    {
        $auth = auth();
        if($auth != false){
            $model = $this->_setModel($url);
            $data = $model->nestedData($id);
            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data ditemukan",
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 401,
                'error' => false,
                'message' => "Sorry, Unauthorize!!😢",
            ];
        }
        return $this->respond($response, $response['status']);
    }
    
    #######################################
    ##           UPDATE NESTABLE         ##
    #######################################

    public function updatenested($url=NULL,$id=NULL){
        $auth = auth();
        if($auth!=false){
            $model=$this->_setModel($url);
            if(strtolower($this->request->getMethod())=="put"){
                if($this->request->getRawInput()!=NULL){
                    $data=$this->request->getRawInput()['data'];
                    $model->updateNested($data,$id);
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'message' => "Urutan data telah diperbarui",
                        'validate'=>'true'
                    ];
                }
                else
                {
                    $response = [
                        'status' => 200,
                        'error' => true,
                        'message' => "Tidak ada data yang diperbarui",
                        'validate'=>'false'
                    ];
                }
            }
            else{
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => "Method harus dalam bentuk PUT",
                    'validate'=>'true'
                ];
            }
        }
        else{

            $response = [
                'status' => 401,
                'error' => true,
                'message' => "🙅 Unauthorized User!"
            ];
        }
        return $this->respond($response, $response['status']);
    }
    #######################################
    ##              CREATE               ##
    #######################################

    public function create($url=NULL){
        $auth = auth();
        if($auth!==false){
            // set model
            $model=$this->_setModel($url);
            if($this->request->getPost()){
                try {
                    $insert = $model->insertData();
                    if($insert)
                    {
                        $response = [
                            'status' => 200,
                            'error' => false,
                            'message' => "Data sukses ditambahkan",
                            'validate'=>'true',
                            'id'=>$insert['id']
                        ];
                    }
                    else
                    {
                        $response = [
                            'status' => 500,
                            'error' => true,
                            'message' => $model->errors(),
                            'validate'=>'true',
                            'id'=>null
                        ];
                    }
                } catch (\Exception $e) {
                    $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => $e->getMessage(),
                        'validate'=>'false'
                    ];
                }
            }
            else
            {
                $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => 'Unavailable payload with method POST',
                        'validate'=>'false'
                    ];
            }
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

    
    #######################################
    ##            UPDATE                 ##
    #######################################

    public function update($url=NULL,$id=NULL){
        // set model
        $auth = auth();
        if($auth!=false){
            $model=$this->_setModel($url);
            if(strtolower($this->request->getMethod())=="put"){
                if($this->request->getRawInput()!=NULL){
                    try {
                        $update = $model->updateData($id);
                        if($update)
                        {
                            $response = [
                                'status' => 200,
                                'error' => false,
                                'message' => "Data updated!",
                                'validate'=>'true',
                                'id'=>$update['id']
                            ];
                        }
                        else
                        {
                            $response = [
                                'status' => 500,
                                'error' => true,
                                'message' => $model->errors(),
                                'validate'=>'true',
                                'id'=>null
                            ];
                        }
                    } catch (\Exception $e) {
                        $response = [
                            'status' => 500,
                            'error' => true,
                            'message' => $e->getMessage(),
                            'validate'=>'false'
                        ];
                    }
                }
            }
            else{
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => "Method harus dalam bentuk PUT",
                    'validate'=>'true'
                ];
            }
        }
        else{
            $response = [
                'status' => 401,
                'error' => true,
                'message' => "Sorry, Unauthorize!!😢",
                'validate'=>'false'
            ];
        }
        return $this->respond($response, $response['status']);
    }
    
    ##################################
    ##            DELETE            ##
    ##################################

    public function delete($url="",$id=""){
        $auth = auth();
        if($auth!=false){
            $model=$this->_setModel($url);
            if(strtolower($this->request->getMethod())=="delete"){
                try {
                    if($this->request->getRawInput()!=NULL){
                        $id=$this->request->getRawInput()['id'];
                    }
                    else if($this->request->getGet('id')!=NULL){
                        $id=$this->request->getGet('id');
                    }
                    $ex=explode(',', $id);
                    foreach ($ex as $key => $value) {
                        $model->deleteData($value);
                    }
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'message' => 'Data yang dipilih telah dihapus'
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => $e->getMessage()
                    ];
                }
            }
            else{
                $response = [
                    'status' => 500,
                    'error' => false,
                    'message' => "Method harus dalam bentuk DELETE",
                ];
                return $this->respond($response, 200);
            }
        }
        else{
            $response = [
                'status' => 401,
                'error' => true,
                'message' => "Sorry, Unauthorize!!😢",
                'validate'=>'false'
            ];
        }
        return $this->respond($response, $response['status']);
    }
    
    ##################################
    ##            UNGGAH            ##
    ##################################
    public function upload($url='',...$dir){
        $auth = auth();
        if($auth!=false )
        {
            $file = $this->request->getFile('file');
            if(count($dir)>0)
            {
                $dir = $url.'/'.implode('/',$dir);
            }
            else
            {
                $dir = $url;
            }
            $newName = $file->getRandomName();

            //configuration for validation by URL/Path
            if($url=='userlevel')
            {
                $configValidate = [
                 'file' => [
                    'uploaded[file]',
                    'mime_in[file,jpg,image/jpeg,image/gif,image/png,application/pdf]',
                    'max_size[file,4096]',
                ]];
            }
            else
            {
                $configValidate = [
                 'file' => [
                    'uploaded[file]',
                    'mime_in[file,jpg,image/jpeg,image/gif,image/png,application/pdf]',
                    'max_size[file,4096]',
                ]];
            }

            $validated = $this->validate($configValidate);
            if($validated)
            {
                if ($file->isValid() && ! $file->hasMoved())
                {
                    $file->move(FCPATH.'uploads/'.$dir.'/', $newName);
                    $fileUrl = base_url('uploads/'.$dir.'/'.$newName);
                    //
                    if($this->request->getPost('compress'))
                    {
                        $image = \Config\Services::image();
                        $targetCompress = FCPATH.'uploads/'.$dir.'/compress';
                        if(!file_exists($targetCompress))
                        {
                            mkdir($targetCompress);
                        }
                        $image->withFile(FCPATH.'uploads/'.$dir.'/'.$newName)
                                    ->save(FCPATH.'uploads/'.$dir.'/compress/'.$newName, 80);
                        $fileUrl = base_url('uploads/'.$dir.'/compress/'.$newName);
                    }

                    $response = [
                        'status' => 200,
                        'error' => false,
                        'message' => 'Unggah sukses dilakukan',
                        'file'=> $newName,
                        'file_url'=> $fileUrl,
                    ];
                    // if($auth->pengguna_level_nama!=='Administrator')
                    // {
                    //     unset($response['file_url']);
                    // }
                    return $this->respond($response, 200);
                }
                else{
                    $response = [
                        'status' => 200,
                        'error' => true,
                        'message' => $file->errors(),
                        'file'=> ''
                    ];
                }
            }
            else
            {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => $this->validator->getErrors()['file'],
                ];
            }
            
        }
        else
        {
            $response = [
                'status' => 401,
                'error' => false,
                'message' => "Sorry, Unauthorize!!😢",
            ];
        }
        return $this->respond($response, $response['status']);
    }


    #######################################
    ##              CROPPIE              ##
    #######################################

    public function base64Image($url="",$id='',$lainnya=''){
        helper('text');
        $auth = auth();
        if($auth!=false){
            $dir = FCPATH.'uploads/'.$url;
            if(!file_exists($dir))
            {
                mkdir($dir);
            }
            $image = $this->request->getPost('file');
            $img = str_replace('data:image/png;base64,', '', $image);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $imageName = random_string('alnum',16).date('ymdhis').'.png';
            file_put_contents($dir.'/'.$imageName, $data);
            $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'Foto sukses di unggah',
                    'images'=>$imageName,
                    'images_url'=>uploads($url,$imageName),
                ];
            return $this->respond($response, 200);
        }
        else{
            $response = [
                'status' => 401,
                'error' => true,
                'message' => "Sorry, Unauthorize!!😢",
                'validate'=>'false'
            ];
        }
        return $this->respond($response, $response['status']);

    }
    ##################################
    ##            UNGGAH            ##
    ##################################
    public function createcsv(){
        $auth = auth();
        if($auth != false)
        {
            $dir = '';
            if($this->request->getGet('dir'))
            {
                $dir .= '/'.$this->request->getGet('dir').'/';
            }
            $data = json_decode($this->request->getPost('data'),TRUE);

            $randomName = md5(uniqid(rand(), true)) . '.csv';

            if(!is_dir(FCPATH.$dir))
            {
                mkdir($dir, 0777, true);
            }
            $filePath = FCPATH.$dir.$randomName;

            try {
                $file = fopen($filePath, 'w');
                $headers = array_keys($data[0]);
                fputcsv($file, $headers, ';');
                foreach ($data as $row) {
                    fputcsv($file, $row, ';');
                }

                fclose($file);

                $response = [
                    'status' => 200,
                    'error' => false,
                    'message' => 'File CSV sukses dibuat',
                    'file'=> $randomName,
                    'file_url'=> site_url($dir.$randomName),
                ];
                // if($auth->pengguna_level_nama!=='Administrator')
                // {
                //     unset($response['file_url']);
                // }
            } catch (\Exception $e) {
                die();
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => $e->getMessage(),
                    'file'=> ''
                ];
                var_dump($response);
                die();
            }
        }
        else
        {
            $response = [
                'status' => 401,
                'error' => true,
                'message' => "Sorry, Unauthorize!!😢",
                'validate'=>'false'
            ];
        }
        return $this->respond($response, $response['status']);
    }


    // importing data by json with name "data
    public function importjson($url="",$id=""){
        $auth = auth();
        if($auth!=false){
            $model=$this->_setModel($url);
            // set model
            if(strtolower($this->request->getMethod())=="post"){
                try {
                    $model->importJSON();
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'message' => 'Data yang dikirim berhasil diimport'
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => $e->getMessage()
                    ];
                }
            }
            else{
                $response = [
                    'status' => 500,
                    'error' => false,
                    'message' => "Method harus dalam bentuk POST",
                ];
                return $this->respond($response, 200);
            }
        }
        else{
            $response = [
                'status' => 401,
                'error' => true,
                'message' => "Sorry, Unauthorize!!😢",
                'validate'=>'false'
            ];
        }
        return $this->respond($response, $response['status']);

        /** EXAMPLE MODEL **/

        // function importJSON()
        // {
        //     $request = \Config\Services::request();
        //     $auth = auth();
        //     if($auth!=false)
        //     {
        //         $get = $request->getJSON();
        //         foreach ($get as $k => $r) {
        //             // try importing
        //            $data = [
        //                 "id" => uuid(),
        //                 "kode" => $r[0]??'',
        //             ];
        //             $check = $this->where('kode',$data['kode'])
        //                             ->first();
        //             if($check==NULL)
        //             {
        //                 $this->insert($data);
        //             }
        //             else
        //             {
        //                 unset($data['id']);
        //                 $this->where('id',$check->id)
        //                         ->set($data)
        //                         ->update();
        //             }
        //         }
        //     }
        //     else{
        //         throw new \Exception('Maaf anda tidak memiliki akses');
        //     }
        // }
    }

}
