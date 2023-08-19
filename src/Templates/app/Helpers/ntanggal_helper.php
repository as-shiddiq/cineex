<?php

//convert to 16 Mei 1993
if(!function_exists('standarTanggal')){
	function standarTanggal($date='2020-01-02',$gabung="-",$lang='id_ID'){
		$ex = explode($gabung,$date);
		return $ex[2].' '.bulanHuruf($ex[1]).' '.$ex[0];
	}

}
//convert to 16 Mei 1993
if(!function_exists('standarTanggalPendek')){
	function standarTanggalPendek($date='2020-01-02',$gabung="-",$lang='id_ID'){
		$ex = explode($gabung,$date);
		return $ex[2].' '.bulanPendek($ex[1]).' '.$ex[0];
	}

}

function tanggal_indonesia($a){
	return nama_hari($a).', '.standar_tanggal($a);
}

if(!function_exists('namaHari')){
	function namaHari($tanggal){
		if($tanggal==null){
			return null;
		}
		$ubah=gmdate($tanggal,time()+60*60*8);
		$pecah=explode("-",$ubah);
		$tgl=$pecah[2];
		$bln=$pecah[1];
		$thn=$pecah[0];

		$nama=date("l",mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari="";

		if($nama=="Sunday"){
			$nama_hari="Minggu";
		}
		elseif($nama=="Monday"){
			$nama_hari="Senin";
		}
		elseif($nama=="Tuesday"){
			$nama_hari="Selasa";
		}
		elseif($nama=="Wednesday"){
			$nama_hari="Rabu";
		}
		elseif($nama=="Thursday"){
			$nama_hari="Kamis";
		}
		elseif($nama=="Friday"){
			$nama_hari="Jumat";
		}
		elseif($nama=="Saturday"){
			$nama_hari="Sabtu";
		}

		return $nama_hari;
	}
}



 	if( ! function_exists('aturTanggal')){
 	function aturTanggal($tgl){
 		$pjg=strlen($tgl);
	    //hari

	    if($pjg==1){
	        $hari='0'.$tgl;

	    }
	    else{
	        $hari=$tgl;
	    }
	    return $hari;
 	}

 	}
	if ( ! function_exists('bulanAngka')){
    function bulanAngka($bln){

    switch ($bln) {
        case 'Januari':
            $bulan='01';
            break;

        case 'Februari';
            $bulan='02';
            break;

        case 'Maret':
            $bulan='03';
            break;

        case 'April':
            $bulan='04';
            break;

        case 'Mei':
            $bulan='05';
            break;
        case 'Juni':
            $bulan='06';
            break;

        case 'Juli':
            $bulan='07';
            break;

        case 'Agustus':
            $bulan='08';
            break;

        case 'September':
            $bulan='09';
            break;

        case 'Oktober':
            $bulan='10';
            break;

        case 'November':
            $bulan='11';
            break;

        case 'Desember':
            $bulan='12';
            break;

          default:
          $bulan='';
          break;


    }

    	return $bulan;
    }

   }

   if(!function_exists('bulanHuruf')){
	function bulanHuruf($bln){
		switch ($bln) {
			case 1:
				return "Januari";
				break;

			case 2:
			return "Februari";
			break;

			case 3:
			return "Maret";
			break;

			case 4:
			return "April";
			break;

			case 5:
			return "Mei";
			break;

			case 6:
			return "Juni";
			break;

			case 7:
			return "Juli";
			break;

			case 8:
			return "Agustus";
			break;

			case 9:
			return "September";
			break;

			case 10:
			return "Oktober";
			break;

			case 11:
			return "November";
			break;

			case 12:
			return "Desember";
			break;

			default:
			return "";
			break;
		}
	}
}
if(!function_exists('bulanPendek')){
	function bulanPendek($bln){
		switch ($bln) {
			case 1:
				return "Jan";
				break;

			case 2:
			return "Feb";
			break;

			case 3:
			return "Mar";
			break;

			case 4:
			return "Apr";
			break;

			case 5:
			return "Mei";
			break;

			case 6:
			return "Jun";
			break;

			case 7:
			return "Jul";
			break;

			case 8:
			return "Agt";
			break;

			case 9:
			return "Sep";
			break;

			case 10:
			return "Okt";
			break;

			case 11:
			return "Nov";
			break;

			case 12:
			return "des";
			break;

			default:
			return "";
			break;
		}
	}



}

if(!function_exists('manipulasiTanggal')){
	function manipulasiTanggal($tgl,$jumlah=1,$format='days',$formatDate='Y-m-d'){
		$currentDate = $tgl;
		return date($formatDate, strtotime($jumlah.' '.$format, strtotime($currentDate)));
	}
}


if(!function_exists('dateDmy')){
	function dateDmy($a){
		//format asal yy-mm-dd
		$ex=explode('-', $a);
		$y=$ex[0];
		$m=$ex[1];
		$d=$ex[2];
		return $d.'-'.$m.'-'.$y;
	}
}

if(!function_exists('dateYmd')){
	function dateYmd($a){
		//format asal dd-mm-yy
		$ex=explode('-', $a);
		$d=$ex[0];
		$m=$ex[1];
		$y=$ex[2];
		return $y.'-'.$m.'-'.$d;
	}
}
if(!function_exists('tanggalSampai')){
	function tanggalSampai($a,$b){
		if($b==null)
		{
			return standarTanggal($a);
		}
		elseif($a==null){
			return "NULL";
		}
		else 
		{
			$mulai=explode('-',$a);
			$sampai=explode('-',$b);
			if($sampai[1]===$mulai[1]){
				if($sampai[2]===$mulai[2]){
					$tgl=$sampai[2].' '.bulanHuruf($mulai[1]).' '.$mulai[0];
				}
				else{
					$tgl=$mulai[2].' s/d '.$sampai[2].' '.bulanHuruf($mulai[1]).' '.$mulai[0];
				}
			}
			else{
				$tgl=$mulai[2].' '.bulanHuruf($mulai[1]).' s/d '.$sampai[2].' '.bulanHuruf($sampai[1]).' '.$mulai[0];
			}
		}
		return $tgl;
	}
}

function hariSampai($a,$b){
	if($a<$b){
		return namaHari($a).' s/d '.namaHari($b);
	}
	else{
		return namaHari($a);
	}
}

function waktuSampai($a,$b){
	if($a==null && $b==null){
		return 'null';
	}
	if($b=='00:00:00'){
		return substr($a,0,5).' WITA s/d Selesai';
	}
	else{
		if($a<$b){
			return substr($a,0,5) .' s/d'.substr($b,0,5);
		}
		else{
			return substr($a,0,5).' WITA s/d Selesai';
		}
	}
}

function jumlahHari($month = 0, $year = '')
{
	if ($month < 1 OR $month > 12)
	{
		return 0;
	}
	elseif ( ! is_numeric($year) OR strlen($year) !== 4)
	{
		$year = date('Y');
	}

	if (defined('CAL_GREGORIAN'))
	{
		return cal_days_in_month(CAL_GREGORIAN, $month, $year);
	}

	if ($year >= 1970)
	{
		return (int) date('t', mktime(12, 0, 0, $month, 1, $year));
	}

	if ($month == 2)
	{
		if ($year % 400 === 0 OR ($year % 4 === 0 && $year % 100 !== 0))
		{
			return 29;
		}
	}

	$days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	return $days_in_month[$month - 1];
}

function bulanList($ar=array()){
	foreach ($ar as $key => $value) {
		$op[$key]=$value;
	}
	for ($i=1; $i <=12 ; $i++) {
		if(strlen($i)==1){
			$i='0'.$i;
		} 
		$op[$i]=bulanHuruf($i);
	}
	return $op;
}
	
function tahunList($a='',$b='',$op=array()){
	if($a==''){
		$a=date('Y')-5;
	}
	if($b==''){
		$b=$a+10;
	}
	for ($i=$a; $i <=$b ; $i++) { 
		$op[$i]=$i;
	}
	return $op;
}

if(!function_exists('timestamp')){
	function timestamp(){
	    return date('Y-m-d H:i:s');
	}
}

if(!function_exists('timestamptodate'))
{
	function timestamptodate($a){
	    return substr($a,0,10);
	}
}
if(!function_exists('hitungHari'))
{
	function hitungHari($a,$b){
		$start_date = new DateTime($a);
		$end_date = new DateTime($b);
		$interval = $start_date->diff($end_date);
		return $interval->days;
	}
}

function dateTimeToStandarTanggal($tgl,$full=false){
	if($tgl!=null AND $tgl!='0000-00-00 00:00:00'){
		if($full==true){
			return standarTanggal(substr($tgl,0,10)).' '.substr($tgl,11);
		}
		else{
			return standarTanggal(substr($tgl,0,10));
		
		}
	}
	else{
		return 'undefined';
	}
}
function timezoneList(){
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));
    $tempTimezones = array();
    foreach($timezoneIdentifiers as $timezoneIdentifier){
        $currentTimezone = new DateTimeZone($timezoneIdentifier);
        $tempTimezones[] = array(
            'offset' => (int)$currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier
        );
    }
    function sort_list($a, $b){
        return ($a['offset'] == $b['offset'])
            ? strcmp($a['identifier'], $b['identifier'])
            : $a['offset'] - $b['offset'];
    }
    usort($tempTimezones, "sort_list");
    $timezoneList = array();
    foreach($tempTimezones as $tz){
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
            $tz['identifier'];
    }
    return $timezoneList;
}
