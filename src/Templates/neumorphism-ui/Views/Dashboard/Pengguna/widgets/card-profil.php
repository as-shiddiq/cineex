<?php 
$auth  = auth();
?>
<!--begin::Engage widget 3-->
<div class="card card-xxl-stretch h-100 bgi-no-repeat" style="background-color: #020c05; background-position: 0 calc(100% + 0.5rem); background-size: 100% auto; background-image:url('/templates/<?=getenv('cineex.template.dashboard')?>/assets/media/svg/general/rhone.svg')">
	<!--begin::Body-->
	<div class="card-body">

		<img src="<?=uploads('pengguna','','user.jpg')?>" class="rounded rounded-circle h-150px" style="border: 10px solid #fff6;">
		<h3 class="text-white fw-bold fs-2x mt-7"><?=$auth->pengguna_nama??''?></h3>
		<h5 class="text-white fw-bold mb-7"><?=$auth->pengguna_level_nama??''?></h5>
      <?php if (isset($auth->has)): ?>
		<?php foreach ($auth->has as $key => $value): ?>
          <?php if ($key!='id'): ?>
          <p class="text-muted"><?=$value?></p>
          <?php endif ?>
        <?php endforeach ?>
      <?php endif ?>
		<p class="text-muted fs-6 mb-7"></p>
		<a href="/dashboard/profil" class="btn btn-danger gw-bold px-6 py-3">Profil</a>
	</div>
	<!--end::Body-->
</div>