<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>

<style type="text/css">
	.ck {
	    background-color: var(--kt-input-solid-bg);
	    border-color: var(--kt-input-solid-bg);
	}
	.ql-bubble .ql-tooltip{
		z-index: 1000;
	    border-radius: .75rem;
	}
	.editor-container{
		transition: .5s;
	}
	.editor-fullscreen{
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		background-color: #fff;
		z-index: 1000;
	}
	
	.editor-fullscreen .card-body{
	    overflow: hidden;
	    height: 100%;
	}

	.editor-fullscreen label{
		font-weight: bold;
		font-size: 1rem;
		display: none;
		color: #aaa;
	}
	.editor-fullscreen  input.editor-title{
		background-color: transparent !important;
		border : 0 !important;
		box-shadow: 0 !important;
		border-radius: 0 !important;
		padding: 0;
		font-size: 2rem;
	}

	.editor-fullscreen #editor.ck{
		line-height: 1.5rem;
		font-size: 1.5rem;
		padding-right: 0;
		padding-left: 0;
	    background-color: transparent;
	    border-color: transparent;
	}
	.editor-fullscreen #editor.ck-focused{
	    border-color: transparent !important;
	}
	.editor-fullscreen #editor .ck p{
		margin-bottom: 1rem;
	}
	.editor-fullscreen input.editor-title:focus{
		border : 0 !important;
	}
	.editor-fullscreen .is-valid .form-control {
		border : 0 !important;
		background: inherit !important;
	}
	.editor-fullscreen .wrapper-editor{
		height: 100%;
		overflow-y: auto;
		padding-bottom: 4rem;
	}

	.editor-fullscreen .card-title{
		display: none !important;
	}
	.editor-fullscreen .card-header .form-group{
		margin-bottom: 0 !important;
		width: calc(100% - 40px);
	}
	.editor-fullscreen .card-header {
		align-items: center !important;
	}
	.ck-editor__editable p{
		font-size: 16px;
	}
	.ck-body-wrapper{
		z-index: 10000;
	}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>[]
])?>
 	<ul class="card-title pt-3 mb-0 gap-4 gap-lg-10 gap-xl-15 nav nav-tabs nav-line-tabs mb-5">
       <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#info">Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#logo">Configuration</a>
    </li>
      <!--end::Tab item-->
  </ul>
	<form id="form-data" class="detail-data">
		<?= input_hidden('id', '') ?>
		 <div class="row">
		 	<div class="col-md-2"></div>
		 	<div class="col-md-8">
				<div class="tab-content" id="myTabContent">
				    <div class="tab-pane fade show active" id="info" role="tabpanel">
							<div class="form-group mb-5">
					    	<label class="mb-3 ">Footnote</label>
								<?=textarea('config_email_footnote','','d-none','required')?>
								<div class="form-group wrapper-editor">
									<div id="editor-footnote" class=" border border-secondary h-100"></div>
								</div>
							</div>
							<div class="form-group mb-5">
					    	<label class="mb-3">Footer</label>
								<?=textarea('config_email_footer','','d-none','required')?>
								<div class="form-group wrapper-editor">
									<div id="editor-footer" class=" border border-secondary h-100"></div>
								</div>
							</div>
				    </div>
				    <div class="tab-pane fade" id="logo" role="tabpanel">
				       <div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">Nama Web</label>
								<div class="col-md-9 pristine-validate">
									<?= input_text('config_email_nama','', '', 'required') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">Mailhost</label>
								<div class="col-md-9 pristine-validate">
									<?= input_text('config_email_host','', '', 'required') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">Port</label>
								<div class="col-md-9 pristine-validate">
									<?= input_text('config_email_port','') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">SMTP Secure</label>
								<div class="col-md-9 pristine-validate">
									<?= input_text('config_email_smptsecure','', '', '') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">SMTP Auth</label>
								<div class="col-md-9 pristine-validate">
									<?= select('config_email_smtpauth',['TRUE'=>'TRUE','FALSE'=>'FALSE'],'',  'form-select') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">Username</label>
								<div class="col-md-9 pristine-validate">
									<?= input_text('config_email_username','', '', '') ?>
								</div>
							</div>
							<div class="row form-group mb-5">
								<label class="col-md-3 mb-3 m-md-auto">Password</label>
								<div class="col-md-9 pristine-validate">
									<?= input_password('config_email_password','', '', '') ?>
								</div>
							</div>
				    </div>
				</div>
		 	</div>
		 </div>
	</form>
	
	<div class="card-footer d-flex align-items-center justify-content-center">
		<button type="submit" form="form-data" class="btn-save btn btn-info ms-0 me-md-2  font-weight-bolder"><i class="bi bi-save"></i> Save Configuration</button>
	</div>
</div>
<?=contentClose()?>

<?= $this->endSection() ?>


<?= $this->section('javascript') ?>
<script src="/assets/plugins/ckeditor/build/ckeditor.js"></script>
<script type="text/javascript">
let pristine;
pristine = new Pristine(elFormData,pristineConfig);  
elFormData.addEventListener('submit', function (e) {
    var valid = pristine.validate();
    e.preventDefault();
    if(valid)
    {
      saveData('return').then(resp=>{
		for(el of elFormData.querySelectorAll('.is-valid'))
		{
			el.classList.remove('is-valid');
		}
      });
    }
});

let ckEditorFootnote;
BalloonEditor.create(document.querySelector('#editor-footnote'),{
	placeholder: 'Masukkan footnote...',
  updateSourceElementOnDestroy: true,
}).then(editor => {
	 ckEditorFootnote = editor;
   editor.model.document.on('change:data', (evt, data) => {
        document.querySelector('[name=config_email_footnote]').value = editor.getData();
  });
}).catch(error => {
    console.error(error);
});
let ckEditorFooter;
BalloonEditor.create(document.querySelector('#editor-footer'),{
	placeholder: 'Masukkan footer...',
  updateSourceElementOnDestroy: true,
}).then(editor => {
	 ckEditorFooter = editor;
   editor.model.document.on('change:data', (evt, data) => {
        document.querySelector('[name=config_email_footer]').value = editor.getData();
  });
}).catch(error => {
    console.error(error);
});

let elDetailData = document.querySelector('.detail-data');
let loadData = async () => {
	getData().then((resp)=>{
		let row = resp[0];
		id = row.id;
		for(i in row)
		{
			let el = elDetailData.querySelector(`[name=${i}]`);
			if(el!=null)
			{
				el.value = row[i];
			}
		}
   	ckEditorFootnote.setData(row.config_email_footnote??'');
   	ckEditorFooter.setData(row.config_email_footer??'');
	});
}
loadData();

</script>
<?= $this->endSection() ?>