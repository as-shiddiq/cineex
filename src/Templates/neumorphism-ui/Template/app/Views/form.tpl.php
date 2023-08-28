<@=$this->extend('<?=ucfirst($for)?>View') ?>
<@=$this->section('stylesheet') ?>

<@=$this->endSection() ?>

<@=$this->section('content') ?>

<!--begin::Card-->
<@=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>['back']
])?>
	<form id="form-data">
		<@=input_hidden('id', $id ?? '') ?>

		<!-- start form generated -->
		<?=
			view("Public\\Templates\\".env('cineex.template.'.$for)."\\App\\Views\\Loads\\form.tpl.php", ['fields'=>$fields], ['debug' => false]);
		?>
	<!-- end form generated -->
		<div class="row form-group">
			<label class="col-md-3"></label>
			<div class="col-md-9 pristine-validate">
					<@=cardToolbar(['save','reset'])?>
			</div>
		</div>
	</form>
<@=contentClose()?>
	<!-- end:Modal-->
<@=$this->endSection() ?>
<@=$this->section('javascript') ?>
<script type="text/javascript">
	let nowLevel = parseInt(`${window.location.href.split('form/').pop().split('/').shift()}`);
	if(elBtnBack!=null)
	{
		elBtnBack.addEventListener('click',()=>{
			history.back();
		});
	}

	if(elBtnReset!=null)
	{
		elBtnReset.addEventListener('click',()=>{getDataThis()});
	}

  let getDataThis = () => {
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
         	saveData('return').then((resp)=>{
          	if(resp.status==200)
          	{
	            setTimeout(()=>{
	          		window.location=`${siteUrl}${nowUrl}`
	            },500);
          	}
          });
        }
    });

</script>
<@=$this->endSection() ?>