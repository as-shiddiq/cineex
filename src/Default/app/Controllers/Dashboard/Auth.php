<?php

namespace App\Controllers\Dashboard;

class Auth extends BaseController
{  
    private $title = 'Authorization';
    private $url = 'auth';

    public function index()
    {
      if(auth()!=false)
      {
         return redirect()->to('dashboard');
      }
      $data['title'] = $this->title;
      $data['page']= 'Authorization';
      $data['url']   = $this->url;
      $data['now']= __FUNCTION__;
      return view('Dashboard/'.'Auth/'.ucwords(__FUNCTION__).'View',$data);
    }

    public function signup()
    {
      $data['title'] = 'Sign Up';
      $data['page']= 'Sign Up';
      $data['url']   = $this->url;
      $data['now']= __FUNCTION__;
      return view(ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View',$data);
    }

    public function forgot()
    {
      $data['title'] = 'Forgot';
      $data['page']= 'Forgot';
      $data['url']   = $this->url;
      $data['now']= __FUNCTION__;
      return view(ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View',$data);
    }

    public function confirmation($token = '')
    {
      helper('nnotif');
      if($token!='')
      {
        $PenggunaModel = new \App\Models\PenggunaModel();
        $getPengguna = $PenggunaModel->where('token',$token)
                                    ->where('expired_at >',timestamp())
                                    ->first();
        if($getPengguna!=null)
        {
          if($getPengguna->pengguna_status=='A')
          {
            $data['activate'] = 'hasactivated';
          }
          else
          {
            $PenggunaModel->set(['pengguna_status'=>'A','token'=>null])
                          ->where('pengguna.id',$getPengguna->id)
                          ->where('token',$token)
                          ->where('expired_at >',timestamp())
                          ->update();
            if($getPengguna->pengguna_email!=NULL && $getPengguna->pengguna_email!='')
            {
              notifActivatedAccount($getPengguna->id);
            }
            if($getPengguna->pengguna_hp!=NULL && $getPengguna->pengguna_hp!='')
            {
              notifActivatedAccount($getPengguna->id,'Whatsapp');
            }

            $data['activate'] = 'activated';
          }
        }
        else
        {
          $data['activate'] = 'expired';
        }

        $data['title'] = 'Confirmation';
        $data['page']= 'Confirmation';
        $data['url']   = $this->url;
        $data['now']= __FUNCTION__;
        return view(ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View',$data);
      }
      else
      {
        return redirect()->to(site_url());
      }
    }

    public function reset($token = '')
    {
      if($token!='')
      {
        $PenggunaModel = new \App\Models\PenggunaModel();
        $getPengguna = $PenggunaModel->where('token',$token)
                                    ->where('expired_at >',timestamp())
                                    ->first();
        if($getPengguna!=null)
        {
          $data['token'] = 'valid';
        }
        else
        {
          $data['token'] = 'invalid';
        }

        session()->set('token',$token);
        $data['title'] = 'Reset Password';
        $data['page']= 'Reset Password';
        $data['url']   = $this->url;
        $data['now']= __FUNCTION__;
        return view(ucfirst($this->url).'/'.ucwords(__FUNCTION__).'View',$data);
      }
      else
      {
        return redirect()->to(site_url());
      }
    }
}
