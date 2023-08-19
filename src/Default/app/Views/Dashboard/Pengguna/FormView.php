<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style type="text/css">
	.upload-croppie-wrap,
	.upload-croppie.ready .upload-msg {
		display: none;
	}

	.upload-croppie.ready .upload-croppie-wrap {
		display: block;
	}

	.upload-croppie-wrap {
		width: 100%;
		height: 300px;
		margin: 0 auto;
		border: 1px solid #e4e6ef;
		border-radius: .42rem;
	}

	.croppie-container .cr-boundary {
		border-radius: .42rem;
		border: 1px solid #e4e6ef;
	}

	.upload-msg {
		font-size: 1rem;
		text-align: center;
		color: #888;
		display: flex;
		justify-content: center;
		align-items: center;
		width: 100%;
		height: 300px;
		padding: 1rem 2rem;
		border-radius: .42rem;
		border: 1px solid #e4e6ef;
	}
	.image-input {
		box-shadow: 0 0.2rem 1rem 0.2rem rgb(0 0 0 / 5%);
		width: 100%;
		position: relative;
		padding: .5rem;
	    border-radius: 1.15rem;
	    margin-bottom: 1rem;
	}
	.image-input img{
		width: 100%;
	}
	.btn-shadow{
		box-shadow: 0 0.5rem 1.5rem 0.5rem rgb(0 0 0 / 8%);
	}
	.image-input label.btn {
		position: absolute;
		top: -12px;
		right: -12px;
	}

</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Card-->
<!--begin::Card-->
<?=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>['back']
])?>
				<!--begin: Datatable-->
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-3 pe-5">
				<div class="image-input" >
					<img src="/assets/images/default.png" class="pengguna_foto">
					<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" onclick="showModal()" data-action="change" data-toggle="tooltip" title="" data-original-title="Ganti Foto">
						<i class="bi bi-pencil icon-md text-muted"></i>
					</label>
				</div>
				<span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
			</div>
			<div class="col-md-7">
				<form id="form-data">
					<?= input_hidden('id', $id ?? '') ?>
					<?= input_hidden('pengguna_foto', '', '', '') ?>
					
					<div class="row form-group mb-5">
						<label class="col-md-3 mb-3 m-md-auto">Nama lengkap</label>
						<div class="col-md-9 pristine-validate">
							<?= input_text('pengguna_nama','', '', 'required') ?>
						</div>
					</div>
					<div class="row form-group mb-5">
						<label class="col-md-3 mb-3 m-md-auto">Level</label>
						<div class="col-md-9 pristine-validate">
							<?php 
								$PenggunalevelModel = new \App\Models\PenggunalevelModel();
								$op = null;
								$op[''] = '--Pilih salah satu--';
								foreach ($PenggunalevelModel->findAll() as $row) {
									$op[$row->id] = $row->pengguna_level_nama;
								}
							?>
							<?=select('pengguna_level_id',$op,'','')?>
						</div>
					</div>
					<div class="row form-group mb-5">
						<label class="col-md-3 mb-3 m-md-auto">Username</label>
						<div class="col-md-9 pristine-validate">
							<?= input_text('pengguna_username','', '', 'required') ?>
						</div>
					</div>
					<div class="row form-group mb-5">
						<label class="col-md-3 mb-3 m-md-auto">Password</label>
						<div class="col-md-9 pristine-validate">
							<?= input_password('pengguna_password', '', '', '') ?>
						</div>
					</div>
					<div class="row form-group mb-5">
						<label class="col-md-3 mb-3 m-md-auto">Email</label>
						<div class="col-md-9 pristine-validate">
							<?= input_text('pengguna_email', '', '', 'required') ?>
						</div>
					</div>
					<div class="row form-group mb-5">
						<label class="col-md-3 mb-3 m-md-auto">No. HP</label>
						<div class="col-md-9 pristine-validate">
							<?= input_text('pengguna_hp', '', '', 'required') ?>
						</div>
					</div>
					<div class="row form-group mb-5">
						<label class="col-md-3 mb-3 m-md-auto">Status</label>
						<div class="col-md-9 pristine-validate">
							<?=select('pengguna_status',[
								'A' => 'Aktif',
								'N' => 'Tidak Aktif',
								'B' => 'Blokir',
							],'','')?>
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

	<!--begin::Modal - Create account-->
	<div class="modal fade" id="modal-upload" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Modal header-->
				<div class="modal-header">
					<h3>Foto Profil</h3>
					 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
				</div>
				<!--end::Modal header-->
				<!--begin::Modal body-->
				<div class="modal-body">
					<div class="upload-croppie">
						<div class="form-group mb-3">
							<div class="custom-file">
								<input type="file" id="upload" class="form-control" value="Choose a file" accept="image/*" />
							</div>
						</div>
						<div class="form-group">
							<div class="upload-msg">
								Pilih foto dan Klik Atur Sebagai Foto Profil
							</div>
							<div class="upload-croppie-wrap">
								<div id="croppie"></div>
							</div>
						</div>
						<div class="form-group mb-3">
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button class="upload-result btn btn-primary d-none" type="button">Upload</button>
        			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
				<!--end::Modal body-->
			</div>
			<!--end::Modal content-->
		</div>
		<!--end::Modal dialog-->
	</div>
	<!--end::Modal - Create project-->
	<!-- end:Modal-->
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

	let myModal = new bootstrap.Modal(document.getElementById('modal-upload'), {
	  keyboard: false
	})
	let showModal = () => {
		myModal.show();
	}

	let elAvatarImg = document.querySelectorAll('img.pengguna_foto');
    //croppie
    var uploadCrop = new Croppie(document.querySelector('#croppie'),{
        viewport: {
            width: 250,
            height: 250,
        },
        showZoomer: false,
    });

    //upload 
    let upload = document.querySelector('#upload');
    let btnUploadresult = document.querySelector('.upload-result');

    upload.addEventListener('change',()=>{
    if (upload.files && upload.files[0]) {
            var reader = new FileReader();
            reader.onload = (e) => {
	            document.querySelector('.upload-croppie').classList.add('ready');
	            btnUploadresult.classList.remove('d-none');
	            uploadCrop.bind({
	                url: e.target.result
	            }).then(()=>{
	                console.log('bind complete');
	            });
        	}
            
            reader.readAsDataURL(upload.files[0]);
            btnUploadresult.classList.remove('d-none')
        }
        else {
          Swal.fire({
                  icon: 'error',
                  title: 'Browser kamu tidak mendukung untuk FileReader API, silahkan Upgrade segera'
          });
        }
    });

    // upload procces
    btnUploadresult.addEventListener('click',()=>
    {
        uploadCrop.result('base64').then(function(base64) {
            fetch(apiUrl+'restful/base64image/pengguna',{
            method : "POST",
            body: 'file='+base64,
            headers: {
                'Content-Type':'application/x-www-form-urlencoded'
                }
            }).then(resp => resp.json())
            .then(resp => {
            if(resp.status==200)
            {
            	document.querySelector('[data-bs-dismiss="modal"]').click();
                document.querySelector("[name=pengguna_foto]").value = resp.images;
                upload.value = '';
                uploadCrop.destroy();
                console.log(resp)
                for(el of elAvatarImg)
                {
                  el.src = resp.images_url;
                }
                Swal.fire({
                    icon: 'success',
                    title: resp.message
                });
            }
            });
        });
    });


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

	            let opt = new Option(data.satuan_nama, data.satuan_id, false,false);
	            $("[name=satuan_id]").append(opt).trigger('change');
	            opt = new Option(data.kategori_nama, data.kategori_id, false,false);
	            $("[name=kategori_id]").append(opt).trigger('change');
	            for(el of elAvatarImg)
	            {
	              el.src = data.pengguna_foto_url;
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