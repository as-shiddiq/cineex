<?php

namespace App\Controllers\Dashboard;

class Profil extends BaseController
{
	
	public $url = 'profil';
	private $title = 'Profil';
	public function __construct(){
	}

	public function index($penggunaId='')
	{	
		$data['title']= $this->title;
		$data['page']= $this->title;
		$data['url']= $this->url;
        $data['btnToolbar']= ['back'];
		$data['penggunaId']= $penggunaId;
		$data['now']= __FUNCTION__;
        return view('Dashboard/Profil/'.ucwords(__FUNCTION__).'View',$data);
	}


	public function setting($penggunaId='')
	{	
		$data['title']= $this->title;
		$data['page']= $this->title;
        $data['btnToolbar']= ['back'];
		$data['penggunaId']= $penggunaId;
		$data['url']= $this->url;
        $data['render'] = 'dashboard';
		$data['now']= __FUNCTION__;
        return view('Dashboard/Profil/'.ucwords(__FUNCTION__).'View',$data);
	}



	public function billing($penggunaId='')
	{	
		$data['title']= 'My Billing';
		$data['page']= 'My Billing';
		$data['penggunaId']= $penggunaId;
		$data['url']= $this->url;
        $data['render'] = 'dashboard';
        $data['btnToolbar']= ['back'];
		$data['now']= __FUNCTION__;
        return view('Dashboard/Profil/'.ucwords(__FUNCTION__).'View',$data);
	}



	public function usage($penggunaId='')
	{	
		$data['title']= 'My Usage';
		$data['page']= 'My Usage';
        $data['btnToolbar']= ['back'];
        $data['render'] = 'dashboard';
		$data['penggunaId']= $penggunaId;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
        return view('Dashboard/Profil/'.ucwords(__FUNCTION__).'View',$data);
	}


	public function form($id='')
	{	
		$dataFind = $this->model
						->asArray()
						->where('id',$id)
						->first();
		if($dataFind==null)
		{
			$data['data'] = [];
			$data['id']= '';
		}
		else
		{
			$data['data'] = $dataFind;
			$data['id']= $id;
		}

		$data['title']= 'Halaman '.$this->title;
		$data['page']= 'Form '.$this->title;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
		$data['layouts'] = $this->myConf->layouts['dashboard'];
		return view(ucfirst($this->url).'/'.ucfirst(__FUNCTION__).'View',$data);
	}

	public function list()
	{	
		$data['title']= 'List '.$this->title;
		$data['page']= 'Data '.$this->title;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
        $data['render'] = 'dashboard';
		$data['layouts'] = $this->myConf->layouts['dashboard'];
		return view(ucfirst($this->url).'/'.ucfirst(__FUNCTION__).'View',$data);
	}
	
	public function updateakun()
	{
		if($this->request->getPost())
		{
			$auth = auth();
			$data = $this->request->getPost();
			$Pengguna = new \App\Models\PenggunaModel;
			$rowPengguna = $Pengguna->where('id',$auth->id)->first();
			//cek apakah benar perubahannya dilakukan
			if(password_verify($data['pengguna_password_konfirmasi'],$rowPengguna->pengguna_password))
			{
				if($this->request->getPost('pengguna_password')=='')
				{
					unset($data['pengguna_password']);
				}
				else
				{
					$data['pengguna_password'] = password_hash($data['pengguna_password'],PASSWORD_DEFAULT);
				}

				$Pengguna->update($auth->id,$data);

				session()->setFlashdata('info',['message'=>'Informasi akun berhasil diubah','info'=>'success']);
			}
			else
			{
				session()->setFlashdata('info',['message'=>'Maaf password untuk konfirmasi tidak sesuai','info'=>'error']);
			}
		}

		return redirect()->to(site_url($this->url));

	}

	public function updatepegawai()
	{
		if($this->request->getPost())
		{
			$auth = auth();
			$data = $this->request->getPost();
			$Pengguna = new \App\Models\PenggunaModel;
			$Pegawai = new \App\Models\PegawaiModel;
			$rowPengguna = $Pengguna->where('id',$auth->id)->first();
			//cek apakah benar perubahannya dilakukan
			if(password_verify($data['pengguna_password_konfirmasi'],$rowPengguna->pengguna_password))
			{
				
				$Pegawai->update($auth->pegawai_id,$data);

				session()->setFlashdata('info',['message'=>'Informasi pegawai berhasil diubah','info'=>'success']);
			}
			else
			{
				session()->setFlashdata('info',['message'=>'Maaf password untuk konfirmasi tidak sesuai','info'=>'error']);
			}
		}

		return redirect()->to(site_url($this->url));

	}


}