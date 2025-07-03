
<?php 
    $auth = auth();
    $setId = '';
    $setWhere = '';
    if($penggunaId!='' && $auth->pengguna_level_nama=='Administrator' )
    {
      $PenggunaModel = new \App\Models\PenggunaModel();
      $rowPengguna = $PenggunaModel->withAddons()->where('pengguna.id',$penggunaId)->first();
    }
    else
    {
      $rowPengguna = $auth;
    }
?>  
<div class="card mb-3">
  <div class="card-body pt-0 pb-0">
    <!--begin::Details-->
    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
      <!--begin: Pic-->
      <div class=" mr-3">
        <div class=" position-relative">
          <img src="<?=uploads('pengguna',$rowPengguna->pengguna_foto)?>" alt="image" width="80px" class="rounded"/>
          <div class="position-absolute translate-middle bottom-0 start-100 mb-3 bg-success rounded-circle border border-4 border-white h-20px w-20px" style="margin-left: -20px;"></div>
        </div>
      </div>
      <!--end::Pic-->
      <!--begin::Info-->
      <div class="flex-grow-1">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
          <!--begin::User-->
          <div class="d-flex flex-column">
            <!--begin::Name-->
            <div class="d-flex align-items-center mb-1">
              <a href="#" class="text-gray-900 text-hover-primary fw-bolder me-1" style="font-size: 20px;font-weight: bold;"><?=$rowPengguna->pengguna_nama?></a>
            </div>
            <!--end::Name-->
            <!--begin::Info-->
            <div class="d-flex flex-wrap fw-bold pe-2" style="gap:10px">
              <a href="#" class="d-flex align-items-center text-hover-primary mr-3 mb-2">
              <span class=" mr-1 bi bi-check-circle"></span><?=$rowPengguna->pengguna_level_nama?></a>
              <a href="#" class="d-flex align-items-center text-hover-primary mb-2">
              <span class="bi bi-envelope mr-1"></span><?=$rowPengguna->pengguna_email??'null@admin.com'?></a>
            </div>
          <?php if (isset($auth->has)): ?>
          <div class="alert bg-light-primary border border-primary border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-5">
            <div class="d-flex flex-column pe-0 pe-sm-10">
            <?php foreach ($auth->has as $key => $value): ?>
            <?php endforeach ?>
            </div>
          </div>
          <?php endif ?>
            <!--end::Info-->
          </div>
          <!--end::User-->
          <!--begin::Actions-->
        </div>
        <!--end::Title-->
        <!--begin::Stats-->
        <div class="d-flex flex-wrap flex-stack">
          <!--begin::Wrapper-->
          <div class="d-flex flex-column flex-grow-1 pe-8">
            <!--begin::Stats-->
            <div class="d-flex flex-wrap">
              <!--begin::Stat-->
              <?php if($rowPengguna->pengguna_level_nama=='Member') { ?>
              <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                <!--begin::Number-->
                  <?php
                    $ContactModel = new \App\Models\ContactModel();
                    $rowContact = $ContactModel->select('COUNT(*) as total')
                                              ->where('member_id',$rowMember->id)
                                              ->first();
                  ?>
                <div class="d-flex align-items-center">
                  <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                  <span class="bi bi-person-rolodex text-danger me-2"></span>
                  <!--end::Svg Icon-->
                  <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?=$rowContact->total?>">0</div>
                </div>
                <!--end::Number-->
                <!--begin::Label-->
                <div class="fw-bold fs-6 text-gray-400">Kontak</div>
                <!--end::Label-->
              </div>
              <?php
                $SendModel = new \App\Models\SendModel();
                $rowSend = $SendModel->select('COUNT(*) as total')
                                          ->where('member_id',$rowMember->id)
                                          ->where('sent_at IS NOT NULL')
                                          ->first();
              ?>
              <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                <!--begin::Number-->
                <div class="d-flex align-items-center">
                  <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                  <span class="bi bi-reply text-success me-2"></span>
                  <!--end::Svg Icon-->
                  <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?=$rowSend->total?>" data-kt-countup-prefix="">0</div>
                </div>
                <!--end::Number-->
                <!--begin::Label-->
                <div class="fw-bold fs-6 text-gray-400">Sent Chat</div>
                <!--end::Label-->
              </div>
              <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                <div class="d-flex align-items-center">
                  <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                  <span class="bi bi-wallet text-success me-2"></span>
                  <!--end::Svg Icon-->
                  <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?=$rowMember->ballance?>" data-kt-countup-prefix="Rp">0</div>
                </div>
                <div class="fw-bold fs-6 text-gray-400">Saldo</div>
                <!--end::Label-->
              </div>
              <?php } ?>
              <!--end::Stat-->
            </div>
            <!--end::Stats-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Stats-->
      </div>
      <!--end::Info-->
    </div>
    <!--end::Details-->
    <!--begin::Navs-->
    <div class="d-flex align-items-center justify-content-left mt-5" style="gap: 10px;">
      <!--begin::Nav item-->
        <a class="btn btn-primary ms-0 me-10 py-2 <?=$activeOverview??''?>" href="<?=site_url('dashboard/profil/index'.$setId)?>">Overview</a>
        <a class="btn btn-primary ms-0 me-10 py-2 <?=$activeSetting??''?>" href="<?=site_url('dashboard/profil/setting'.$setId)?>">Settings</a>
      <!--end::Nav item-->
    </div>
    <!--begin::Navs-->
  </div>
</div>
