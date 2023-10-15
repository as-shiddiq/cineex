<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');
        $auth = auth();
        if ($auth==false) {
            return redirect()->to(site_url('auth'));
        }

        /** CHANGE FOR USER CANT ACCESS **/
        $ar['User'] = [
            'dashboard/pengguna/*',
            'dashboard/penggunalevel/*',
        ];

        $url = current_url();
        $baseURL = env('app.baseURL');
        //foreach ar for user
        if(isset($ar[$auth->pengguna_level_nama]))
        {
            foreach ($ar[$auth->pengguna_level_nama] as $k => $v) {
                $pattern = $baseURL.$v;
                // Mengecek apakah karakter wildcard * digunakan dalam pola
                if (strpos($pattern, '*') !== false) {
                    // Jika karakter wildcard * digunakan dalam pola, maka kita gunakan strpos
                    if (strpos($url.'/', str_replace('*', '', $pattern)) === 0) {
                        return redirect()->to('dashboard');
                    } 
                } else {
                    // Jika karakter wildcard * tidak digunakan dalam pola, maka kita gunakan ==
                    if ($url === $pattern) {
                        return redirect()->to('dashboard');
                    }
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
