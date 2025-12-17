<?php

namespace App\Controllers;
class Sitemap extends BaseController
{
    public function index()
    {
        $sitemap = [];
        $sitemap[] = site_url();
        foreach (\scanDirModule() as $key => $value) {
            $sitemapFiles = ROOTPATH.'modules/'.$value.'/Config/Sitemaps.php';
            if(file_exists($sitemapFiles))
            {
                include $sitemapFiles;
            }
        }
        $data['url']   = 'sitemap';
        $data['sitemap'] = $sitemap;
        $data['now']= __FUNCTION__;
        $this->response->setHeader('Content-Type', 'text/xml;charset=UTF-8');
        return view('SitemapView',$data);
    }

}