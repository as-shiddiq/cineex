<?php

function modulePath($name='')
{
	return 'Modules\\'.ucfirst($name);
}

function moduleName($name='')
{
	return explode('\\', $name)[1];
}
function moduleSegment($name='')
{
	$ar = explode('\\', $name);
	return $ar[count($ar)-2].'\\'.$ar[count($ar)-1];
}
function moduleClass($name='')
{
	$ar = explode('\\', $name);
	return array_pop($ar);
}