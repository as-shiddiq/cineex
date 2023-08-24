<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use \App\Controllers;

class Profil extends ResourceController
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

    #######################################
    ##            UPDATE                 ##
    #######################################

    public function update($url=NULL,$id=NULL){
        // set model
        $auth = Auth();
        if($auth!=false){
            $PenggunaModel=new \App\Models\PenggunaModel;
            // $MemberModel=new \App\Models\MemberModel;
            if($this->request->getMethod()=="put"){
                if($this->request->getRawInput()!=NULL){
                    $invalid = false;
                    $userId = $auth->id;
                    $konfirmasiPassword = $this->request->getRawInput()['konfirmasi_password'];
                    //cek user = 
                    $checkUser = $PenggunaModel->where('pengguna.id',$userId)->first();
                    if(!password_verify($konfirmasiPassword,$checkUser->pengguna_password))
                    {
                        $response = [
                            'status' => 500,
                            'error' => true,
                            'message' => 'Password untuk konfirmasi tidak sesuai',
                            'validate'=>'false'
                        ];
                    }
                    else
                    {
                        if($PenggunaModel->updateData($userId)===false){
                            $response = [
                                'status' => 500,
                                'error' => true,
                                'message' => $model->errors(),
                                'validate'=>'false'
                            ];
                        }
                        else{
                            if($auth->pengguna_level_nama=='Member')
                            {
                                $memberId = $auth->member_id;
                                //update data member
                                $MemberModel->set([
                                        'member_nama' => $this->request->getRawInput()['pengguna_nama']
                                    ])
                                    ->where('member.pengguna_id',$userId)
                                    ->update();

                            }
                            $response = [
                                'status' => 200,
                                'error' => false,
                                'message' => "Profil berhasil diupdate!",
                                'validate'=>'true'
                            ];
                        }
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
    
    public function checkunique($id='')
    {
        $PenggunaModel = new \App\Models\PenggunaModel();
        if($this->request->getMethod()=="post"){
            $get = $PenggunaModel->where('pengguna.id !=',$id);
            foreach($this->request->getPost() as $key => $value)
            {
                $get->where($key,$value);
            }
            if($get->first()==null)
            {
                $response = [
                            'status' => 200,
                            'isReady' => true,
                        ];
            }
            else
            {
                $response = [
                            'status' => 200,
                            'isReady' => false,
                        ];
            }
        }            
        else{
            $response = [
                'status' => 500,
                'error' => true,
                'message' => "Method harus dalam bentuk POST",
                'validate'=>'true'
            ];
        }
        return $this->respond($response, $response['status']);
    }
}
