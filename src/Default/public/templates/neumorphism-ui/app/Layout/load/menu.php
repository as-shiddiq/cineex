<?php
use Cineex\Cineex;

function configMenu()
{
	$cineex = new Cineex();
	$userLevel=Auth()->pengguna_level_nama??'';

	#level
	#group
	#value
		#url - or array with attributes 
		#title
		#icons
		#array if sub menu and repeat as #value

	$menu['Administrator']['-'] = [
		['dashboard/home','Dashboard','house'],
		[[
			'href'=>'/',
			'target'=>'_blank',
			],'Website','diagram-3'
		]
	];
	$menu['Administrator']['config'] = [
		['#','System','',[
			['dashboard/module','Module',''],
			// ['dashboard/penggunalevel','Level Pengguna',''],
		]],
		['#','User Management','',[
			['dashboard/pengguna','Pengguna',''],
			['dashboard/penggunalevel','Level Pengguna',''],
		]]
	];
	foreach ($cineex->scanDirModule() as $key => $value) {
	    $configMenu = $cineex->pathModule().$value.'/Config/Menus.php';
	    if(file_exists($configMenu))
	    {
	        include $configMenu;
	    	if(isset($menuAdd))
	    	{
	    		foreach ($menuAdd as $k => $v) {
    				foreach ($v as $k2 => $v2) {
    					if(isset($menu[$k][$k2]))
    					{
			        		$menu[$k][$k2] = array_merge($menu[$k][$k2]??[],$v2);
    					}
    					else
    					{
			        		$menu[$k][$k2] = $v2;
    					}
    				}
	    		}
	        	unset($menuAdd);
	    	}
	    }
	}
	$menuOrder[] = ['name'=>'-','title'=>''];
	$menuOrder[] = ['name'=>'','title'=>'separator'];
	$menuOrder[] = ['name'=>'webmanagement','title'=>'Web Management','icon'=>'cast'];
	$menuOrder[] = ['name'=>'masterdata','title'=>'Master Data','icon'=>'folder'];
	$menuOrder[] = ['name'=>'config','icon'=>'gear','title'=>'Configuration'];
	#recompile menu
	$remenu = []; 
	foreach ($menuOrder as $k => $v) {
		$_name = $v['name'];
		$_title = $v['title'];
		if($v['title']=='separator')
		{
			$remenu[$userLevel] = array_merge($remenu[$userLevel]??[],[['---']]);
		}
		if(isset($menu[$userLevel][$_name]))
		{
			$arMenu = $menu[$userLevel][$_name]??[];
			if(isset($v['icon']))
			{
				$remenu[$userLevel] = array_merge($remenu[$userLevel]??[],[
					['#',$_title,$v['icon'],$arMenu]
				]);
			}
			else
			{
				$remenu[$userLevel] = array_merge($remenu[$userLevel]??[],$arMenu);

			}
		}
	}
	return $remenu[$userLevel];
}

function checkUriNow($ar,$nowUrl='')
{
	if(is_array($ar[0]))
	{
		$url = $ar[0]['href']??'';
	}
	else
	{
		$url = $ar[0];
	}

	if(str_replace('/', '', $nowUrl)==str_replace('/', '', $url))
	{
		return true;
	}
	
	if(isset($ar[3]))
	{
		foreach ($ar[3] as $key => $value) {
			$check = checkUriNow($value,$nowUrl);
			if($check==true)
			{
				return true;
			}
		}
	}

	return false;
}


function buildMenu($configMenu,$menuLevel=0)
{
	$menuLevel++;
	$uri = new \CodeIgniter\HTTP\URI(current_url(true));
	$nowUrl = substr($uri->getPath(),1);
	$menuHtml = '';
	$active = '';
	$i =1;
	foreach ($configMenu as $menu) {
		if(is_array($menu[0]))
		{
			$url = $menu[0]['href'];
		}
		else
		{
			$url = $menu[0];
		}

		$show = '';
		$active = '';
		$getUriNow = checkUriNow($menu,$nowUrl);
		if($getUriNow)
		{
			$active = 'active';
			$show = 'here show';
		}
		//end check active class
	    if(isset($menu[3]))
	    {
	    	if($menu[2]=='')
	    	{
	    		$setIcon = '<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>';
	    	}
	    	else
	    	{
	    		$setIcon = '<span class="menu-icon">
									<span class="bi bi-'.$menu[2].'  fs-2"></span>
								</span>';
	    	}

	    	if($menuLevel==2)
	    	{
	    		$menuHtml .= '<li class="nav-item dropdown-submenu">
					    	<a href="#" class="dropdown-toggle dropdown-item d-flex justify-content-between align-items-center" data-toggle="dropdown" >
	                            <span class="nav-link-inner-text">'.$menu[1].'</span>
	                            <span class="bi bi-chevron-right nav-link-arrow ml-2"></span>
	                        </a>
							<ul class="dropdown-menu">';

	    	}
	    	else
	    	{
	    		$menuHtml .= '<li class="nav-item dropdown '.$active.'">
					    	<a href="#" class="nav-link" data-toggle="dropdown" >
	                            <span class="nav-link-inner-text">'.$menu[1].'</span>
	                            <span class="bi bi-chevron-down nav-link-arrow ml-2"></span>
	                        </a>
							<ul class="dropdown-menu">';
			}

			//submenu
			foreach ($menu[3] as $submenu) {
					$active = '';
					$getUriNow = checkUriNow($submenu,$nowUrl);
					if($getUriNow)
					{
						$active = 'active';
					}
					if(isset($submenu[3]))
					{
						$menuHtml .= buildMenu([$submenu],$menuLevel);
					}
					else
					{
            			$menuHtml .= '<li>
											<a class="dropdown-item '.$active.'" href="'.site_url($submenu[0]).'">
												'.$submenu[1].'
											</a>
									</li>';
					}
	      	}
			//submenu
	      	$menuHtml .= '</ul></li>';
	    }
	    else
		{
			if($menu[0]=='---')
			{
				$menuHtml .= '';
			}
			else
			{
				if(is_array($menu[0]))
				{
					$attr = '';
					foreach ($menu[0] as $k => $v) {
						$attr .= $k.'="'.$v.'"';
					}
				}
				else
				{
					$attr = 'href="'.site_url($menu[0]).'"';
				}
		    	$menuHtml .= ' <li class="nav-item">
								<a  class="nav-link '.$active.'" '.$attr.'>
                            		<span class="nav-link-inner-text">'.$menu[1].'</span>
								</a>
							</li>';
			}
	  	}
	  }
	return $menuHtml;
}

echo buildMenu(configMenu());