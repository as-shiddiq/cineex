<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;

class Auth extends ResourceController
{
    protected $format = 'json';
    private $url;
    private $table;
    private $primaryKey;
    private $fillable;
    protected $helpers = ['app', 'cineex', 'form', 'tanggal', 'responsedata','auth','nnotif'];

    public function __construct()
    {
    }
    
    public function signin(){
        if($this->request->getMethod()=="post"){
            $PenggunaModel = new \App\Models\PenggunaModel();
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $getPengguna = $PenggunaModel->withAddons()
                                        ->where('pengguna_username',$username)
                                        ->orWhere('pengguna_email',$username)
                                        ->orWhere('pengguna_hp',$username)
                                        ->first();

            $response = [
                'status' => 500,
                'error' => true,
                'message' => "Username atau password salah"
            ];
            if($getPengguna!=null)
            {
                if(password_verify($password, $getPengguna->pengguna_password))
                {
                    if($getPengguna->pengguna_status=='A')
                    {
                        $PenggunaModel->update($getPengguna->id,['signed_at'=>timestamp()]);
                        $config['id'] = $getPengguna->id;
                        $config['level'] = $getPengguna->pengguna_level_nama;

                        $response = [
                            'status' => 200,
                            'error' => false,
                            'message' => "Signin success, please click OK to continue",
                            'redirect' => site_url('dashboard/home'),
                            'token' => setToken($config)
                        ];
                    }
                    else if($getPengguna->pengguna_status=='N')
                    {

                        $response = [
                            'status' => 500,
                            'error' => true,
                            'message' => "Akun sedang dinonaktifkan, mungkin sedang proses aktivasi. Silakan cek email untuk aktivasi"
                        ];
                    }
                    else
                    {

                        $response = [
                            'status' => 500,
                            'error' => true,
                            'message' => "Akun sedang diblokir/ditangguhkan"
                        ];
                    }

                }
            }
        }
        else{
            $response = [
                'status' => 500,
                'error' => true,
                'message' => "Method must with POST"
            ];
        }
        return $this->respond($response, $response['status']);
    }

    public function signout()
    {
        session()->destroy();
        $response = [
                        'status' => 200,
                        'error' => false,
                        'message' => "Semua session telah dihapus",
                        'redirect' => site_url('auth')
                    ];
        return $this->respond($response, $response['status']);
    }

    public function user()
    {
        $auth = auth();
        if($auth!==false)
        {

            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Authorized user",
                'data'=> $auth
            ];
        }
        else
        {

            $response = [
                'status' => 401,
                'error' => true,
                'message' => "Sorry, Unauthorize!!😢",
            ];
        }
        return $this->respond($response, $response['status']);
    }

    public function register()
    {
        if($this->request->getMethod()=="post"){
            helper('text');
            $PenggunaModel = new \App\Models\PenggunaModel();
            $MemberModel = new \App\Models\MemberModel();
            $ServerModel = new \App\Models\ServerModel();
            $penggunaId = Uuid::uuid4()->toString();

            //check total member

            // $getMember = $MemberModel->asArray()->findAll();
            // if(count($getMember)>20)
            // {
            //     $response = [
            //             'status' => 200,
            //             'error' => true,
            //             'message' => "Sorry, for early access only 20 member can register",
            //         ];
            //     return $this->respond($response, $response['status']);
            // }

            //ambil server yang aktif
            $rowServer = $ServerModel->where('server_status','A')
                                    ->orderBy('server_kode', 'RANDOM')
                                    ->first();

            $saved = false;
            $dataPengguna = [
                'id'=>$penggunaId,
                'pengguna_nama'=>$this->request->getPost('member_nama'),
                'pengguna_nama'=>$this->request->getPost('member_nama'),
                'pengguna_email'=>$this->request->getPost('member_email'),
                'pengguna_hp'=>$this->request->getPost('member_hp'),
                'pengguna_status'=>'N',
                'token'=> date('y').random_string('alnum', 15).date('mdhis'),
                'expired_at'=> manipulasiTanggal(timestamp(),120,'minutes','Y-m-d H:i:s'),
                'pengguna_password'=> password_hash($this->request->getPost('pengguna_password'),PASSWORD_DEFAULT),
            ];
            $dataPengguna['pengguna_username'] = generateUsername($dataPengguna['pengguna_nama']);

            ## DATA MEMBER
            $dataMember = $this->request->getPost();
            $dataMember['id'] = Uuid::uuid4()->toString();
            $dataMember['pengguna_id'] = $dataPengguna['id'];
            $dataMember['server_id'] = $rowServer->id;
            $dataMember['member_apikey'] = apiKeyGenerate(50);
            $dataMember['expired_at'] =  manipulasiTanggal(timestamp(),30,'days','Y-m-d H:i:s');
            ## DATA MEMBER

            //cek apakah sudah ada pengguna
            $checkPengguna = $PenggunaModel->where('pengguna_hp',$dataPengguna['pengguna_hp']);
            if($checkPengguna->first()==NULL)
            {
                $PenggunaModel->insert($dataPengguna);
                $MemberModel->insert($dataMember);
                $saved = true;
                $response = [
                        'status' => 200,
                        'error' => false,
                        'message' => "Akun berhasil dibuat, silakan cek pesan Whatsapp untuk mengaktifkan",
                        'redirect' => site_url('auth')
                    ];
            }
            else
            {
                //cek apakah sudah ada member
                $checkMember = $MemberModel->where('member_hp',$dataMember['member_hp']);
                if($checkMember->first()==NULL)
                {
                    $MemberModel->insert($dataMember);
                    $saved = true;
                    $response = [
                            'status' => 200,
                            'error' => false,
                            'message' => "Akun berhasil dibuat, silakan cek pesan Whatsapp untuk mengaktifkan",
                            'redirect' => site_url('auth')
                        ];

                }
                else
                {
                    $response = [
                            'status' => 200,
                            'error' => true,
                            'message' => "No Whatsapp sudah digunakan",
                            'redirect' => site_url('auth')
                        ];
                }
            }
        }
        else
        {
            $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => "Method harus dalam bentuk POST",
                    ];
        }

        if($saved)
        {
            notifRegistrasi($dataPengguna['id'],'Whatsapp');
        }
        return $this->respond($response, $response['status']);
    }


    public function checkunique()
    {
        $PenggunaModel = new \App\Models\PenggunaModel();
        $MemberModel = new \App\Models\MemberModel();
        if($this->request->getMethod()=="post"){
            $get = $MemberModel;
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


    //untuk keperluan reset password
    public function checkmember()
    {
        $PenggunaModel = new \App\Models\PenggunaModel();
        if($this->request->getMethod()=="post"){
            $penggunaEmail = $this->request->getPost('pengguna_email');
            $get = $PenggunaModel->where('pengguna_email',$penggunaEmail)
                                ->orWhere('pengguna_hp',$penggunaEmail)
                                    ->first();
            
            if($get!=null)
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

    public function resetpassword()
    {
        if($this->request->getMethod()=="post"){
            helper('text');
            $PenggunaModel = new \App\Models\PenggunaModel();
            $MemberModel = new \App\Models\MemberModel();
            $penggunaEmail = $this->request->getPost('pengguna_email');
            $checkPengguna = $PenggunaModel->where('pengguna_email',$penggunaEmail)
                                ->orWhere('pengguna_hp',$penggunaEmail)
                                ->first();
            if($checkPengguna!=null)
            {
                $row = $checkPengguna;
                $PenggunaModel->update($row->id,[
                    'token'=> date('y').random_string('alnum', 15).date('mdhis'),
                    'expired_at'=> manipulasiTanggal(timestamp(),30,'minutes','Y-m-d H:i:s')
                ]);
                if(isEmail($penggunaEmail))
                {
                    notifResetPassword($row->id);
                }
                else
                {
                    notifResetPassword($row->id,'Whatsapp');

                }
                $response = [
                            'status' => 200,
                            'error' => false,
                            'message' => "Link konfirmasi reset password sudah dikirim, silakan cek whatssapp/email",
                            'redirect' => site_url('auth')
                        ];
            }
            else
            {

                $response = [
                            'status' => 200,
                            'error' => true,
                            'message' => "Akun tidak ditemukan",
                        ];
            }
        }
        else
        {
            $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => "Method harus dalam bentuk POST",
                    ];
        }

        return $this->respond($response, $response['status']);
    }

    public function newpassword()
    {
        if($this->request->getMethod()=="post"){
            helper('text');
            $token = session()->get('token');

            $PenggunaModel = new \App\Models\PenggunaModel();
            $MemberModel = new \App\Models\MemberModel();
            $penggunaPassword = $this->request->getPost('pengguna_password');
            $checkPengguna = $PenggunaModel->where('token',$token)->first();
            if($checkPengguna!=null)
            {
                $row = $checkPengguna;
                $PenggunaModel->update($row->id,[
                    'token'=> null
                ]);
                if($checkPengguna->pengguna_email!=''  && $checkPengguna->pengguna_email!=NULL )
                {
                    notifNewPassword($row->id);
                }
                
                if($checkPengguna->pengguna_hp!=''  && $checkPengguna->pengguna_hp!=NULL )
                {
                    notifNewPassword($row->id,'Whatsapp');
                }

                $response = [
                            'status' => 200,
                            'error' => false,
                            'message' => "Pasword berhasil diubah, silakan login menggunakan password yang baru",
                            'redirect' => site_url('auth')
                        ];
            }
            else
            {

                $response = [
                            'status' => 500,
                            'error' => true,
                            'message' => "Invalid data token",
                        ];
            }
        }
        else
        {
            $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => "Method harus dalam bentuk POST",
                    ];
        }

        return $this->respond($response, $response['status']);
    }


    public function remove()
    {
        $PenggunaModel = new \App\Models\PenggunaModel();
        $MemberModel = new \App\Models\MemberModel();
        $MemberModel->where('member_email',$this->request->getGetPost('email'))->delete();
        $PenggunaModel->where('pengguna_email',$this->request->getGetPost('email'))->delete();

        $response = [
            'status' => 200,
            'error' => false,
            'message' => "Akun telah dihapus, dengan email : ".$this->request->getGetPost('email'),
            'validate'=>'true'
        ];
        return $this->respond($response, $response['status']);

    }

    function logintest($id)
    {
        if(getenv('app.debug.login')=='true')
        {
            session()->set('userId',$id);
            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Akun ditemukan, klik ok untuk melanjutkan",
                'redirect' => site_url('dashboard/home')
            ];
        }
        else
        {

            $response = [
                        'status' => 404,
                        'error' => true,
                        'message' => "Not found!",
                    ];
        }
        return $this->respond($response, $response['status']);
    }
}
