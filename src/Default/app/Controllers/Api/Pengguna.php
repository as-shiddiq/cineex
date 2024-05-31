<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use \App\Controllers;

class Pengguna extends ResourceController
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

    public function reset(){
        // set model
        $auth = auth();
        if ($auth != false && $auth->pengguna_level_nama == 'Administrator') {
            if (strtolower($this->request->getMethod()) == "put") {
                $password = $this->request->getRawInput()['pengguna_password'] ?? '';
                $id = $this->request->getRawInput()['id'] ?? '';
                if ($password != '' && $id != '') {
                    $PenggunaModel = new \App\Models\PenggunaModel;
                    $exec = $PenggunaModel->set(['pengguna_password' => password_hash($password, PASSWORD_DEFAULT)])
                                        ->where('id', $id)
                                        ->update();

                    if (!$exec) {
                        $response = [
                            'status' => 500,
                            'error' => true,
                            'message' => $model->errors(),
                            'validate' => false
                        ];
                    } else {
                        $response = [
                            'status' => 200,
                            'error' => false,
                            'message' => "Akun berhasil direset!",
                            'validate' => true
                        ];
                    }
                } else {
                    $response = [
                        'status' => 500,
                        'error' => true,
                        'message' => "Tidak ada data yang dikirim",
                        'validate' => false
                    ];
                }
            } else {
                $response = [
                    'status' => 500,
                    'error' => true,
                    'message' => "Method harus dalam bentuk PUT",
                    'validate' => false
                ];
            }
        } else {
            $response = [
                'status' => 401,
                'error' => true,
                'message' => "Sorry, Unauthorize!!😢",
                'validate' => false
            ];
        }

        return $this->respond($response, $response['status']);
    }
}
