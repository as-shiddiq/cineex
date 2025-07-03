<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>
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
<!--begin: Datatable-->
<table class="table datatable-table table-checkable mt-2" id="kt_datatable">
	<thead>
		<tr>
			<th>From</th>
			<th>Value</th>
			<th>To</th>
			<th>Value</th>
			<th width="50px"></th>
		</tr>
	</thead>
</table>
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
								<label class="col-md-3 mb-3 m-md-auto">From</label>
								<div class="col-md-9 pristine-validate">
									<?= select('join_from',[],'', '', 'data-placeholder="--Pilih--" data-search="false" required') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">From ID</label>
								<div class="col-md-9 pristine-validate">
									<?= select('join_from_id',[],'', '', 'data-placeholder="--Pilih--" required') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">To</label>
								<div class="col-md-9 pristine-validate">
									<?= select('join_to',[],'', '', 'data-placeholder="--Pilih--" required') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">To ID</label>
								<div class="col-md-9 pristine-validate">
									<?= select('join_to_id',[],'', '', 'data-placeholder="--Pilih--" required') ?>
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
<script type="text/javascript">
let modalForm = new bootstrap.Modal(document.getElementById('modal-form'), {
  keyboard: false
});

// begin first table
$('#kt_datatable').DataTable({
	responsive: true,
	searchDelay: 500,
	processing: true,
	serverSide: true,
	stateSave: true,
	order: [[ 0, "desc" ]],
	ajax: {
		url: `${apiUrl}restful/data/${nowUrl}` ,
		type: 'GET',
	},
	columns: [
		{name: 'join_from',data: 'join_from'},
		{name: 'join_from_id',data: 'join_from_nama'},
		{name: 'join_to',data: 'join_to'},
		{name: 'join_to_id',data: 'join_to_nama'},
		{name: 'id',data:'id', responsivePriority: -1},
	],
	columnDefs: [
		{
			targets: -1,
			title: '',
			className : 'text-end',
			orderable: false,
			render: function(data, type, row, meta) {
				let btn = [];
				btn[0] = `<div class="menu-item px-3">
	                    <a href="javascript:;" onclick="updateDataThis('${row.id}')" title="Edit Data" class="menu-link px-3">
							Edit
	                    </a>
	                </div>`;
				return buttonAction([btn,'delete'],row.id,row.text);
			},
		}
	],
});
dtSelect();
dtSearch();
dtCreateInstances();


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
		elBtnRefresh.click();
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
        	document.querySelector('[name=join_from]').innerHTML = `<option value="${data.join_from}" selected>${data.join_from}</option>`;
        	document.querySelector('[name=join_from_id]').innerHTML = `<option value="${data.join_from_id}" selected>${data.join_from_nama}</option>`;
        	document.querySelector('[name=join_to]').innerHTML = `<option value="${data.join_to}" selected>${data.join_to}</option>`;
        	document.querySelector('[name=join_to_id]').innerHTML = `<option value="${data.join_to_id}" selected>${data.join_to_nama}</option>`;
			select2('[name=join_from_id]',`${apiUrl}join/value?table=${data.join_from}`,'text','id','text',true);
			select2('[name=join_to_id]',`${apiUrl}join/value?table=${data.join_to}`,'text','id','text',true);

	    }
	});
	modalForm.show();
}
let deleteDataThis = async (setId,setText) => {
	deleteData(`${setId}`,`${setText}`).then(()=>{
		setNested();
	});
}


select2('[name=join_from]',`${apiUrl}join/module`,'text','id','text',true);
$("[name=join_from]").on('change',function(){
	select2('[name=join_from_id]',`${apiUrl}join/value?table=${$(this).val()}`,'text','id','text',true);
})
select2('[name=join_to]',`${apiUrl}join/module`,'text','id','text',true);
$("[name=join_to]").on('change',function(){
	select2('[name=join_to_id]',`${apiUrl}join/value?table=${$(this).val()}`,'text','id','text',true);
})

</script>
<?= $this->endSection() ?>