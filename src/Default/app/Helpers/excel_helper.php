<?php
/**
 * Function to apply Excel style to the given configuration.
 * Requires phpoffice/phpspreadsheet library version ^2.0.
 * 
 * @param mixed ...$config Variadic arguments containing style configuration.
 * @return array Merged array of style configurations.
 */
function excelStyle(...$config)
{
	$newConfig = [];
	foreach ($config as $value) {
		if(is_array($value))
		{
			$newConfig = array_merge($newConfig,$value);
		}
		else
		{
			$newConfig[] = $value;
		}
	}
	$styleArray = [];
	foreach ($newConfig as $key => $value) {
		if($value=='border')
		{
			$styleArray['borders'] = [
	            'allBorders' => [
	                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
	            ]
	        ];
		}
		else if($value=='textCenter')
		{
			$styleArray['alignment']['horizontal'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
		}
		else if($value=='valignCenter')
		{
			$styleArray['alignment']['vertical'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER;
		}
		else if($value=='valignTop')
		{
			$styleArray['alignment']['vertical'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP;
		}
		else if($value=='wrapText')
		{
			$styleArray['alignment']['wrapText'] = true;
		}
		else if($value=='fwBold')
		{
			$styleArray['font']['bold'] = true;
		}
		else if($value=='text')
		{
			$styleArray['numberFormat']['formatCode'] = "@";
		}
		else if($value=='number')
		{
			$styleArray['numberFormat']['formatCode'] = "#,##0";
		}
		else if($key=='fillSolid')
		{
			$styleArray['fill']['fillType'] = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
			$styleArray['fill']['startColor']['rgb']= $value;
		}
		else if(is_array($value))
		{
			if(isset($value['fillSolid']))
			{
				$styleArray['fill']['fillType'] = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
				$styleArray['fill']['startColor']['rgb']= $value['fillSolid'];
			}
		}
	}
    return $styleArray;
}