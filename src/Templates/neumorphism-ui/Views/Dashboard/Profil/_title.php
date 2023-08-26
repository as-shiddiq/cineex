
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
      // $rowMember = $MemberModel->withAddons()
      //                     ->select('IFNULL(((SELECT SUM(x.topup_nilai) as total FROM topup x WHERE x.member_id=member.id AND topup_status="A")-(SELECT SUM(x.usage_nilai) as total FROM `usage` x WHERE x.member_id=member.id AND usage_status="S")),0) as ballance')
      //                     ->where('pengguna_id',$auth->id)->first();  
    }
?>  
<div class="card mb-5 mb-xl-10">
  <div class="card-body pt-9 pb-0">
    <!--begin::Details-->
    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
      <!--begin: Pic-->
      <div class="me-7 mb-4">
        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
          <img src="<?=uploads('pengguna',$rowPengguna->pengguna_foto)?>" alt="image" />
          <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
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
            <div class="d-flex align-items-center mb-2">
              <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1"><?=$rowPengguna->pengguna_nama?></a>
            </div>
            <!--end::Name-->
            <!--begin::Info-->
            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
              <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
              <span class=" me-1 bi bi-check-circle"></span><?=$rowPengguna->pengguna_level_nama?></a>
              <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
              <span class="bi bi-envelope me-1"></span><?=$rowPengguna->pengguna_email??'null@admin.com'?></a>
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
    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
      <!--begin::Nav item-->
      <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?=$activeOverview??''?>" href="<?=site_url('dashboard/profil/index'.$setId)?>">Overview</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?=$activeSetting??''?>" href="<?=site_url('dashboard/profil/setting'.$setId)?>">Settings</a>
      </li>

      <?php if($rowPengguna->pengguna_level_nama=='Member') {
      ?>
      <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?=$activeBilling??''?>" href="<?=site_url('dashboard/profil/billing'.$setId)?>">Billing</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?=$activeUsage??''?>" href="<?=site_url('dashboard/profil/usage'.$setId)?>">Usage</a>
      </li>

      <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#">Statements</a>
      </li>
      <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#">Referrals</a>
      </li>
      <li class="nav-item mt-2">
        <a href="<?=site_url('dashboard/profil/apikey'.$setId)?>" class="nav-link text-active-primary ms-0 me-10 py-5 <?=$activeApikey??''?>" href="#">API Key</a>
      </li>
      <?php
      }                                
        ?>
      <!-- <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="#">Logs</a>
      </li> -->
      <!--end::Nav item-->
    </ul>
    <!--begin::Navs-->
  </div>
</div>
