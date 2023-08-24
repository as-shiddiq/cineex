<?php

use Cineex\Cineex;
use \App\Config\Autoload as Autoload;

$cineex = new Cineex();

function configWeb()
{
	helper('responsedata');
	$Model = new \App\Models\ConfigwebModel();
  $data = $Model->asArray()->first();
  $data['config_web_icon_light_url'] = uploads('configweb',$data['config_web_icon_light']);
  $data['config_web_icon_dark_url'] = uploads('configweb',$data['config_web_icon_dark']);
  $data['config_web_logo_light_url'] = uploads('configweb',$data['config_web_logo_light']);
  $data['config_web_logo_dark_url'] = uploads('configweb',$data['config_web_logo_dark']);
  return (object) $data;
}

function configEmail()
{
	helper('responsedata');
	$Model = new \App\Models\ConfigemailModel();
  $get = $Model->first();
  return $get;
}

foreach ($cineex->scanDirModule() as $key => $value) {
    $helper = $cineex->pathModule().$value.'/Helpers/app.php';
    if(file_exists($helper))
    {
        include $helper;
    }
}

function renderView($module,$data)
{
	$cineex = new Cineex();
	return $cineex->renderView($module,$data);
}

function includeView($render='main',$file='')
{
	$cineex = new Cineex();
	return $cineex->includeView($render,$file);
}

function scanDirModule()
{
	$cineex = new Cineex();
	return $cineex->scanDirModule();
}

function envByScript($str='')
{
	if($str=='')
	{
		$configWeb = configWeb();
		$str = $configWeb->config_web_script_setting;
	}
	$ar = [];
	foreach (explode('&&',$str) as $key => $value) {
		$ex = explode('=',$value);
		if(isset(($ex[1])))
		{
			$ex2 = explode(',',$ex[1]);
			if(count($ex2)>1)
			{
				$ar[$ex[0]] = $ex2;
			}
			else
			{
				$ar[$ex[0]] = $ex[1]; 
			}
		}
	}
	return $ar;
}
