<@=$this->extend('<?=ucfirst($for)?>View') ?>

<@=$this->section('stylesheet') ?>

<@=$this->endSection() ?>

<@=$this->section('content') ?>
<!--begin::Card-->
<?php 
if($config['sort']??''==true)
{
		$btn = "['refresh','sort','add']";
}
else
{
		$btn = "['refresh','add']";

}
?>
<@=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=><?=$btn?>
])?>
<?php
  $saveThead = [];
  $saveDtcolumns = [];
  $saveDtcolumnsdef = [];
  $dtOrder = 0;
  foreach($fields as $k => $v)
  {
      if($k!='id')
      {
          if(isset($v['join']))
          {
              if(count($v['jointable']??[])!=0)
              {
                  foreach($v['jointable'] as $r)
                  {
                      $saveThead[] = "<th>".dashToUcwords($r)."</th>\n";
                      $saveDtcolumns[] = "{name: '{$r}',data: '{$r}'},\n";
                      $dtOrder++;
                  }
              }
          }
          if($v['showtable']??false==true)
          {
              $saveDtcolumns[] = "{name: '{$k}',data: '{$k}'},\n";
              $saveThead[] = "<th>".dashToUcwords($k)."</th>\n";
              if($v['type']=='DATETIME')
              {
                  $saveDtcolumnsdef[] = "{
		  targets: {$dtOrder},
		  render: function(data, type, row, meta) {
		      return dmyFormat(data);
		  },
		},\n";
              }
              $dtOrder++;
          }
      }
  }
  $thead = implode("\t\t\t\t\t",$saveThead);
  $dtColumns = implode("\t\t",$saveDtcolumns);
  $dtColumnsDef = implode("\t",$saveDtcolumnsdef);

?>
		<table class="table datatable-table table-row-dashed table-checkable mt-2" id="kt_datatable">
			<thead>
				<tr>
					<?=$thead?>
					<th width="50px"></th>
				</tr>
			</thead>
		</table>
<@=contentClose()?>
<@=$this->endSection() ?>

<@=$this->section('javascript') ?>
<script type="text/javascript">
elBtnAdd.href = `${siteUrl}${nowUrl}/form`;
<?php
if($config['sort']??''==true)
{
	?>
elBtnSort.href = `${siteUrl}${nowUrl}/sort`;
	<?php
}
?>
// begin first table
$('#kt_datatable').DataTable({
	responsive: true,
	searchDelay: 500,
	processing: true,
	serverSide: true,
	stateSave: true,
	order: [[ <?=$dtOrder-1?>, "desc" ]],
	ajax: {
		url: `${apiUrl}restful/data/${nowUrl}` ,
		type: 'GET'
	},
	columns: [
		<?=$dtColumns?>
		{name: 'id',data:'id', responsivePriority: -1},
	],
	columnDefs: [
		<?=$dtColumnsDef?>
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
<@=$this->endSection() ?>