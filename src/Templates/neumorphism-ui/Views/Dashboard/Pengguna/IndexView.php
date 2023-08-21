<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Card-->
<?=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>['refresh','deletemarked','add']
])?>
				<!--begin: Datatable-->
				<table class="table datatable-table table-checkable mt-2" id="kt_datatable">
					<thead>
						<tr>
							<th width="20px"></th>
							<th>Nama Lengkap</th>
							<th>Email</th>
							<th>Level</th>
							<th>Aktif</th>
							<th>Diperbarui pada</th>
							<th width="100px"></th>
						</tr>
					</thead>
				</table>
				<!--end: Datatable-->
<?=contentClose()?>
<?= $this->endSection() ?>


<?= $this->section('javascript') ?>
<script type="text/javascript">
	if(elBtnAdd!=null)
	{
		elBtnAdd.href = `${siteUrl}${nowUrl}/form`;
	}
	if(elBtnDeleteMarked!=null)
	{
		elBtnDeleteMarked.href = `${siteUrl}${nowUrl}/deletemarked`;
	}	
let ubahStatus = async (id,value,e) => {
	let penggunaStatus = e.target.value;
	if(penggunaStatus=='A')
	{
		text = 'Aktif';
	}
	else if(penggunaStatus=='N')
	{
		text = 'Nonaktif';
	}
	else
	{
		text = 'Blokir';
	}
	Swal.fire({
          title: 'Ubah status akun?',
          html: "Ubah akun menjadi <strong class='text-warning'>"+text+"</strong>",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, lanjutkan!',
          cancelButtonText: 'Batalkan'
        }).then(async (result) => {
          if (result.value) {
         	let update = await fetch(`${apiUrl}restful/update/${nowUrl}/${id}`,{
				method : 'PUT',
				body : `id=${id}&pengguna_status=${penggunaStatus}`,
				headers: {
					"Content-Type":"application/x-www-form-urlencoded",
				    "X-Requested-With": "XMLHttpRequest"
				}
			});
			let resp = await update.json();
			if(resp.error==false)
			{
				Swal.fire({
			                icon: 'success',
			                html: `Status pengguna sukses diubah`
		            });
			}
          }
          else
          {
          	e.target.value = value;
          }
    });
	
}

// begin first table
$('#kt_datatable').DataTable({
	responsive: true,
	searchDelay: 500,
	processing: true,
	serverSide: true,
	stateSave: true,
	select: {
			style: 'multi',
			selector: 'td:first-child .checkable',
		},
	headerCallback: function(thead, data, start, end, display) {
		thead.getElementsByTagName('th')[0].innerHTML = `
		<div class="form-check square-check"><input class="form-check-input group-checkable" type="checkbox" value="1" id="defaultCheck111"> <label class="form-check-label" for="defaultCheck111"></label></div>
           `;
	},
	order: [[ 5, "desc" ]],
	ajax: {
		url: `${apiUrl}restful/data/${nowUrl}` ,
		type: 'GET',
		data: {
			// parameters for custom backend script demo
			columnsDef: [
				'id', 
				'pengguna_nama',
				'pengguna_email',
				'pengguna_level_nama',
				'pengguna_status',
				'updated_at',
				'id'],
		},
	},
	columns: [
		{name: 'id',data:'id'},
		{name: 'pengguna_nama',data: 'pengguna_nama'},
		{name: 'pengguna_email',data: 'pengguna_email'},
		{name: 'pengguna_level_nama',data: 'pengguna_level_nama_html'},
		{name: 'pengguna_status',data: 'pengguna_status'},
		{name: 'updated_at',data: 'updated_at_mask_full'},
		{name: 'id',data:'id', responsivePriority: -1},
	],
	columnDefs: [
		{
			targets: 0,
			orderable: false,
			render: function(data, type, row, meta) {
				return `<div class="form-check square-check"><input class="form-check-input checkable" type="checkbox" value="${data}" id="defaultCheck111"> <label class="form-check-label" for="defaultCheck111"></label></div>`;
			},
		},
		{
			targets: 1,
			render: function(data, type, row, meta) {
				return `<div class="d-flex align-items-center">
						<div class="symbol symbol-50 symbol-light me-3 overflow-hidden">
							<span class="symbol-label">
								<img src="${row.pengguna_foto_url}" class="align-self-start w-100" alt="">
							</span>
						</div>
						<div>
							<p class="m-0"><strong>${row.pengguna_nama}</strong></p>
							<span class="text-muted">${row.pengguna_username}</span>
						</div>
						</div>`;
			},
		},
		{
			targets: -3,
			render: function(data, type, row, meta) {
				let selectedA ='';
				let selectedN ='';
				let selectedB ='';
				if(row.pengguna_status=='A')
				{
					selectedA = 'selected';
				}
				else if(row.pengguna_status=='N')
				{
					selectedN = 'selected';
				}
				else
				{
					selectedB = 'selected';
				}
				return `<select name="pengguna_status" class="form-control form-control-sm" onchange="ubahStatus('${row.id}','${row.pengguna_status}',event)">
							<option value="A" ${selectedA}>Aktif</option>
							<option value="N" ${selectedN}>Tidak Aktif</option>
							<option value="B" ${selectedB}>Blokir</option>
						</select>`;
			},
		},
		{
			targets: -1,
			title: '',
			className : 'text-end',
			orderable: false,
			render: function(data, type, row, meta) {
				return buttonAction(['edit','delete'],row.id,row.text);
			},
		}
	],
});
dtSelect();
dtSearch();
dtCreateInstances();
</script>
<?= $this->endSection() ?>