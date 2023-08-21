<?= $this->extend('DashboardView') ?>

<?= $this->section('content') ?>
<!--begin::Row-->
<style type="text/css">
    .user-profile .hovercard .user-image .avatar{
        margin-top: 0;
    }
    .user-profile .hovercard .user-image .icon-wrapper{
      left: 54%;
    }
</style>
<?php 
    $activeOverview = 'active';
?>  
<?=contentOpen([
  'title' => $title,
  'page' => $page,
  'url' => $url,
])?>
<?php include '_title.php'?>
    <!--begin::details View-->
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
      <!--begin::Card header-->
      <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
          <h3 class="fw-bolder m-0">Profile Details</h3>
        </div>
        <!--end::Card title-->
        <!--begin::Action-->
        <a href="/dashboard/profil/setting" class="btn btn-primary btn-sm align-self-center">Edit Profile</a>
        <!--end::Action-->
      </div>
      <!--begin::Card header-->
      <!--begin::Card body-->
      <div class="card-body p-9">
        <!--begin::Row-->
        <div class="row mb-7">
          <!--begin::Label-->
          <label class="col-lg-4 fw-bold text-muted">Full Name</label>
          <!--end::Label-->
          <!--begin::Col-->
          <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800"><?=$rowPengguna->pengguna_nama?></span>
          </div>
          <!--end::Col-->
        </div>
        <!--begin::Row-->
        <div class="row mb-7">
          <!--begin::Label-->
          <label class="col-lg-4 fw-bold text-muted">Username</label>
          <!--end::Label-->
          <!--begin::Col-->
          <div class="col-lg-8">
            <span class="fw-bolder fs-6 text-gray-800"><?=$rowPengguna->pengguna_username?></span>
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Input group-->
        <div class="row mb-7">
          <!--begin::Label-->
          <label class="col-lg-4 fw-bold text-muted">Email</label>
          <!--end::Label-->
          <!--begin::Col-->
          <div class="col-lg-8 fv-row">
            <span class="fw-bold text-gray-800 fs-6"><?=$rowPengguna->pengguna_email??'-'?></span>
          </div>
          <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row mb-7">
          <!--begin::Label-->
          <label class="col-lg-4 fw-bold text-muted">Contact Phone</label>
          <!--end::Label-->
          <!--begin::Col-->
          <div class="col-lg-8 d-flex align-items-center">
            <span class="fw-bolder fs-6 text-gray-800 me-2"><?=$rowPengguna->pengguna_hp??'-'?></span>
          </div>
          <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row mb-7">
          <!--begin::Label-->
          <label class="col-lg-4 fw-bold text-muted">User Level</label>
          <!--end::Label-->
          <!--begin::Col-->
          <div class="col-lg-8">
            <a href="#" class="fw-bold fs-6 text-gray-800 text-hover-primary"><?=$rowPengguna->pengguna_level_nama?></a>
          </div>
          <!--end::Col-->
        </div>
        
        <div class="row mb-7">
          <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">Terdaftar pada</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
              <span class="fw-bolder fs-6 text-gray-800"><?=dateTimeToStandarTanggal($rowPengguna->created_at,TRUE)?></span>
            </div>
          <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Notice-->
        <!-- <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
          <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
              <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
              <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
            </svg>
          </span> -->
          <!-- <div class="d-flex flex-stack flex-grow-1">
            <div class="fw-bold">
              <h4 class="text-gray-900 fw-bolder">We need your attention!</h4>
              <div class="fs-6 text-gray-700">Your payment was declined. To start using tools, please 
              <a class="fw-bolder" href="/metronic8/demo12/../demo12/account/billing.html">Add Payment Method</a>.</div>
            </div>
          </div> -->
        <!-- </div> -->
        <!--end::Notice-->
      </div>
      <!--end::Card body-->
    </div>
<?=contentClose()?>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<script type="text/javascript">
  // elBtnBack.href = document.referrer;
</script>
<?= $this->endSection() ?>