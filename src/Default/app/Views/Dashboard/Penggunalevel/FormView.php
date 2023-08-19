<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>['back']
])?>
				<!--begin: Datatable-->
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<form id="form-data">
			<?= input_hidden('id', $id ?? '') ?>
			<div class="row form-group mb-5">
				<label class="col-md-3 mb-3 m-md-auto">Nama Level</label>
				<div class="col-md-9 pristine-validate">
					<?= input_text('pengguna_level_nama','', '', 'required') ?>
				</div>
			</div>
			<div class="row form-group">
				<label class="col-md-3"></label>
				<div class="col-md-9 pristine-validate">
						<?=cardToolbar(['save','reset'])?>
				</div>
			</div>
		</form>
	</div>
</div>
<?=contentClose()?>

<?= $this->endSection() ?>


<?= $this->section('javascript') ?>
<script type="text/javascript">
	if(elBtnBack!=null)
	{
		elBtnBack.href = `${siteUrl}${nowUrl}`;
	}

	if(elBtnReset!=null)
	{
		elBtnReset.addEventListener('click',()=>{getDataThis()});
	}


    let getDataThis = () => {
    	console.log('a')
	    if(id!='')
	    {
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
	    }
    }
    getDataThis();
    let pristine;

	pristine = new Pristine(elFormData,pristineConfig);  

    elFormData.addEventListener('submit', function (e) {
        var valid = pristine.validate();
        e.preventDefault();
        if(valid)
        {
          saveData();
        }
    });

</script>
<?= $this->endSection() ?>