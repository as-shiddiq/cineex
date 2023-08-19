<?php

function contentOpen($config)
{
	extract($config);

	$btn = '';
	foreach($configBtn as $Key => $value)
	{
		if($value =='add')
		{
			$btn .= '<a href="#" class="btn btn-primary btn-sm btn-add btn-sm-icon d-flex align-items-center"><i class="bi bi-plus"></i><span class="d-none d-md-block">Add Data</span></a>';
		}
		else if($value =='edit')
		{
			$btn .= '<a class="btn btn-primary text-success btn-edit" data-id="null">
                <i class="bi bi-pencil"></i> Ubah</a>';
		}
		else if($value =='delete')
		{
			$btn .= '<button class="btn btn-danger btn-delete" data-id="null">
                <i class="bi bi-eraser"></i> Hapus</button>';
		}
		
		else if($value =='back')
		{
			$btn .= '<a href="#" class="btn btn-sm btn-primary text-danger btn-back font-weight-bolder btn-sm-icon d-flex align-items-center">
              <i class="bi bi-reply"></i><span class="d-none d-md-block">Back</span></a>';
		}
		else if($value =='refresh')
		{
			$btn .= '<button class="btn btn-light-warning btn-refresh btn-sm  btn-sm-icon font-weight-bold d-flex align-items-center"><i class="bi bi-arrow-repeat"></i><span class="d-none d-md-block">Refresh</span></button>';
		}
		else if($value =='reset')
		{
			$btn .= '<button type="button" class="btn-reset btn btn-primary text-danger btn-sm  font-weight-bold" form="form-data" ><i class="bi bi-arrow-repeat"></i> Reset Data</button>';
		}
		else if($value =='sort')
		{
			$btn .= '<a href="#" type="button" class="btn-sort btn btn-primary btn-sm  font-weight-bold" form="form-data" ><i class="bi bi-sort-down-alt"></i> Urutkan</a>';
		}
		else if($value =='deletemarked')
		{
			$btn .= '<a href="#" onclick="deleteMarked(event,this)" class="btn btn-primary text-danger btn-sm btn-sm-icon btn-delete-marked  d-flex align-items-center ms-1 d-none  fw-bolder" data-click="true"><i class="bi bi-trash"></i><span class="d-none d-md-block">Delete Marked</span></a>';
		}
		else if($value =='save')
		{
			$btn .= '<button type="submit" form="form-data" class="btn btn-primary btn-sm   font-weight-bolder"><i class="bi bi-save"></i> Save Data</button>';
		}
		else
		{
			$btn .= $value;
		}
	}
	return '<section class="section section bg-soft pb-5 overflow-hidden z-2">
			    <div class="container z-2">
			        <div class="row justify-content-center text-center pt-6">
			            <div class="col-lg-8 col-xl-8">
			                <h2 class="display-2 mb-3">'.$page.'</h2>
			                <div class="d-flex align-items-center justify-content-center" style="gap:10px">'.$btn.'</div>
			            </div>
			        </div>
			    </div>
			</section>
				<div id="kt_app_content" class="app-content flex-column-fluid">
					<div id="kt_app_content_container" class="app-container container-fluid">';
}

function contentClose()
{
	return '	</div>
			</div>
			</div>';
}