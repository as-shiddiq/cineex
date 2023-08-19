<?= $this->extend('DashboardView') ?>
<?= $this->section('content') ?>
<!--begin::Row--><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
  .image-input label.btn {
    position: absolute;
    top: -12px;
    right: -12px;
  }

</style>
<style type="text/css">
    .user-profile .hovercard .user-image .avatar{
        margin-top: 0;
    }
    .user-profile .hovercard .user-image .icon-wrapper{
      left: 54%;
    }
</style>
<?php 
    $activeSetting = 'active';
?>  
<?=contentOpen([
  'title' => $title,
  'page' => $page,
  'url' => $url,
])?>
<?php include '_title.php'?>
  <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
      <!--begin::Card header-->
      <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
          <h3 class="fw-bolder m-0"><?=$page?></h3>
        </div>
        <!--begin::Action-->
      </div>
      <!--begin::Card header-->
      <!--begin::Card body-->
      <div class="card-body p-9">
        <!--begin::Form-->
        <form id="form-data" class="form">
          <!--begin::Card body-->
          <?=input_hidden('id','')?>
          <?=input_hidden('pengguna_foto','')?>
            <!--begin::Input group-->
            <div class="row mb-6">
              <!--begin::Label-->
              <label class="col-lg-4 col-form-label fw-bold fs-6">Foto Profil</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-lg-8">
                <!--begin::Image input-->
                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('/templates/metronic/assets/media/svg/avatars/blank.svg')">
                  <!--begin::Preview existing avatar-->
                  <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?=uploads('pengguna',$auth->pengguna_foto)?>)"></div>
                  <!--end::Preview existing avatar-->
                  <!--begin::Label-->
                  <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip"  onclick="showModal()"  title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <!--begin::Inputs-->
                  </label>
                  <!--end::Label-->
                  <!--begin::Cancel-->
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="bi bi-x fs-2"></i>
                  </span>
                  <!--end::Cancel-->
                  <!--begin::Remove-->
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="bi bi-x fs-2"></i>
                  </span>
                  <!--end::Remove-->
                </div>
                <!--end::Image input-->
                <!--begin::Hint-->
                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                <!--end::Hint-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-6 ">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Nama lengkap</label>
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-12 fv-row pristine-validate">
                    <?=input_text('pengguna_nama','','form-control-solid','required')?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Username</label>
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-12 fv-row pristine-validate">
                    <?=input_text('pengguna_username','','form-control-solid','required')?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-bold fs-6">Password</label>
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-12 fv-row pristine-validate">
                    <div class="position-relative mb-3">
                      <?=input_password('pengguna_password','','form-control-solid','id="pwd"')?>
                      <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility" onclick="showPw(this,'pengguna_password')">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                      </span>
                    </div>
                    <div class="form-text">Kosongkan jika tidak mengubah password.</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Ulangi password</label>
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-12 fv-row pristine-validate">
                      <?=input_password('ulangi_password','','form-control-solid','placeholder="" name="confirm-password" autocomplete="off" data-pristine-equals="#pwd" data-pristine-equals-message="Passwords don\'t match"')?>
                    <div class="form-text">Isi sesuai dengan perubahan password.</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-bold fs-6"></label>
              <div class="col-lg-8">

              <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                  </svg>
                </span>
                <div class="d-flex flex-stack flex-grow-1">
                  <div class="fw-bold">
                    <h4 class="text-gray-900 fw-bolder">Perhatian!</h4>
                    <div class="fs-6 text-gray-700">Silakan masukkan password untuk mengkonfirmasi perubahan</div>
                    <div class="row mb-6 mt-3 pristine-validate">
                      <label class="col-lg-4 col-form-label required fw-bold fs-6">Ulangi Password</label>
                      <div class="col-lg-8">
                        <div class="row">
                          <div class="col-lg-12 fv-row">
                            <div class="position-relative mb-3">
                              <?=input_password('konfirmasi_password','','form-control-solid','required')?>
                              <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" onclick="showPw(this,'konfirmasi_password')">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              </div>
            <!--end::Input group-->
          <!--end::Card body-->
          <!--begin::Actions-->
          <!--end::Actions-->
        </form>
        <!--end::Form-->
      <!--end::Content-->
    </div>

    <div class="card-footer d-flex justify-content-end py-6 px-9">
          <?=cardToolbar(['save','reset'])?>
    </div>
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
        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
          <span class="bi bi-x"></span>
        </div>
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
  // elBtnBack.href = document.referrer;

  let elImageInputWrapper = document.querySelector('.image-input-wrapper');
  let elPenggunaUsername = document.querySelector('[name=pengguna_username]');
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
                elImageInputWrapper.setAttribute('style',`background:url('${ resp.images_url}');background-size:cover`)
                Swal.fire({
                    icon: 'success',
                    title: resp.message
                });
            }
            });
        });
    });
    id = '<?=$auth->id?>';
    let getDataThis = () => {
      getData(id,'pengguna').then(resp=>{
          let data = resp[0];
          for(i in data)
          {
              let el = elFormData.querySelector(`[name=${i}]`);
              if(el!=null)
              {
                  el.value = data[i];
              }
          }

          for(el of elAvatarImg)
          {
            el.src = data.pengguna_foto_url;
          }
      });
    }
    getDataThis();
    elBtnReset.addEventListener('click',()=>{
      getDataThis();
    });

    
    let pristine;

    elPenggunaUsername.addEventListener('input', async (e) => {
      let get = await fetch(`${apiUrl}profil/checkunique`,{
      method : 'POST',
      body: `pengguna_username=${e.target.value}`,
              headers: {
                 'Content-Type':'application/x-www-form-urlencoded',
              }
          });
          let resp = await get.json();
          if (!resp.isReady) {
              pristine.addError(elPenggunaUsername, "Username sudah digunakan");
          }
      });

    pristine = new Pristine(elFormData,pristineConfig);  

    elFormData.addEventListener('submit', function (e) {
        var valid = pristine.validate();
        e.preventDefault();
        if(valid)
        {
          saveData('return',id,'',null,`${apiUrl}profil/update`).then((resp)=>{
            if(resp.status==200)
            {
              Swal.fire({
                icon:'success',
                title: 'Sukses',
                html : resp.message
              }).then((result)=>{
                 window.location = `${siteUrl}profil`;
              });

            }
            else
            {
              Swal.fire({
                icon:'error',
                title: 'Error',
                html : resp.message
              });
            }
          });
        }
    });

</script>

<?= $this->endSection() ?>