<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>[]
])?>
<!--begin::Card header-->
    <!--begin::Tabs-->
    <ul class="card-title pt-3 mb-0 gap-4 gap-lg-10 gap-xl-15 nav nav-tabs nav-line-tabs mb-5">
         <li class="nav-item">
	        <a class="nav-link active" data-bs-toggle="tab" href="#info">Web Information</a>
	    </li>
	    <li class="nav-item">
	        <a class="nav-link" data-bs-toggle="tab" href="#logo">Icon & Logo</a>
	    </li>
	    <li class="nav-item">
	        <a class="nav-link" data-bs-toggle="tab" href="#seo">SEO Optimation</a>
	    </li>
	    <li class="nav-item">
	        <a class="nav-link" data-bs-toggle="tab" href="#setting">Settings</a>
	    </li>
        <!--end::Tab item-->
    </ul>
    <!--end::Tabs-->
    <!--end::Create campaign button-->
	<form id="form-data" class="detail-data">
		<?= input_hidden('id', '') ?>
		<?= input_hidden('config_web_icon_light', '', '', '') ?>
		<?= input_hidden('config_web_icon_dark', '', '', '') ?>
		<?= input_hidden('config_web_logo_light', '', '', '') ?>
		<?= input_hidden('config_web_logo_dark', '', '', '') ?>
		 <!--begin::Dropzone-->
		 <div class="row">
		 	<div class="col-md-2"></div>
		 	<div class="col-md-8">
				<div class="tab-content" id="myTabContent">
				    <div class="tab-pane fade show active" id="info" role="tabpanel">
				       <?=view('Dashboard/Configweb/Loads/InfoView');?>
				    </div>
				    <div class="tab-pane fade" id="logo" role="tabpanel">
				       <?=view('Dashboard/Configweb/Loads/LogoView');?>
				    </div>
				    <div class="tab-pane fade" id="seo" role="tabpanel">
				       <?=view('Dashboard/Configweb/Loads/SeoView');?>
				    </div>
				    <div class="tab-pane fade" id="setting" role="tabpanel">
				       <?=view('Dashboard/Configweb/Loads/SettingView');?>
				    </div>
				</div>
		 	</div>
		 </div>
	</form>
	<div class="card-footer d-flex align-items-center justify-content-center">
		<button type="submit" form="form-data" class="btn-save btn btn-info ms-0 me-md-2  font-weight-bolder"><i class="bi bi-save"></i> Save Configuration</button>
	</div>
<?=contentClose()?>

<?= $this->endSection() ?>


<?= $this->section('javascript') ?>
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

let elBtnIconLight = document.querySelector('.btn-lihat-icon-light');
let elBtnIconDark = document.querySelector('.btn-lihat-icon-dark');
let elBtnLogoLight = document.querySelector('.btn-lihat-logo-light');
let elBtnLogoDark = document.querySelector('.btn-lihat-logo-dark');
let elDetailData = document.querySelector('.detail-data');
let loadData = async () => {
	getData().then((resp)=>{
		let row = resp[0];
		id = row.id;
		for(i in row)
		{
			let el = elDetailData.querySelector(`[name=${i}]`);
			if(i!='config_web_icon_light_url' && i!='config_web_icon_dark_url' && i!='config_web_logo_light_url' && i!='config_web_logo_dark_url')
			{
				if(el!=null)
				{
					el.value = row[i];
				}
			}
			else
			{
				let el = elDetailData.querySelector(`.${i}`);
				el.href = row[i];
			}
		}
	});
}
loadData();
let dzUploader = (el,target) => {
	Dropzone.autoDiscover = false;
	let myDropzoneLogo = new Dropzone(`${el}`, {
			url: `${apiUrl}restful/upload/configweb`,
	    	paramName: "file",
			maxFiles:1,
			maxFilesize: 1,
			acceptedFiles: "image/jpeg,image/png",
		    addRemoveLinks: true,
		    init: function() {
				this.on("error", function(file, message) { 
					this.removeFile(file); 
					Swal.fire({
						title: 'Error',
						html: message,
						icon: 'error'
					});
				});
			},
			success: async (file, resp) => {
				target.value = resp.file; 
				document.querySelector('button[form="form-data"]').click();
				loadData();
				Swal.fire({
					title: 'Success',
					html: resp.message,
					icon: 'success'
				});
			}
		});
		myDropzoneLogo.on("complete", function(file) {
	  	myDropzoneLogo.removeFile(file);
	});
}
dzUploader('#upload-icon-light',document.querySelector('[name=config_web_icon_light]'));
dzUploader('#upload-icon-dark',document.querySelector('[name=config_web_icon_dark]'));
dzUploader('#upload-logo-light',document.querySelector('[name=config_web_logo_light]'));
dzUploader('#upload-logo-dark',document.querySelector('[name=config_web_logo_dark]'));

</script>
<?= $this->endSection() ?>