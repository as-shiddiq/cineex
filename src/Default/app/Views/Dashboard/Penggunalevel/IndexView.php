<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
			<th>Level</th>
			<th>Dibuat pada</th>
			<th width="50px"></th>
		</tr>
	</thead>
</table>
<?=contentClose()?>

<!--end: Datatable-->

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
            <div class="form-check form-check-sm form-check-custom form-check-solid">
				<input class="form-check-input group-checkable" type="checkbox" value="1" />
			</div>`;
	},
	order: [[ 2, "desc" ]],
	ajax: {
		url: `${apiUrl}restful/data/${nowUrl}` ,
		type: 'GET'
	},
	columns: [
		{name: 'id',data:'id'},
		{name: 'pengguna_level_nama',data: 'pengguna_level_nama'},
		{name: 'updated_at',data: 'updated_at_mask_full'},
		{name: 'id',data:'id', responsivePriority: -1},
	],
	columnDefs: [
		{
			targets: 0,
			orderable: false,
			render: function(data, type, row, meta) {
				return `
	            <div class="form-check form-check-sm form-check-custom form-check-solid">
					<input class="form-check-input checkable" type="checkbox" value="${data}" />
				</div>`;
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