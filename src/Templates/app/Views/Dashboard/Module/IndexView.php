<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css"></link>
<style type="text/css">
		.dd{
			max-width: 100%;
		}
		.dd-body {
			background: #F5F8FA;
			margin-bottom: 5px;
			border-radius: .75rem;
		}
        .dd3-content {
            display: block;
            margin: 5px 0;
            padding: 5px 10px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            background: transparent;
        }
		.dd-handle {
		    display: inherit;
		    height: auto;
		    margin: 0;
		    cursor: pointer;
		    padding: 0;
		    color: #333;
		    text-decoration: none;
		    font-weight: 700;
		    border: 0;
		    background: inherit;
		    border-radius: 0;
		    font-size: 1.4rem;
		    box-sizing: border-box;
    		background: transparent;
	   		padding: 5px 10px;
		}
		.dd-handle i{
			    font-size: 2rem;
			}

        .dd-body:hover {
            color: #2ea8e5;
            background: #fdfdfd;
            transition: .5s all;
        }
        .dd3-content:hover {
            color: inherit;
            background: transparent;
        }

        .dd-dragel > .dd3-item > .dd3-content {
            margin: 0;
        }

        .dd3-item > button {
            margin-left: 30px;
        }
        .dd3-handle:hover {
            background: transparent;
        }
        .dd-item>button {
			    position: relative;
			    cursor: pointer;
			    float: right;
			    width: 40px;
			    height: 40px;
			    border-radius: 1rem;
			    padding: 0;
			    text-indent: 100%;
			    white-space: nowrap;
			    overflow: hidden;
			    border: 0;
			    background: #ccc;
			    color: #fff;
			    font-size: 18px;
			    line-height: 1;
			    text-align: center;
			    font-weight: 700;
			    margin-top: 10px;
			    margin-left: -20px;
			    box-shadow: 0px 0px 50px 0px rgb(82 63 105 / 15%);
			}
	</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Card-->
<?php
$custom = '<a href="#"  onclick="addDataThis()" class="btn btn-info btn-sm btn-add btn-sm-icon ms-0 ms-md-2 d-flex align-items-center"><i class="bi bi-plus"></i><span class="d-none d-md-block">Add Data</span></a>';
?>
<?=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>['refresh','custom'=>$custom]
])?>
	<div class="dd" id="nestable3">
	    <ol class='dd-list dd3-list'>
	    </ol>
	</div>
<?=contentClose()?>


<!--begin::Modal - Create account-->
<div class="modal fade" id="modal-form" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<h3><?=$page?></h3>
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<span class="bi bi-x fs-2x"></span>
				</div>
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body detail-data">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<form id="form-data">
							<?= input_hidden('id', $id ?? '') ?>
							
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">Nama Module</label>
								<div class="col-md-9 pristine-validate">
									<?= input_text('module_nama','', 'form-control-solid', 'required') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">Deskripsi</label>
								<div class="col-md-9 pristine-validate">
									<?= textarea('module_deskripsi','', 'form-control-solid', '') ?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" form="form-data" class="btn btn-info  ms-0 me-md-2  font-weight-bolder"><i class="bi bi-save"></i> Save Data</button>
    			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<?= $this->endSection() ?>


<?= $this->section('javascript') ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<script type="text/javascript">
let modalForm = new bootstrap.Modal(document.getElementById('modal-form'), {
  keyboard: false
});
let setNested = async () => {
	let getNested = await fetch(`${apiUrl}restful/nested/module`);
	let respNested = await getNested.json();
	let nestedData = respNested.data;
	let output = '';
  	function buildItem(row) {
  		let setActive = '';
  		if(row.others.module_status=='D')
  		{
  			setActive = 'bg-light-primary';
  		}
      var html = `<li class="dd-item" data-id="${row.id}">
      		<div class="d-flex align-items-center dd-body justify-content-between ${setActive}">
      		<div class="d-flex align-items-center ">
				<div class="dd-handle dd3-handle">
      					<i class="bi bi-list"></i>
				</div>
                <div class="dd3-content d-flex align-items-center">
               		<div>
		                <h5 class="fw-bold mb-0">${row.text}</h5>
		                <span class="text-muted">
		                ${row.others.module_deskripsi}</span>
               		</div>
                </div>
			</div>
            <div class="pe-3">
            <a href="#" class="btn btn-icon btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                <span class="bi bi-three-dots-vertical m-0"></span>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
            	<div class="menu-item px-3">
	                    <a href="javascript:;"  onclick="updateDataThis('${row.id}','${row.text}')" title="Edit Data" class="menu-link px-3">
							Edit
	                    </a>
	                </div>
                <div class="menu-item px-3">
	                    <a href="javascript:;" onclick="deleteDataThis('${row.id}','${row.text}')" title="Delete Data" class="menu-link px-3">
							Delete
	                    </a>
	                </div>
           	 </div>
            </div>
        </div>`;

      if (row.children) {

          html += "<ol class='dd-list'>";
          $.each(row.children, function (index, sub) {
              html += buildItem(sub);
          });
          html += "</ol>";

      }

      html += "</li>";

      return html;
  }

  for(i in nestedData){
      output += buildItem(nestedData[i]);
  }
  $('.dd3-list').html(output);
  $('#nestable3').nestable({
  	maxDepth :3
  });
  KTMenu.createInstances();
}

setNested();

$('#nestable3').on('change',updateNestable);

async function updateNestable(){
    let data=$('#nestable3').nestable('serialize');
    let put = await fetch(`${apiUrl}restful/updatenested/module`, {
            method: "PUT",
            body:  "data="+JSON.stringify(data),
            headers: {
              'Content-Type':'application/x-www-form-urlencoded'
            }
        });
   	let resp = await put.json();
  if(resp.status==200){
  	if(!resp.error)
  	{
        Toast.fire({
              icon: 'success',
              title: resp.message
            });
        elBtnRefresh.click();
  	}
  	else
  	{
        Toast.fire({
              icon: 'error',
              title: resp.message
            });
  	}
  } else{
        Toast.fire({
        icon: 'error',
        title: resp.message
      });
  }
}

elBtnRefresh.addEventListener('click',setNested);

let pristine;
pristine = new Pristine(elFormData,pristineConfig);  
elFormData.addEventListener('submit', function (e) {
    var valid = pristine.validate();
    e.preventDefault();
    if(valid)
    {
      saveData('return').then(resp=>{
		modalForm.hide();
		elFormData.reset();
		for(el of elFormData.querySelectorAll('.is-valid'))
		{
			el.classList.remove('is-valid');
		}
		setNested();
      });
    }
});

let addDataThis = () => {
	id = '';
	elFormData.querySelector('[name=id]').value = '';
	elFormData.reset();
	modalForm.show();
}
let updateDataThis = async (setId) => {
	id = setId;
	getData(id).then(resp=>{
	    let data = resp[0];
	    for(i in data)
	    {
	        let el = elFormData.querySelector(`[name=${i}]`);
	        if(el!=null)
	        {
	            el.value = data[i];
	        }
	    }
	});
	modalForm.show();
}
let deleteDataThis = async (setId,setText) => {
	deleteData(`${setId}`,`${setText}`).then(()=>{
		setNested();
	})
}
</script>
<?= $this->endSection() ?>