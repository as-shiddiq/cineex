<@php
<?php
    $menu = [];
    $webmanagement = [];
    foreach ($classList as $k => $v) {
        $class = new $v;
        $ex = explode('\\',$v);
        $fileName = $ex[count($ex)-1];
        $menu[] = "['dashboard/".strtolower($fileName)."','$fileName','menu-up'],\n"; 
    }
    $menu =  implode("\t", $menu);
?>
//menu with submenu as default
$menuAdd['Administrator']['-'] = [
	/** Activate if menu not in submenu
	<?=$menu?>
	**/
	# start sub menu 
	['#','{module}','box',[
		<?=$menu?>
	]],
	# end sub menu 
];

//for webmanagement sub menu
/** Activate if menu want in webmanagement 
$menuAdd['Administrator']['webmanagement'] = [
	<?=$menu?>
];
**/

//for master data sub menu
/** Activate if menu want in masterdata 
$menuAdd['Administrator']['masterdata'] = [
	<?=$menu?>
];
**/

//for config sub menu
/** Activate if menu want in masterdata 
$menuAdd['Administrator']['config'] = [
	<?=$menu?>
];
**/
