<?php
use Ramsey\Uuid\Uuid;

function shortenNumber($number,$precisions=0)
{
    $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];

    foreach ($abbrevs as $exponent => $abbrev) {
        if (abs($number) >= pow(10, $exponent)) {
            $display = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && round($display) < 100) ? $precisions : 0;
            $number = number_format($display, $decimals).$abbrev;
            break;
        }
    }

    return $number;
}

function dashToUcwords($str)
{
	return ucwords(str_replace('_',' ',$str));
}

function dashToCamelFirst($str)
{
	return ucfirst(str_replace('_','',$str));
}

function currentUri()
{
	$uri = str_replace(site_url(),'',current_url(true));
	return $uri;
}

function cropperImage($config)
{
	if(isset($config['dir']) && isset($config['file']))
	{
		$d = $config['dir'];
		$f = $config['file'];
		$h = $config['height']??100;
		$w = $config['width']??100;
    $setDir = FCPATH.'uploads/'.$d.'/';
    $target = $setDir.$f;
    if(file_exists($target) && $f!='')
    {
    	$exp = explode('.',$f);
    	$newName = $exp[0].'highlight.'.$exp[1];
      $image = \Config\Services::image();
    	$image->withFile($target)
        		->fit($w, $h, 'center')
        		->save($setDir.$newName);
      return $newName;
    }
    else
    {
    	return null;
    }
	}
	else
	{
		throw new \Exception("Direktori or file not set");
	}

    $image = \Config\Services::image();
    if(!file_exists($targetCompress))
    {
        mkdir($targetCompress);
    }
    
    $fileUrl = base_url('uploads/'.$dir.'/compress/'.$newName);
}

function uuid()
{
	return Uuid::uuid4()->toString();
}

function toSlug($text, $divider = '-')
{
 // Ganti semua karakter non-alfanumerik dengan divider
  $text = preg_replace('/[^a-z0-9]+/i', $divider, $text);

  // Hapus karakter yang tidak diinginkan
  $text = preg_replace('/[^a-z0-9-]+/', '', $text);

  // Potong kelebihan divider di awal dan akhir string
  $text = trim($text, $divider);

  // Hapus divider ganda
  $text = preg_replace('/-+/', $divider, $text);

  // Ubah ke huruf kecil
  $text = strtolower($text);

  // Kembalikan "n-a" jika string kosong
  return empty($text) ? 'n-a' : $text;
}

function cardToolbar($configBtn=array()){

	$btn = '';
	foreach($configBtn as $Key => $value)
	{
		if($value =='add')
		{
			$btn .= '<a href="#" class="btn btn-info btn-sm btn-add btn-sm-icon ms-0 ms-md-2 d-flex align-items-center"><i class="bi bi-plus"></i><span class="d-none d-md-block">Add Data</span></a>';
		}
		else if($value =='edit')
		{
			$btn .= '<a class="btn btn-success btn-edit ms-2" data-id="null">
                <i class="bi bi-pencil"></i> Ubah</a>';
		}
		else if($value =='delete')
		{
			$btn .= '<button class="btn btn-danger btn-delete ms-2" data-id="null">
                <i class="bi bi-eraser"></i> Hapus</button>';
		}
		
		else if($value =='back')
		{
			$btn .= '<a href="#" class="btn btn-sm btn-light-danger btn-back font-weight-bolder ms-0 ms-md-2 btn-sm-icon d-flex align-items-center">
              <i class="bi bi-reply"></i><span class="d-none d-md-block">Back</span></a>';
		}
		else if($value =='refresh')
		{
			$btn .= '<button class="btn btn-light-warning btn-refresh btn-sm  btn-sm-icon ms-0 ms-md-2 font-weight-bold d-flex align-items-center"><i class="bi bi-arrow-repeat"></i><span class="d-none d-md-block">Refresh</span></button>';
		}
		else if($value =='reset')
		{
			$btn .= '<button type="button" class="btn-reset btn btn-light-danger btn-sm  ms-0 me-md-2 font-weight-bold" form="form-data" ><i class="bi bi-arrow-repeat"></i> Reset Data</button>';
		}
		else if($value =='deletemarked')
		{
			$btn .= '<a href="#" onclick="deleteMarked(event,this)" class="btn btn-light-danger btn-sm btn-sm-icon btn-delete-marked  d-flex align-items-center ms-1 ms-md-2 d-none  fw-bolder" data-click="true"><i class="bi bi-trash"></i><span class="d-none d-md-block">Delete Marked</span></a>';
		}
		else if($value =='save')
		{
			$btn .= '<button type="submit" form="form-data" class="btn-save btn btn-info btn-sm  ms-0 me-md-2  font-weight-bolder"><i class="bi bi-save"></i> Save Data</button>';
		}
		else
		{
			$btn .= $value;
		}
	}
	return $btn;
}

function defaultValue($type,$data) {
	$auth = Auth();
	if($type=='create')
	{
		foreach ($data as $key => $value) {
            if(!isset($data['id']))
            {
                $data['id'] = uuid();
            }
            if(!isset($data['created_at']))
            {
                $data['created_at'] = timestamp();
            }
            if($auth==false)
            {
	            $data['created_by'] = null;
            }
            else
            {
	            $data['created_by'] = $auth->id;
            }
		}
	}

	else if($type=='update')
	{
		foreach ($data as $key => $value) {
            if(!isset($data['updated_at']))
            {
                $data['updated_at'] = timestamp();
            }
            if($auth==false)
            {
	            $data['updated_by'] = null;
            }
            else
            {
           		$data['updated_by'] = $auth->id;
            }
		}
	}

	return $data;
}

function uploads($dir='',$file='',$default='default.png')
{
	if(file_exists('uploads/'.$dir.'/'.$file) && $file!='' && $file!=NULL){
		return base_url('uploads/'.$dir.'/'.$file);
	}
	else{
		return base_url('assets/images/'.$default);
	}
}

function penggunaLevel($level='')
{
	if($level=='Administrator')
	{
		return '<span class="badge badge-light-success">Administrator</span>';
	}
	else if($level=='Member')
	{
		return '<span class="badge badge-light-info">Member</span>';
	}
	else if($level=='Approval')
	{
		return '<span class="badge badge-light-primary">Approval</span>';
	}
	else
	{
		return '<span class="badge badge-light-warning">'.$level.'</span>';
	}
}

function yN($level='')
{
	if($level=='Y')
	{
		return '<span class="badge badge-light-success">Ya</span>';
	}
	else
	{
		return '<span class="badge badge-light-danger">Tidak</span>';
	}
}

function requestAll($fillable, $method = '') {
  $request = \Config\Services::request();
  $data = [];

  switch ($method) {
    case 'getRawInput':
      $input = $request->getRawInput();
      break;
    case 'getGet':
      $input = $request->getGet();
      break;
    default:
      $input = $request->getPost();
      break;
  }

  foreach ($fillable as $key => $value) {
    if (isset($input[$value]) && !is_array($input[$value])) {
      $post = preg_replace('/(<[^>]+) style=".*?"/i', '$1', trim($input[$value]));
      $data[$value] = $post === '' ? null : $post;
    }
  }

  return $data;
}

function buildNested(array $elements, $parentId = null) {
  $branch = array();

  foreach ($elements as $element) {
      if ($element['parent_id'] === $parentId) {
          $children = buildNested($elements, $element['id']);
          if ($children) {
              $element['children'] = $children;
          }
          $branch[] = $element;
      }
  }

  return $branch;
}

function flattenNested($input, $parentId = null,$level=0,$urutan=0) 
{
	$output=[];
	$level++;
    foreach ($input as $value) {
    	$urutan++;
    	if(isset($value['children'])){
    		$output=array_merge($output,flattenNested($value['children'],$value['id'],$level,$urutan));
    		unset($value['children']);
			$output[]=['id'=>$value['id'],'parent_id'=>$parentId,'level'=>$level,'urutan'=>$urutan];
    	}
    	else{
			$output[]=['id'=>$value['id'],'parent_id'=>$parentId,'level'=>$level,'urutan'=>$urutan];
    	}
    }
    return $output;
}
